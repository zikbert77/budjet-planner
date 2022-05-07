<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\forms\PlannerCategoryForm;
use yii\widgets\Pjax;

/**
 * @var PlannerCategoryForm $model
 */

$planner = $model->getPlanner();
$category = $model->getCategory();
?>

<div class="modal fade" id="plannerCategoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"><?= $category->title ?? 'Створити нову категорію' ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>
                    Доступно: <b>
                        <span id="planner-available-amount"><?= $planner->getAvailableAmount() ?></span>грн.
                    </b> (<span id="planner-available-percent"><?= $planner->getAvailableAmountPercent() ?></span>%)
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
        let categoryAmount =  <?= $category->amount ?? 0 ?>;
        let categoryPercent = <?= $category ? $category->getUsedPlannerPercent() : 0 ?>;
        let availableAmount = <?= (float)$planner->getAvailableAmount() ?>;
        let availableAmountPercent = <?= (float)$planner->getAvailableAmountPercent() ?>;
        let amountLimit = availableAmount + categoryAmount;
        let percentLimit = availableAmountPercent + categoryPercent;

        $("#percent").on('input', function () {
            calculateAmountField($(this).val())
            calculatePlannerAvailableAmount($("#amount").val())
            calculatePlannerAvailablePercent($(this).val())
        });

        $("#amount").on('input', function () {
            calculatePercentField($(this).val())
            calculatePlannerAvailableAmount($(this).val());
        });

        function calculatePlannerAvailableAmount(amount) {
            $('#planner-available-amount').html(formatOutput(categoryAmount + availableAmount - amount));
        }

        function calculatePlannerAvailablePercent(percent) {
            $('#planner-available-percent').html(formatOutput(availableAmountPercent + categoryPercent - percent))
        }

        function calculateAmountField(percent) {
            let amount = (<?= (float)$planner->amount ?> * percent) / 100;
            if (amount > amountLimit) {
                amount = amountLimit;
                $("#percent").val(formatOutput(availableAmountPercent))
            }

            $("#amount").val(formatOutput(amount))
        }

        function calculatePercentField(amount) {
            let percent = (amount * 100) / <?= (float)$planner->amount ?>;
            if (percent > percentLimit) {
                percent = percentLimit;
                $("#amount").val(formatOutput(availableAmount))
            }

            calculatePlannerAvailablePercent(percent);

            $("#percent").val(formatOutput(percent))
        }

        function formatOutput(number) {
            return Math.round(number)
        }
    })
</script>