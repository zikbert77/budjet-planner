<?php

/**
 * @var yii\web\View $this
 * @var UserPlanner $planner
 * @var View $this
 */

use app\models\UserPlanner;
use yii\helpers\Url;
use yii\web\View;


$this->title = 'Planner';
?>

<div class="container">
    <div class="row">
       <div class="col col-5">
           <h3><?= $planner->title ?></h3>
           <br>
           <span class="d-block">
               Бюджет: <span class="small text-muted"><?= $planner->amount ?>₴</span>
           </span>
           <span class="d-block">
               Використано: <span class="small text-muted"><?= $planner->used_amount ?>₴ (<?= 100 - $planner->getAvailableAmountPercent() ?>%)</span>
           </span>
           <span class="d-block">
               Доступно: <span class="small text-muted"><?= $planner->getAvailableAmount() ?>₴ (<?= $planner->getAvailableAmountPercent() ?>%)</span>
           </span>
           <br>
           <div>
               <div class="chart">
                   <div>
                       <canvas id="myChart"></canvas>
                   </div>
               </div>
           </div>
       </div>
        <div class="col col-2"></div>
        <div class="col col-5">
            <div class="row">
                <div>
                    <h3 class="float-left">Категорії</h3>
                    <span class="add-category custom-link float-right">
                        + Додати категорію
                    </span>
                </div>
            </div>
            <div class="clear"></div>
            <div class="categories-box">
                <div class="row">
                    <?php
                        $i = 0;
                        /** @var \app\models\PlannerCategory $category */
                        foreach ($planner->getCategories()->all() as $category):
                    ?>
                        <div class="col" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="
                            <?= $category->title ?><br>
                            Виділено: <?= $category->amount ?>₴ (<?= $category->percent ?>%)<br>
                            Використано: <?= (int)$category->used_amount ?>₴<br>
                            Доступно: <?= $category->getLeftAmount() ?>₴
                        ">
                            <div class="category text-center" data-id="<?= $category->id ?>">
                                <div class="category-pic">
                                    <span class="left small">
                                        <?= $category->getLeftAmount() ?>₴
                                    </span>
                                    <div class="used" style="height: <?= 75 - round(($category->getLeftAmount() * 75) / $category->amount) ?>px;"></div>
                                </div>
                                <span class="title small">
                                    <?= $category->title ?>
                                </span><br>
                                <span class="category-percent text-muted"><?= $category->percent ?>%</span>
                                <span class="category-amount text-muted"> | <?= $category->amount ?>₴</span>
                            </div>
                        </div>
                        <?php if ($i % 4 == 0 && $i > 0): ?>
                            <div class="clear"></div>
                        <?php endif; ?>
                    <?php
                        $i++;
                        endforeach;
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="expenses">
        <h3>Витрати</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Категорія</th>
                    <th>Cума</th>
                    <th>Опис</th>
                    <th>Дата</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($planner->getExpenses() as $expense): ?>
                    <tr>
                        <td><?= $expense->id ?></td>
                        <td><?= $expense->category->title ?></td>
                        <td><?= $expense->amount ?></td>
                        <td><?= empty($expense->description) ? '-' : $expense->description ?></td>
                        <td><?= $expense->created_at ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="modalWrapper"></div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        buildChart();
        $('.add-category').click(function () {
            $.ajax({
                url: '<?= Url::toRoute(['/planner/new-planner-category-modal', 'plannerId' => $planner->id])?>',
                data: {},
                success: function (response) {
                    $('#modalWrapper').html(response)
                    let modal = new bootstrap.Modal($("#plannerCategoryModal"), {})
                    modal.toggle();
                },
            });
        });

        $('.category').click(function () {
            $.ajax({
                url: '<?= Url::toRoute(['/planner/planner-category-expense'])?>?categoryId=' + $(this).data('id'),
                data: {},
                success: function (response) {
                    $('#modalWrapper').html(response)
                    let modal = new bootstrap.Modal($("#plannerCategoryExpenseModal"), {})
                    modal.toggle();
                },
            });
        });

        function buildChart() {
            $.ajax({
                url: '<?= Url::toRoute(['/planner/get-chart-data', 'plannerId' => $planner->id])?>',
                data: {},
                dataType: 'json',
                success: function (response) {
                    const data = {
                        labels: response.labels,
                        datasets: [{
                            label: 'My First dataset',
                            backgroundColor: response.colors,
                            borderColor: 'white',
                            data: response.data,
                        }]
                    };

                    const myChart = new Chart(
                        document.getElementById('myChart'),
                        {
                            type: 'doughnut',
                            data: data,
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    title: {
                                        display: true,
                                        text: 'Графік розпреділення бюджету'
                                    }
                                }
                            },
                        }
                    );
                },
            });
        }
    })
</script>
