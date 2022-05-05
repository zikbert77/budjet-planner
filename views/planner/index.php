<?php

/**
 * @var yii\web\View $this
 * @var UserPlanner $planner
 */

use app\models\UserPlanner;
use yii\helpers\Url;


$this->title = 'Planner';
?>

<div class="container">
    <div class="wallets">
        <div class="wallet">
            <span class="title">Mono - USD</span><br>
            <span class="balance small text-muted">$1000</span>
        </div>
        <div class="wallet">
            <span class="title">PayPal</span><br>
            <span class="balance small text-muted">$799</span>
        </div>

        <div class="add-new-wallet">
            + Додати гаманець
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
       <div class="col col-5">
           <h3><?= $planner->amount ?> грн.</h3>
           <small class="text-muted">$5000 ~ 30.0</small>
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
            <div class="text-center">
                <span class="add-category">
                    + Додати категорію
                </span>
            </div>
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
                            <div class="category text-center">
                                <div class="category-pic">
                                    <span class="left small">
                                        <?= $category->getLeftAmount() ?>
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
</div>

<div id="plannerCategoryModalWrapper"></div>

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script></body>
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
                    $('#plannerCategoryModalWrapper').html(response)
                    let modal = new bootstrap.Modal($("#plannerCategoryModal"), {})
                    modal.toggle();
                },
            });
        });

        $('.category').click(function () {
            $.ajax({
                url: '<?= Url::toRoute(['/planner/planner-category-modal', 'plannerId' => $planner->id])?>',
                data: {},
                success: function (response) {
                    $('#plannerCategoryModalWrapper').html(response)
                    let modal = new bootstrap.Modal($("#plannerCategoryModal"), {})
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
