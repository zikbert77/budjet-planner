<?php

namespace app\models\forms;

use app\models\UserPlanner;
use Yii;
use yii\base\Model;

class PlannerForm extends Model
{
    public $title;
    public $plannerId;
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
        $planner = new UserPlanner();
        $planner->title = $this->title;
        $planner->amount = $this->amount;
        $planner->user_id = Yii::$app->user->id;
        if (!$planner->validate()) {
            return false;
        }

        if (!$planner->save()) {
            return false;
        }

        $planner->refresh();
        $this->plannerId = $planner->id;

        return true;
    }
}