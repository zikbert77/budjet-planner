<?php

/**
 * @var yii\web\View $this
 * @var UserPlanner[] $planners
 */

use app\models\UserPlanner;
use yii\helpers\Url;

$this->title = 'My Yii Application';
?>

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

<?= $this->render('//layouts/_wallet') ?>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="create-new-planner custom-link">
                + Створити новий планер
            </div>
        </div>
        <div class="clear"></div>
        <?php foreach ($planners as $planner): ?>
            <div class="col col-3 planner-col">
                <a href="<?= Url::toRoute(['/planner', 'id' => $planner->id]) ?>">
                    <div class="planner">
                        <span class="d-block"><b><?= $planner->title ?></b></span><br>
                        <span class="small d-inline-block">Бюджет: <?= $planner->amount ?>₴</span>
                        <span class="small d-inline-block">
                            Використано: <?= $planner->used_amount ?>₴ (<?= 100 - $planner->getAvailableAmountPercent() ?>%)
                        </span>
                        <br>
                        <br>
                        <span class="date text-muted">Дата створення: <?= $planner->created_at ?></span>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div id="newPlannerModalWrapper"></div>
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
</body>