<?php

use app\models\PlannerCategory;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var PlannerCategory $model
 */
?>

<div class="modal fade" id="plannerCategoryActionsModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"><?= $model->title ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <span class="custom-link" id="action-add-expense">
                    Додати витрату
                </span>
                <span class="custom-link">
                    Редагувати категорію
                </span>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#action-add-expense').click(function () {
            $('.btn-close').click();
            $.ajax({
                url: '<?= Url::toRoute(['/planner/planner-category-expense', 'categoryId' => $model->id])?>',
                data: {},
                success: function (response) {
                    $('#modalWrapper').html(response)
                    let modal = new bootstrap.Modal($("#plannerCategoryExpenseModal"), {})
                    modal.toggle();
                },
            });
        });
    })
</script>