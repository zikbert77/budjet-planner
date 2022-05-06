<?php

use app\models\forms\PlannerCategoryExpenseForm;
use app\models\PlannerCategory;
use app\models\UserPlanner;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/**
 * @var PlannerCategoryExpenseForm $model
 * @var PlannerCategory $category
 * @var UserPlanner $planner
 */
?>

<div class="modal fade" id="plannerCategoryExpenseModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"><?= $category->title ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>
                    Доступно: <b><?= $planner->getAvailableAmount() ?> грн.</b> (<?= $planner->getAvailableAmountPercent() ?>%)
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
                    ->textInput(['id' => 'amount', 'autofocus' => true])
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