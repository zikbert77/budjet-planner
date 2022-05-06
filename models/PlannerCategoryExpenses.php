<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%planner_category_expenses}}".
 *
 * @property int $id
 * @property int $category_id
 * @property int|null $amount
 * @property string $description
 * @property string|null $created_at
 *
 * @property PlannerCategory $category
 */
class PlannerCategoryExpenses extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%planner_category_expenses}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['category_id'], 'required'],
            [['category_id', 'amount'], 'integer'],
            [['created_at', 'description'], 'safe'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => PlannerCategory::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'amount' => 'Amount',
            'created_at' => 'Created At',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(PlannerCategory::class, ['id' => 'category_id']);
    }
}
