<?php

namespace app\models\forms;

use app\models\PlannerCategory;
use app\models\PlannerCategoryExpenses;
use app\models\UserPlanner;
use yii\base\Model;

class PlannerCategoryExpenseForm extends Model
{
    public $description;
    public $amount = null;

    /** @var PlannerCategory */
    private $category;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            ['title', 'trim'],
            ['description', 'trim'],
            ['amount', 'trim'],
            ['title, amount', 'required'],
            ['description', 'safe'],
            ['title', 'string', 'max' => 30, 'min' => 3]
        ];
    }

    public function save(): bool
    {
        $expense = new PlannerCategoryExpenses();
        $expense->amount = $this->amount;
        $expense->description = $this->description;
        $expense->category_id = $this->category->id;
        if (!$expense->validate()) {
            $this->addError('amount', $expense->getFirstError('amount'));
            return false;
        }

        if ($expense->save()) {
            $this->category->used_amount += $this->amount;
            $this->category->save(false);
        }

        return true;
    }

    public function setCategory($id)
    {
        $this->category = PlannerCategory::findOne($id);
    }

    public function getCategory(): PlannerCategory
    {
        return $this->category;
    }

}