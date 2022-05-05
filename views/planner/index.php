<?php

/**
 * @var yii\web\View $this
 * @var UserPlanner $planner
 */

use app\models\UserPlanner;
use yii\helpers\Url;


$this->title = 'Planner';
?>

<div class="container">
    <div class="wallets">
        <div class="wallet">
            <span class="title">Mono - USD</span><br>
            <span class="balance small text-muted">$1000</span>
        </div>
        <div class="wallet">
            <span class="title">PayPal</span><br>
            <span class="balance small text-muted">$799</span>
        </div>

        <div class="add-new-wallet">
            + Додати гаманець
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
       <div class="col">
           <h3><?= $planner->amount ?> грн.</h3>
           <small class="text-muted">$5000 ~ 30.0</small>
           <div>Графік</div>
       </div>
        <div class="col">
            <div class="text-center">
                <span class="add-category">
                    + Додати категорію
                </span>
            </div>
            <div class="categories-box">
                <div class="row">
                    <?php foreach ($planner->getCategories()->all() as $category): ?>
                    <div class="col">
                        <div class="category text-center">
                            <div class="category-pic">
                                <span class="left">100$</span>
                                <div class="used"></div>
                            </div>
                            <span class="title">
                                <?= $category->title ?>
                            </span><br>
                            <span class="category-percent small"><?= $category->percent ?>%</span>
                            <span class="category-amount small"> | <?= $category->amount ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="plannerCategoryModalWrapper"></div>

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script></body>

<script>
    $(document).ready(function () {
        $('.add-category').click(function () {
            $.ajax({
                url: '<?= Url::toRoute(['/planner/new-planner-category-modal', 'plannerId' => $planner->id])?>',
                data: {},
                success: function (response) {
                    $('#plannerCategoryModalWrapper').html(response)
                    let modal = new bootstrap.Modal($("#plannerCategoryModal"), {})
                    modal.toggle();
                },
            });
        });

        $('.category').click(function () {
            $.ajax({
                url: '<?= Url::toRoute(['/planner/planner-category-modal', 'plannerId' => $planner->id])?>',
                data: {},
                success: function (response) {
                    $('#plannerCategoryModalWrapper').html(response)
                    let modal = new bootstrap.Modal($("#plannerCategoryModal"), {})
                    modal.toggle();
                },
            });
        })
    })
</script>
