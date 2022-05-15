<?php
/** @var User $user */

use app\models\User;
use yii\helpers\Url;

$user = $this->context->userModel;
?>
<div class="container">
    <div class="wallets">
        <?php foreach ($user->getWallets()->all() as $wallet): ?>
        <div class="wallet">
            <span class="title"><?= $wallet->title ?></span><br>
            <span class="balance small text-muted">$<?= $wallet->amount ?></span>
        </div>
        <?php endforeach; ?>
        <div class="action-add-new-wallet">
            + Додати гаманець
        </div>
    </div>
</div>

<div id="wallet-modal-wrapper"></div>

<script>
    $(document).ready(function () {
        $('.action-add-new-wallet').click(function () {
            $.ajax({
                url: '<?= Url::toRoute(['/planner/wallet-modal'])?>',
                data: {},
                success: function (response) {
                    $('#wallet-modal-wrapper').html(response)
                    let modal = new bootstrap.Modal($("#walletModal"), {})
                    modal.toggle();
                },
            });
        });
    })
</script>
