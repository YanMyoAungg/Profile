<?php

/**
 * DB management script for this project.
 *
 * Usage:
 *  php scripts/manage_db.php create   # create database and tables (idempotent)
 *  php scripts/manage_db.php reset    # reset tables (truncate + reseed)
 *  php scripts/manage_db.php status   # show status
 *
 * Environment variables (optional): DB_HOST, DB_USER, DB_PASS, DB_NAME
 */

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

$host = $_ENV['DB_HOST'] ?? '127.0.0.1';
$user = $_ENV['DB_USER'] ?? 'root';
$pass = $_ENV['DB_PASS'] ?? 'zenith172421';
$dbname = $_ENV['DB_NAME'] ?? 'food_fusion';

$action = $argv[1] ?? 'status';

function connectPDO($host, $user, $pass, $useDb = false, $dbname = '')
{
    $dsn = "mysql:host={$host};charset=utf8mb4";
    if ($useDb && $dbname) {
        $dsn .= ";dbname={$dbname}";
    }
    try {
        return new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    } catch (PDOException $e) {
        fwrite(STDERR, "PDO connection failed: " . $e->getMessage() . PHP_EOL);
        exit(1);
    }
}

function dbExists($pdo, $dbname)
{
    $stmt = $pdo->prepare('SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = :db');
    $stmt->execute(['db' => $dbname]);
    return (bool) $stmt->fetchColumn();
}

function tableExists($pdo, $dbname, $table)
{
    $stmt = $pdo->prepare('SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = :db AND TABLE_NAME = :table');
    $stmt->execute(['db' => $dbname, 'table' => $table]);
    return (bool) $stmt->fetchColumn();
}

function createSchema($pdo, $dbname)
{
    $created = [];
    // roles table
    if (!tableExists($pdo, $dbname, 'roles')) {
        $sql = "CREATE TABLE roles (
          id INT AUTO_INCREMENT PRIMARY KEY,
          name VARCHAR(100),
          value VARCHAR(50)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $pdo->exec($sql);
        $created[] = 'roles';
    }

    // users table
    if (!tableExists($pdo, $dbname, 'users')) {
        $sql = "CREATE TABLE users (
          id INT AUTO_INCREMENT PRIMARY KEY,
          first_name VARCHAR(100),
          last_name VARCHAR(100),
          username VARCHAR(100) UNIQUE,
          email VARCHAR(255) UNIQUE,
          phone VARCHAR(100),
          address TEXT,
          password VARCHAR(255),
          role_id INT,
          photo VARCHAR(255) DEFAULT NULL,
          suspended TINYINT(1) DEFAULT 0,
          created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
          updated_at DATETIME DEFAULT NULL,
          FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $pdo->exec($sql);
        $created[] = 'users';
    }
    // recipes table
    if (!tableExists($pdo, $dbname, 'recipes')) {
        $sql = "CREATE TABLE recipes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            image VARCHAR(255),
            difficulty ENUM('Easy', 'Medium', 'Hard') DEFAULT 'Medium',
            prep_time INT COMMENT 'Preparation time in minutes',
            ingredients TEXT NOT NULL,
            instructions TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $pdo->exec($sql);
        $created[] = 'recipes';
    }

    // community_recipes table
    if (!tableExists($pdo, $dbname, 'community_recipes')) {
        $sql = "CREATE TABLE community_recipes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            ingredients TEXT NOT NULL,
            instructions TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $pdo->exec($sql);
        $created[] = 'community_recipes';
    }

    // contacts table
    if (!tableExists($pdo, $dbname, 'contacts')) {
        $sql = "CREATE TABLE contacts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            message TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $pdo->exec($sql);
        $created[] = 'contacts';
    }

    // resources table
    if (!tableExists($pdo, $dbname, 'resources')) {
        $sql = "CREATE TABLE resources (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            type ENUM('culinary', 'educational') NOT NULL,
            file_path VARCHAR(255) NOT NULL,
            description TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $pdo->exec($sql);
        $created[] = 'resources';
    }

    return $created;
}

function seedRoles($pdo, $dbname)
{
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM roles');
    $stmt->execute();
    $count = (int) $stmt->fetchColumn();
    if ($count === 0) {
        $ins = $pdo->prepare('INSERT INTO roles (id, name, value) VALUES (:id, :name, :value)');
        $defaults = [
            ['id' => 1, 'name' => 'User', 'value' => '1'],
            ['id' => 2, 'name' => 'Manager', 'value' => '2'],
            ['id' => 3, 'name' => 'Admin', 'value' => '3'],
        ];
        foreach ($defaults as $r) {
            $ins->execute($r);
        }
        return true;
    }
    return false;
}

function seedRecipes($pdo, $dbname)
{
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM recipes');
    $stmt->execute();
    $count = (int) $stmt->fetchColumn();
    if ($count === 0) {
        $ins = $pdo->prepare("INSERT INTO recipes (title, description, image, difficulty, prep_time, ingredients, instructions) VALUES (:title, :description, :image, :difficulty, :prep_time, :ingredients, :instructions)");
        $recipes = [
            [
                'title' => 'Classic Spaghetti Bolognese',
                'description' => 'A rich and hearty meat sauce served over spaghetti.',
                'image' => 'resources/spaghetti.png',
                'difficulty' => 'Medium',
                'prep_time' => 45,
                'ingredients' => "1 lb spaghetti\n1 lb ground beef\n1 onion, chopped\n2 cloves garlic, minced\n1 can crushed tomatoes\nSalt and pepper",
                'instructions' => "1. Cook spaghetti according to package instructions.\n2. Brown beef in a pan.\n3. Add onions and garlic, cook until soft.\n4. Add tomatoes and simmer for 20 mins.\n5. Serve sauce over pasta."
            ],
            [
                'title' => 'Fresh Garden Salad',
                'description' => 'A refreshing mix of seasonal vegetables with a light vinaigrette.',
                'image' => 'resources/salad.png',
                'difficulty' => 'Easy',
                'prep_time' => 15,
                'ingredients' => "Mixed greens\nCherry tomatoes\nCucumber\nRed onion\nOlive oil\nBalsamic vinegar",
                'instructions' => "1. Wash and chop all vegetables.\n2. Toss in a large bowl.\n3. Drizzle with oil and vinegar just before serving."
            ],
            [
                'title' => 'Chocolate Lava Cake',
                'description' => 'Decadent chocolate cake with a molten center.',
                'image' => 'resources/cake.png',
                'difficulty' => 'Hard',
                'prep_time' => 30,
                'ingredients' => "1/2 cup butter\n4 oz chocolate\n2 eggs\n2 egg yolks\n1/4 cup sugar\n2 tbsp flour",
                'instructions' => "1. Melt butter and chocolate.\n2. Whisk eggs and sugar until pale.\n3. Fold in chocolate mixture and flour.\n4. Pour into ramekins and bake at 425F for 13 mins."
            ]
        ];
        foreach ($recipes as $r) {
            $ins->execute($r);
        }
        return true;
    }
    return false;
}

function seedResources($pdo, $dbname)
{
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM resources');
    $stmt->execute();
    $count = (int) $stmt->fetchColumn();
    if ($count === 0) {
        $ins = $pdo->prepare("INSERT INTO resources (title, type, file_path, description) VALUES (:title, :type, :file_path, :description)");
        $resources = [
            [
                'title' => 'Basic Knife Skills Guide',
                'type' => 'culinary',
                'file_path' => 'resources/knife_skills.pdf',
                'description' => 'A comprehensive guide to mastering the most important tool in the kitchen.'
            ],
            [
                'title' => 'Mastering Mother Sauces',
                'type' => 'culinary',
                'file_path' => 'resources/mother_sauces.pdf',
                'description' => 'Learn how to make the five foundational sauces of French cuisine.'
            ],
            [
                'title' => 'Baking Techniques',
                'type' => 'culinary',
                'file_path' => 'resources/baking_techniques.pdf',
                'description' => 'Master the art of pastry and bread making with professional techniques.'
            ],
            [
                'title' => 'Spice Blending & Seasoning',
                'type' => 'culinary',
                'file_path' => 'resources/spice_blending.pdf',
                'description' => 'Discover the secrets of creating perfect spice blends and seasoning combinations.'
            ],
            [
                'title' => 'Nutrition and Healthy Eating',
                'type' => 'educational',
                'file_path' => 'resources/nutrition_guide.pdf',
                'description' => 'An educational manual on balanced diets and nutritional values.'
            ],
            [
                'title' => 'Food Safety Standards',
                'type' => 'educational',
                'file_path' => 'resources/food_safety.pdf',
                'description' => 'Important guidelines for maintaining a safe and hygienic kitchen environment.'
            ],
            [
                'title' => 'Understanding Food Allergies',
                'type' => 'educational',
                'file_path' => 'resources/food_allergies.pdf',
                'description' => 'Comprehensive guide to identifying and managing common food allergies in cooking.'
            ],
            [
                'title' => 'Sustainable Cooking Practices',
                'type' => 'educational',
                'file_path' => 'resources/sustainable_cooking.pdf',
                'description' => 'Learn eco-friendly cooking methods and reduce food waste in your kitchen.'
            ]
        ];
        foreach ($resources as $r) {
            $ins->execute($r);
        }
        return true;
    }
    return false;
}

if ($action === 'create') {
    $pdo = connectPDO($host, $user, $pass, false);
    if (!dbExists($pdo, $dbname)) {
        $pdo->exec("CREATE DATABASE `{$dbname}` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
        echo "Database '$dbname' created.\n";
    }

    $pdoDb = connectPDO($host, $user, $pass, true, $dbname);
    $created = createSchema($pdoDb, $dbname);
    if ($created)
        echo "Created tables: " . implode(', ', $created) . "\n";

    if (seedRoles($pdoDb, $dbname))
        echo "Seeded roles.\n";
    if (seedRecipes($pdoDb, $dbname))
        echo "Seeded recipes.\n";
    if (seedResources($pdoDb, $dbname))
        echo "Seeded resources.\n";

    exit(0);
} elseif ($action === 'reset') {
    $pdo = connectPDO($host, $user, $pass, true, $dbname);
    $tables = ['community_recipes', 'contacts', 'resources', 'recipes', 'users', 'roles'];
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
    foreach ($tables as $t) {
        if (tableExists($pdo, $dbname, $t)) {
            $pdo->exec("TRUNCATE TABLE `{$t}`");
            echo "Truncated '$t'.\n";
        }
    }
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');
    seedRoles($pdo, $dbname);
    seedRecipes($pdo, $dbname);
    seedResources($pdo, $dbname);
    echo "Reset and re-seeded.\n";
    exit(0);
} elseif ($action === 'status') {
    $pdo = connectPDO($host, $user, $pass, false);
    if (dbExists($pdo, $dbname)) {
        $pdoDb = connectPDO($host, $user, $pass, true, $dbname);
        $tables = ['roles', 'users', 'recipes', 'community_recipes', 'contacts', 'resources'];
        foreach ($tables as $t) {
            echo "Table '$t': " . (tableExists($pdoDb, $dbname, $t) ? 'OK' : 'MISSING') . "\n";
        }
    } else {
        echo "Database missing.\n";
    }
    exit(0);
} else {
    echo "Usage: php manage_db.php create|reset|status\n";
    exit(1);
}
