<?php
session_start();
include("vendor/autoload.php");

use Libs\Database\Mysql;
use Libs\Database\ResourcesTable;

$table = new ResourcesTable(new Mysql());
$resources = $table->getByType('culinary');

include('header.php');
include('navbar.php');
?>

<div class="container mt-5">
    <h1 class="text-center mb-5">Culinary Resources</h1>
    <p class="text-center text-muted mb-5">Downloadable guides and documents to improve your cooking skills.</p>

    <div class="row">
        <?php if (count($resources) > 0): ?>
            <?php foreach ($resources as $res): ?>
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-file-earmark-pdf fs-1 text-danger me-3"></i>
                                <h5 class="card-title mb-0"><?= htmlspecialchars($res->title) ?></h5>
                            </div>
                            <p class="card-text text-muted"><?= htmlspecialchars($res->description) ?></p>
                            <a href="<?= htmlspecialchars($res->file_path) ?>" class="btn btn-outline-secondary " download>
                                <i class="bi bi-download"></i> Download Resource
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <h3 class="text-muted">No culinary resources available at the moment.</h3>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include('footer.php'); ?>