<?php

namespace app\controllers;

use app\models\forms\PlannerCategoryForm;
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

    public function actionGetChartData($plannerId)
    {
        $data = [];
        $planner = UserPlanner::findOne($plannerId);
        /** @var PlannerCategory $category */
        foreach ($planner->getCategories()->all() as $category) {
            $data['labels'][] = $category->title;
            $data['data'][] = $category->percent;
            $data['colors'][] = 'orange';
        }

        if ($planner->getAvailableAmountPercent() > 0) {
            $data['labels'][] = 'Не використано';
            $data['data'][] = $planner->getAvailableAmountPercent();
            $data['colors'][] = 'lightgray';
        }

        return json_encode($data);
    }
}