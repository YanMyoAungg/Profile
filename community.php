<?php
session_start();
include("vendor/autoload.php");

use Libs\Database\Mysql;
use Libs\Database\CommunityRecipesTable;
use Libs\Database\CommentsTable;

$table = new CommunityRecipesTable(new Mysql());
$recipes = $table->getAll();

$commentsTable = new CommentsTable(new Mysql());

include('header.php');
include('navbar.php');
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1>Community Cookbook</h1>
        <?php if (isset($_SESSION['user'])): ?>
            <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addRecipeModal">
                <i class="bi bi-plus-circle"></i> Share Your Recipe
            </button>
        <?php else: ?>
            <a href="login.php" class="btn btn-secondary">Login to Share Recipes</a>
        <?php endif; ?>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php if ($_GET['success'] == 'comment_added'): ?>
                Comment added successfully!
            <?php else: ?>
                Recipe submitted successfully!
            <?php endif; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Please fill in all required fields.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php if (count($recipes) > 0): ?>
            <?php foreach ($recipes as $recipe): ?>
                <?php $comments = $commentsTable->getByRecipeId($recipe->id); ?>
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm border-0" style="background: #dadadaff">
                        <div class="card-body">
                            <h5 class="card-title text-black fw-bold"><?= htmlspecialchars($recipe->title) ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">By <?= htmlspecialchars($recipe->author_name) ?> <small>on
                                    <?= date('M d, Y', strtotime($recipe->created_at)) ?></small></h6>
                            <p class="card-text"><?= htmlspecialchars($recipe->description) ?></p>

                            <hr>

                            <h6>Ingredients:</h6>
                            <p class="small text-muted"><?= nl2br(htmlspecialchars($recipe->ingredients)) ?></p>

                            <h6>Instructions:</h6>
                            <p class="small text-muted"><?= nl2br(htmlspecialchars($recipe->instructions)) ?></p>

                            <hr>
                            
                            <button class="btn btn-sm btn-outline-dark mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#comments-<?= $recipe->id ?>" aria-expanded="false" aria-controls="comments-<?= $recipe->id ?>">
                                <i class="bi bi-chat-left-text"></i> Comments (<?= count($comments) ?>)
                            </button>
                            
                            <div class="collapse" id="comments-<?= $recipe->id ?>">
                                <div class="card card-body bg-light">
                                    <?php if (count($comments) > 0): ?>
                                        <ul class="list-unstyled mb-3">
                                            <?php foreach ($comments as $comment): ?>
                                                <li class="mb-2">
                                                    <strong><?= htmlspecialchars($comment->username) ?></strong>: 
                                                    <?= htmlspecialchars($comment->comment) ?>
                                                    <br>
                                                    <small class="text-muted"><?= date('M d, Y H:i', strtotime($comment->created_at)) ?></small>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <p class="small text-muted mb-3">No comments yet.</p>
                                    <?php endif; ?>

                                    <?php if (isset($_SESSION['user'])): ?>
                                        <form action="actions/add_comment.php" method="POST">
                                            <input type="hidden" name="recipe_id" value="<?= $recipe->id ?>">
                                            <div class="input-group input-group-sm">
                                                <textarea class="form-control" name="comment" placeholder="Add a comment..." required rows="1"></textarea>
                                                <button class="btn btn-dark" type="submit">Post</button>
                                            </div>
                                        </form>
                                    <?php else: ?>
                                        <p class="small text-muted"><a href="login.php">Login</a> to leave a comment.</p>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <h3 class="text-muted">No community recipes yet. Be the first to share!</h3>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Add Recipe Modal -->
<div class="modal fade" id="addRecipeModal" tabindex="-1" aria-labelledby="addRecipeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="addRecipeModalLabel">Share Your Recipe</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="actions/add_community_recipe.php" method="POST" style="background-color: #dadadaff;">
                <div class="modal-body" style="background-color: #dadadaff;">
                    <div class="mb-3">
                        <label for="title" class="form-label">Recipe Title *</label>
                        <input type="text" style="background-color: #faf3f3ff;" class="form-control" id="title"
                            name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description (Short summary)</label>
                        <textarea style="background-color: #faf3f3ff;" class="form-control" id="description"
                            name="description" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="ingredients" class="form-label">Ingredients * (List each on a new line)</label>
                        <textarea class="form-control" style="background-color: #faf3f3ff;" id="ingredients"
                            name="ingredients" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="instructions" class="form-label">Instructions *</label>
                        <textarea class="form-control" style="background-color: #faf3f3ff;" id="instructions"
                            name="instructions" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-dark">Submit Recipe</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>