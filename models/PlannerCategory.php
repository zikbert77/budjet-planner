<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%planner_category}}".
 *
 * @property int $id
 * @property string $title
 * @property float|null $percent
 * @property float|null $amount
 * @property float|null $used_amount
 * @property int $planner_id
 *
 * @property UserPlanner $planner
 */
class PlannerCategory extends ActiveRecord
{
    const COLORS = [
        '#ff9f40',
        '#ffcd55',
        '#36a2ec',
        '#4bc0c0',
        '#ff6384',
        '#9966ff',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%planner_category}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'planner_id'], 'required'],
            [['planner_id'], 'integer'],
            [['percent', 'amount', 'used_amount'], 'number'],
            [['title'], 'string', 'max' => 255],
            [['planner_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserPlanner::class, 'targetAttribute' => ['planner_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'percent' => 'Percent',
            'amount' => 'Amount',
            'used_amount' => 'Used Amount',
            'planner_id' => 'Planner ID',
        ];
    }

    /**
     * Gets query for [[Planner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlanner()
    {
        return $this->hasOne(UserPlanner::class, ['id' => 'planner_id']);
    }

    public function getLeftAmount(): float
    {
        return $this->amount - $this->used_amount;
    }

    public function getUsedPlannerPercent(): float
    {
        return ($this->amount * 100) / $this->planner->amount;
    }
}
