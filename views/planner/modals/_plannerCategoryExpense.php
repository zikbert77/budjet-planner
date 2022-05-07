<?php

use app\models\forms\PlannerCategoryExpenseForm;
use app\models\PlannerCategory;
use app\models\UserPlanner;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/**
 * @var PlannerCategoryExpenseForm $model
 * @var PlannerCategory $category
 * @var UserPlanner $planner
 */
?>

<div class="modal fade" id="plannerCategoryExpenseModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"><?= $category->title ?></h5>
                <span class="small" id="edit-category" style="display: inline-block;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Редгувати категорію</span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>
                    <span class="d-block">Доступно: <b><?= $category->getLeftAmount() ?> грн.</b></span>
                    <span class="d-block">Використано: <b><?= $category->used_amount ?> грн.</b></span>
                </p>

                <?php
                    Pjax::begin([
                        // Pjax options
                    ]);
                    $form = ActiveForm::begin([
                        'id' => 'form-create-expense',
                        'options' => ['data' => ['pjax' => true]],
                    ]);
                ?>

                <?= $form
                    ->field($model, 'amount')
                    ->textInput(['id' => 'amount', 'autofocus' => true, 'type' => 'number'])
                    ->label('Сума')
                ?>

                <?= $form
                    ->field($model, 'description')
                    ->textarea()
                    ->label('Опис')
                ?>
                <div class="form-group">
                    <?= Html::submitButton('Додати витрату', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
                <?php
                    ActiveForm::end();
                    Pjax::end();
                ?>
            </div>
        </div>
    </div>
</div>

<div id="modalWrapper"></div>

<script>
    $(document).ready(function () {
        $('#edit-category').click(function () {
            $('.btn-close').click();
            $.ajax({
                url: '<?= Url::toRoute(['/planner/planner-category-modal', 'id' => $category->id]) ?>',
                data: {},
                success: function (response) {
                    $('#modalWrapper').html(response)
                    let modal = new bootstrap.Modal($("#plannerCategoryModal"), {})
                    modal.toggle();
                },
            });
        });
    })
</script>