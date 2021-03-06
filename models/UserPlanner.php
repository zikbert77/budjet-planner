<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%user_planner}}".
 *
 * @property int $id
 * @property string $title
 * @property int $user_id
 * @property int $currency
 * @property float|null $amount
 * @property float|null $used_amount
 * @property string|null $created_at
 *
 * @property User $user
 */
class UserPlanner extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_planner}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['amount', 'used_amount'], 'number'],
            [['created_at'], 'safe'],
            [['title'], 'string', 'max' => 30],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
            'amount' => 'Amount',
            'used_amount' => 'Used Amount',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this
            ->hasMany(PlannerCategory::class, ['planner_id' => 'id'])
            ->orderBy(['percent' => SORT_DESC])
        ;
    }

    /**
     * @return PlannerCategoryExpenses[]
     */
    public function getExpenses(): array
    {
        return $this
            ->hasMany(PlannerCategoryExpenses::class, ['category_id' => 'id'])
            ->via('categories')
            ->orderBy(['created_at' => SORT_DESC])
            ->all()
        ;
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function updateUsedAmount()
    {
        $amount = $this
            ->getCategories()
            ->select('SUM(amount)')
            ->scalar()
        ;
        
        $this->used_amount = $amount;
        $this->save(false);
    }

    public function getAvailableAmount(): float
    {
        return $this->amount - $this->used_amount;
    }

    public function getAvailableAmountPercent(): float
    {
        return round((($this->amount - $this->used_amount) * 100) / $this->amount, 1);
    }
}
