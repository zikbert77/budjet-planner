<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\Wallet;

class WalletForm extends Model
{
    public $title;
    public $amount;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            ['title', 'trim'],
            ['title', 'required'],
            ['amount', 'required'],
            ['title', 'string', 'max' => 30, 'min' => 3]
        ];
    }

    public function save(): bool
    {
        $wallet = new Wallet();
        $wallet->title = $this->title;
        $wallet->amount = $this->amount;
        $wallet->user_id = Yii::$app->user->id;
        if (!$wallet->validate()) {
            return false;
        }

        if (!$wallet->save()) {
            return false;
        }

        return true;
    }
}