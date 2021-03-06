<?php

namespace app\models\forms;

use app\models\PlannerCategory;
use app\models\UserPlanner;
use yii\base\Model;

class PlannerCategoryForm extends Model
{
    public $title;
    public $percent = null;
    public $amount = null;

    /** @var UserPlanner */
    private $planner;

    /** @var PlannerCategory|null */
    private $category = null;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            ['title', 'trim'],
            ['percent', 'trim'],
            ['amount', 'trim'],
            ['title, plannerId', 'required'],
            ['title', 'string', 'max' => 30, 'min' => 3]
        ];
    }

    public function save(): bool
    {
        $category = $this->category ?? new PlannerCategory();
        $category->title = $this->title;
        $category->percent = $this->percent;
        $category->amount = $this->amount;
        $category->planner_id = $this->planner->id;
        if (!$category->validate() || !$this->checkPercentAmountFields()) {
            return false;
        }

        if ($category->save()) {
            $this->planner->updateUsedAmount();
        }

        return true;
    }

    public function setCategory(PlannerCategory $category)
    {
        $this->category = $category;
        $this->planner = $category->planner;
    }

    public function getCategory(): ?PlannerCategory
    {
        return $this->category;
    }

    public function setPlanner($id)
    {
        $this->planner = UserPlanner::findOne($id);
    }

    public function getPlanner(): UserPlanner
    {
        return $this->planner;
    }

    private function checkPercentAmountFields(): bool
    {
        if (empty($this->percent) && empty($this->amount)) {
            $this->addError('percent', 'Percent or amount must be filled');
        } else {
            if (!empty($this->percent) && (int)$this->percent > $this->planner->getAvailableAmountPercent()) {
                $this->addError('percent', 'Процент не може бути більшим за доступний.');
            }

            if (!empty($this->amount) && (int)$this->amount > $this->planner->getAvailableAmount()) {
                $this->addError('percent', 'Сума не може бути більшою за доступну.');
            }
        }

        return empty($this->errors) && !empty($this->percent) || !empty($this->amount);
    }

}