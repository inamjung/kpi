<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\editable\Editable;
use yii\helpers\ArrayHelper;

return [
//    [
//        'class' => 'kartik\grid\CheckboxColumn',
//        'width' => '20px',
//    ],
//    [
//        'class' => 'kartik\grid\SerialColumn',
//        'width' => '30px',
//    ],
// [
// 'class'=>'\kartik\grid\DataColumn',
// 'attribute'=>'id',
// ],
//        [
//        'class' => '\kartik\grid\DataColumn',
//        'attribute' => 'kpi_id',
//        'header'=>'ตัวชี้วัด',    
//        'value' => function($model) {
//            $model = \app\modules\kpi\models\Kpi::find()->where(['id' => $model->kpi_id])->one();
//            return $model->kpiname;
//        },
//        //'width' => '80px',        
//        'hAlign' => 'left',
//        'vAlign' => 'middle',    
//    ],
        [//0
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'frequency_no',
        'header' => 'ครั้งที่',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '40px',
    ],
        [//1
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'd_end_result',
        'format' => 'raw',
        'value' => function($model) {
            return Yii::$app->thaiFormatter->asDate($model->d_end_result, 'php:d-m-Y');
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'width' => '90px',
    ],
//        [
//        'class' => '\kartik\grid\DataColumn',
//        'attribute' => 'goal',
//        'hAlign' => 'center',
//        'vAlign' => 'middle',
//    ],
//        [
//        'class' => '\kartik\grid\DataColumn',
//        'attribute' => 'target',
//        'header'=>'จำนวนกลุ่มเป้าหมาย', //ส่งมาจาก kpi   
//        'hAlign' => 'center',
//        'vAlign' => 'middle',
//        'pageSummary' => true,
//        'class' => 'kartik\grid\EditableColumn',
//        'refreshGrid' => true,
//        'editableOptions' => [
//            'asPopover' => true,
//            'formOptions' => [
//                'action' => \yii\helpers\Url::to(['/kpi/kpidata/editable']),
//                'method' => 'post'
//            ],
//            'valueIfNull' => '-',
//            'submitButton' => ['class' => 'btn btn-primary', 'icon' => '<i class="glyphicon glyphicon-ok"></i>'],
//            'resetButton' => ['class' => 'btn btn-warning', 'icon' => '<i class="glyphicon glyphicon-refresh"></i>'],
//        ],
//    ],       
    
        [//2
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'denom',
        'header' => 'ตัวตั้ง(จำนวนผลงาน ตัวเลข)',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'pageSummary' => true,
        'class' => 'kartik\grid\EditableColumn',
        'refreshGrid' => true,
        'editableOptions' => [
            'asPopover' => false,
            'formOptions' => [
                'action' => \yii\helpers\Url::to(['/kpi/kpidata/editable']),
                'method' => 'post'
            ],
            'valueIfNull' => '-',
            'submitButton' => ['class' => 'btn btn-primary', 'icon' => '<i class="glyphicon glyphicon-ok"></i>'],
            'resetButton' => ['class' => 'btn btn-warning', 'icon' => '<i class="glyphicon glyphicon-refresh"></i>'],
        ],
    ],
     [//3
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'devide',
        'header' => 'ตัวหาร(จำนวนเป้าหมาย ตัวเลข)',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'pageSummary' => true,
        'class' => 'kartik\grid\EditableColumn',
        'refreshGrid' => true,
        'editableOptions' => [
            'asPopover' => false,
            'formOptions' => [
                'action' => \yii\helpers\Url::to(['/kpi/kpidata/editable']),
                'method' => 'post'
            ],
            'valueIfNull' => '-',
            'submitButton' => ['class' => 'btn btn-primary', 'icon' => '<i class="glyphicon glyphicon-ok"></i>'],
            'resetButton' => ['class' => 'btn btn-warning', 'icon' => '<i class="glyphicon glyphicon-refresh"></i>'],
        ],
    ],           
        [//4
        'class' => 'kartik\grid\FormulaColumn',
        'header' => '<span style="color: #ff7f50;">ค่าผลลัพธ์(ผลงาน / เป้า)*100</span>',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function ($model, $key, $index, $widget) {
            $total = @($model->denom / $model->devide) * 100;
            return $total;
        },
        'headerOptions' => ['class' => 'kartik-sheet-style'],
        'format' => ['decimal', 2],
        'mergeHeader' => true,
        'pageSummary' => true,
        'footer' => true
    ],
        [
        'class' => 'kartik\grid\FormulaColumn',
        'header' => '<span style="color: #c031d0;">แปรผล</span>',
        'format' => 'raw',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'value' => function ($model, $key, $index, $widget) {
            $models = \app\modules\kpi\models\Kpi::find()->where(['id'=>$model->kpi_id])->one();
            $p = compact('model', 'key', 'index');
            $target = $widget->col(4, $p);
            
            //operation '>='
            if ($models->operation == '>=' && $target >= $model->goal) {
                return '<span style="color: green">ผ่าน </span><i style="color:green" class="glyphicon glyphicon-ok"></i>';
            } elseif ($models->operation == '>=' && $target > 0 && $target < $model->goal) {
                return '<span style="color: red">ไม่ผ่าน </span><i style="color:red" class="glyphicon glyphicon-remove"></i>';
            } elseif($model->denom == '') {
                return '<span style="color: #141415;">รอผล </span><i style="color: #141415" class="glyphicon glyphicon-repeat"></i>';
            
            //operation '<='    
            } elseif ($models->operation == '<=' && $target > $model->goal) {
                return '<span style="color: red">ไม่ผ่าน </span><i style="color:red" class="glyphicon glyphicon-remove"></i>';
            } elseif ($models->operation == '<=' && $target > 0 && $target <= $model->goal) {
                return '<span style="color: green">ผ่าน </span><i style="color:green" class="glyphicon glyphicon-ok"></i>';
                 
            }
        },
        'headerOptions' => ['class' => 'kartik-sheet-style'],
    ],
        [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'result_text',
        'header' => 'ผลงาน(ระบุตัวอักษร)',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'class' => 'kartik\grid\EditableColumn',
        'refreshGrid' => true,
        'editableOptions' => [
            'asPopover' => false,
            'formOptions' => [
                'action' => \yii\helpers\Url::to(['/kpi/kpidata/editable']),
                'method' => 'post'
            ],
            'valueIfNull' => '-',
            'submitButton' => ['class' => 'btn btn-primary', 'icon' => '<i class="glyphicon glyphicon-ok"></i>'],
            'resetButton' => ['class' => 'btn btn-warning', 'icon' => '<i class="glyphicon glyphicon-refresh"></i>'],
        ],
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'header'=>'หมายเหตุ',        
        'value'=> function($model){
             if($model->docs != ''&& $model->docs !='null'){
                return 
                Html::a('<i style="color: #2ddffd" class="glyphicon glyphicon-file"></i>',['/kpi/kpidata/viewdocs','id'=> $model->id],['role' => 'modal-remote','title'=>'ดูไฟล์']);
         }
        },                 
        'format' => 'raw',         
        'hAlign' => 'center',
        'vAlign' => 'middle',         
    ],             
                
            
//        [
//        'class' => '\kartik\grid\DataColumn',
//        'attribute' => 'calc',
//        'hAlign' => 'center',
//        'vAlign' => 'middle',
//    ],
// [
// 'class'=>'\kartik\grid\DataColumn',
// 'attribute'=>'devide_c',
// ],
// [
// 'class'=>'\kartik\grid\DataColumn',
// 'attribute'=>'denom_c',
// ],             
// [
// 'class'=>'\kartik\grid\DataColumn',
// 'attribute'=>'user_id_result',
// ],
// [
// 'class'=>'\kartik\grid\DataColumn',
// 'attribute'=>'d_add',
// ],
// [
// 'class'=>'\kartik\grid\DataColumn',
// 'attribute'=>'d_edit',
// ],
// [
// 'class'=>'\kartik\grid\DataColumn',
// 'attribute'=>'docs',
// ],
// [
// 'class'=>'\kartik\grid\DataColumn',
// 'attribute'=>'ref',
// ],
// [
// 'class'=>'\kartik\grid\DataColumn',
// 'attribute'=>'qty_kan',
// ],
// [
// 'class'=>'\kartik\grid\DataColumn',
// 'attribute'=>'kan',
// ],
// [
// 'class'=>'\kartik\grid\DataColumn',
// 'attribute'=>'kpilist_id',
// ],
//    [
//        'class' => 'kartik\grid\ActionColumn',
//        'dropdown' => false,
//        'vAlign' => 'middle',
//        'urlCreator' => function($action, $model, $key, $index) {
//            return Url::to([$action, 'id' => $key]);
//        },
//        'viewOptions' => ['role' => 'modal-remote', 'title' => 'View', 'data-toggle' => 'tooltip'],
//        'updateOptions' => ['role' => 'modal-remote', 'title' => 'Update', 'data-toggle' => 'tooltip'],
//        'deleteOptions' => ['role' => 'modal-remote', 'title' => 'Delete',
//            'data-confirm' => false, 'data-method' => false, // for overide yii data api
//            'data-request-method' => 'post',
//            'data-toggle' => 'tooltip',
//            'data-confirm-title' => 'Are you sure?',
//            'data-confirm-message' => 'Are you sure want to delete this item'],
//    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'contentOptions' => [
            'noWrap' => true
        ],
        'template' => '<div class="btn-group btn-group-sm" role="group" aria-label="...">{view}{update_}</div>',
        'urlCreator' => function($action, $model, $key, $index, $url) {
            return Url::to(['/kpi/kpidata/' . $action, 'id' => $key]);
        },
        'buttons' => [
            'view' => function($url, $model, $key) {
                return Html::a('<i class="glyphicon glyphicon-eye-open"></i>', $url, ['class' => 'btn btn-default', 'role' => 'modal-remote', 'title' => 'รายละเอียด']);
//                        if($model->kan == 1){
//                            return Html::a('<i class="glyphicon glyphicon-pencil"></i>',$url,['class'=>'btn btn-default','role'=>'modal-remote','title'=>'บันทึกข้อมูลเกณฑ์ย่อย']);
//                        }
                //return Html::a('<i class="glyphicon glyphicon-pencil"></i>',$url,['class'=>'btn btn-default','role'=>'modal-remote_','title'=>'บันทึกเกณฑ์ย่อย']);
            },
//                    'update'=>function($url,$model,$key){
//                        if($model->kan == 0){
//                            return Html::a('<i class="glyphicon glyphicon-edit"></i>',$url,['class'=>'btn btn-default','role'=>'modal-remote','title'=>'สร้างเกณฑ์ย่อย']);
//                        }
//                        
//                    },
//                    'delete'=>function($url,$model,$key){
//                         return Html::a('<i class="glyphicon glyphicon-trash"></i>', $url,[
//                                'title' => Yii::t('yii', 'Delete'),
//                                'data-confirm' => Yii::t('yii', 'คุณต้องการลบไฟล์นี้?'),
//                                'data-method' => 'post',
//                                'data-pjax' => '0',
//                                'class'=>'btn btn-default'
//                                ]);
//                    }
        ]
    ],
];
