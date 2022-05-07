<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\forms\PlannerCategoryForm;
use yii\widgets\Pjax;

/**
 * @var PlannerCategoryForm $model
 */
?>

<div class="modal fade" id="plannerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Створити новий планер</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                Pjax::begin([
                    // Pjax options
                ]);
                $form = ActiveForm::begin([
                    'id' => 'form-create-planner',
                    'options' => ['data' => ['pjax' => true]],
                ]);
                ?>

                <?= $form
                    ->field($model, 'title')
                    ->textInput(['autofocus' => true])
                    ->label('Назва')
                ?>
                <?= $form
                    ->field($model, 'amount')
                    ->textInput(['type' => 'number'])
                    ->label('Сума')
                ?>
                <div class="form-group">
                    <?= Html::submitButton('Створити', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
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