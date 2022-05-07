<?php

namespace app\controllers;

use app\models\forms\PlannerCategoryExpenseForm;
use app\models\forms\PlannerCategoryForm;
use app\models\forms\PlannerForm;
use app\models\PlannerCategory;
use app\models\UserPlanner;
use Yii;
use yii\web\Controller;

class PlannerController extends Controller
{
    public function actionIndex($id)
    {
        return $this->render('index', [
            'planner' => UserPlanner::findOne($id),
        ]);
    }

    public function actionWalletModal()
    {
        return $this->renderAjax('modals/_wallet');
    }

    public function actionNewPlannerModal()
    {
        $model = new PlannerForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['/planner', 'id' => $model->plannerId]);
            }
        }

        return $this->renderAjax('modals/_newPlanner', [
            'model' => $model
        ]);
    }

    public function actionNewPlannerCategoryModal($plannerId)
    {
        $model = new PlannerCategoryForm();
        $model->setPlanner($plannerId);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['/planner', 'id' => $plannerId]);
            }
        }

        return $this->renderAjax('modals/_plannerCategory', [
            'model' => $model
        ]);
    }

    public function actionPlannerCategoryModal($id)
    {
        $category = PlannerCategory::findOne($id);

        $model = new PlannerCategoryForm();
        $model->setAttributes($category->attributes);
        $model->setCategory($category);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['/planner', 'id' => $category->planner_id]);
            }
        }

        return $this->renderAjax('modals/_plannerCategory', [
            'model' => $model
        ]);
    }

    public function actionPlannerCategoryExpense($categoryId)
    {
        $category = PlannerCategory::findOne($categoryId);
        $planner = $category->getPlanner()->one();

        $model = new PlannerCategoryExpenseForm();
        $model->setCategory($categoryId);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['/planner', 'id' => $planner->id]);
            }
        }

        return $this->renderAjax('modals/_plannerCategoryExpense', [
            'category' => $category,
            'planner' => $planner,
            'model' => $model
        ]);
    }

    public function actionPlannerCategoryActions($id)
    {
        return $this->renderAjax('modals/_plannerCategoryActions', [
            'model' => PlannerCategory::findOne($id)
        ]);
    }

    public function actionGetChartData($plannerId)
    {
        $i = 0;
        $data = [];
        $planner = UserPlanner::findOne($plannerId);
        /** @var PlannerCategory $category */
        foreach ($planner->getCategories()->all() as $category) {
            $data['labels'][] = $category->title;
            $data['data'][] = $category->percent;
            $data['colors'][] = PlannerCategory::COLORS[$i];

            $i++;
            if ($i >= count(PlannerCategory::COLORS)) {
                $i = 0;
            }
        }

        if ($planner->getAvailableAmountPercent() > 0) {
            $data['labels'][] = 'Не використано';
            $data['data'][] = $planner->getAvailableAmountPercent();
            $data['colors'][] = '#c9cbcf';
        }

        return json_encode($data);
    }
}