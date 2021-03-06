<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\forms\WalletForm;
use yii\widgets\Pjax;

/**
 * @var WalletForm $model
 */
?>

<div class="modal fade" id="walletModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Створити новий планер</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                $form = ActiveForm::begin([
                    'id' => 'form-create-wallet',
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
                    <?= Html::submitButton('Створити', ['class' => 'btn btn-primary', 'id' => 'button-create-wallet', 'name' => 'signup-button']) ?>
                </div>
                <?php
                ActiveForm::end();
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
        $('#form-create-wallet').on('beforeSubmit', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            let data = $(this).serializeArray();
            $.ajax({
                url: '<?= Url::toRoute(['/planner/wallet-modal'])?>',
                data: data,
                type: 'POST',
                dataType: 'json'
            })
            .done(function(response) {
                console.log(response)
                console.log(response.status)
                if (response.status) {
                    console.log(11)
                    refreshWalletList();
                }

                $('.btn-close').click();
            })
            .fail(function() {
                console.log("error");
                $('.btn-close').click();
            });

            return false;
        })
    })
</script>