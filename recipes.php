<?php
session_start();
include("vendor/autoload.php");

use Libs\Database\Mysql;
use Libs\Database\RecipesTable;

$table = new RecipesTable(new Mysql());
$recipes = $table->getAll();

include('header.php');
include('navbar.php');
?>

<div class="container mt-5">
    <h1 class="text-center mb-5">Our Recipe Collection</h1>

    <div class="row">
        <?php foreach ($recipes as $recipe): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <?php if ($recipe->image): ?>
                        <img src="<?= htmlspecialchars($recipe->image) ?>" class="card-img-top"
                            alt="<?= htmlspecialchars($recipe->title) ?>">
                    <?php else: ?>
                        <img src="https://placehold.co/400x300?text=No+Image" class="card-img-top" alt="No Image">
                    <?php endif; ?>

                    <div class="card-body d-flex flex-column">
                        <div class="mb-2">
                            <span class="badge bg-<?php
                            echo match ($recipe->difficulty) {
                                'Easy' => 'success',
                                'Medium' => 'warning',
                                'Hard' => 'danger',
                                default => 'secondary'
                            };
                            ?>">
                                <?= htmlspecialchars($recipe->difficulty) ?>
                            </span>
                            <span class="badge bg-info text-dark">
                                <i class="bi bi-clock"></i> <?= htmlspecialchars($recipe->prep_time) ?> mins
                            </span>
                        </div>

                        <h5 class="card-title"><?= htmlspecialchars($recipe->title) ?></h5>
                        <p class="card-text text-truncate"><?= htmlspecialchars($recipe->description) ?></p>

                        <div class="mt-auto">
                            <button type="button" class="btn btn-outline-dark w-100" data-bs-toggle="modal"
                                data-bs-target="#recipeModal<?= $recipe->id ?>">
                                View Recipe
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recipe Modal -->
            <div class="modal fade" id="recipeModal<?= $recipe->id ?>" tabindex="-1"
                aria-labelledby="recipeModalLabel<?= $recipe->id ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="recipeModalLabel<?= $recipe->id ?>">
                                <?= htmlspecialchars($recipe->title) ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?php if ($recipe->image): ?>
                                <img src="<?= htmlspecialchars($recipe->image) ?>" class="img-fluid rounded mb-3"
                                    alt="<?= htmlspecialchars($recipe->title) ?>">
                            <?php endif; ?>

                            <p class="lead"><?= htmlspecialchars($recipe->description) ?></p>

                            <hr>

                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Ingredients:</h6>
                                    <ul class="list-group list-group-flush mb-3">
                                        <?php
                                        $ingredients = explode("\n", $recipe->ingredients);
                                        foreach ($ingredients as $ingredient):
                                            if (trim($ingredient)):
                                                ?>
                                                <li class="list-group-item"><?= htmlspecialchars($ingredient) ?></li>
                                            <?php
                                            endif;
                                        endforeach;
                                        ?>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>Instructions:</h6>
                                    <div class="bg-light p-3 rounded">
                                        <?= nl2br(htmlspecialchars($recipe->instructions)) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include('footer.php'); ?>