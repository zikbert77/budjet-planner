<?php

/**
 * @var yii\web\View $this
 * @var UserPlanner[] $planners
 */

use app\models\UserPlanner;
use yii\helpers\Url;

$this->title = 'My Yii Application';
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
        <div class="create-new-planner">
            + Create new Planner
        </div>
        <div class="planners-row">
            <?php foreach ($planners as $planner): ?>
                <a href="<?= \yii\helpers\Url::toRoute(['/planner', 'id' => $planner->id]) ?>">
                    <div class="planner">
                        <div class="title">
                            <?= $planner->title ?>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div id="newPlannerModalWrapper"></div>

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script></body>

<script>
    $(document).ready(function () {
        $('.create-new-planner').click(function () {
            $.ajax({
                url: '<?= Url::toRoute(['/planner/new-planner-modal'])?>',
                data: {},
                success: function (response) {
                    $('#newPlannerModalWrapper').html(response)
                    let modal = new bootstrap.Modal($("#plannerModal"), {})
                    modal.toggle();
                },
            });
        });
    })
</script>