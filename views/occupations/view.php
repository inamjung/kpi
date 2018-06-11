<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Occupations */
?>
<div class="occupations-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
        ],
    ]) ?>

</div>
