<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\forms\PlannerCategoryForm;
use yii\widgets\Pjax;

/**
 * @var PlannerCategoryForm $model
 */
?>

<div class="modal fade" id="plannerCategoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Створити нову категорію</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>
                    Доступно: <b><?= $model->getPlanner()->getAvailableAmount() ?> грн.</b> (<?= $model->getPlanner()->getAvailableAmountPercent() ?>%)
                </p>

                <?php
                    Pjax::begin([
                        // Pjax options
                    ]);
                    $form = ActiveForm::begin([
                        'id' => 'form-create-category',
                        'options' => ['data' => ['pjax' => true]],
                    ]);
                ?>

                <?= $form
                    ->field($model, 'title')
                    ->textInput(['autofocus' => true])
                    ->label('Назва')
                ?>
                <?= $form
                    ->field($model, 'percent')
                    ->textInput(['id' => 'percent', 'type' => 'number'])
                    ->label('Відсоток')
                ?>
                <?= $form
                    ->field($model, 'amount')
                    ->textInput(['id' => 'amount', 'type' => 'number'])
                    ->label('Сума')
                ?>
                <div class="form-group">
                    <?= Html::submitButton('Зберегти', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
                <?php
                    ActiveForm::end();
                    Pjax::end();
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#percent").on('input', function () {
            calculateAmountField($(this).val())
        });

        $("#amount").on('input', function () {
            calculatePercentField($(this).val())
        });

        function calculateAmountField(percent) {
            let amount = (<?= (float)$model->getPlanner()->amount ?> * percent) / 100;
            if (amount > <?= (float)$model->getPlanner()->getAvailableAmount() ?>) {
                amount = <?= (float)$model->getPlanner()->getAvailableAmount() ?>;
                $("#percent").val(<?= (float)$model->getPlanner()->getAvailableAmountPercent() ?>)
            }

            $("#amount").val(amount)
        }

        function calculatePercentField(amount) {
            let percent = (amount * 100) / <?= (float)$model->getPlanner()->amount ?>;
            if (percent > <?= (float)$model->getPlanner()->getAvailableAmountPercent() ?>) {
                percent = <?= (float)$model->getPlanner()->getAvailableAmountPercent() ?>;
                $("#amount").val(<?= (float)$model->getPlanner()->getAvailableAmount() ?>)
            }

            $("#percent").val(percent)
        }
    })
</script>