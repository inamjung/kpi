<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\web\themes\thm1\assets\thm1;

thm1::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

  <head>

   <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>

     <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>


</head>
<body id="page-top" class ="index">
   
   <?php $this->beginBody() ?>
      <div class ="container">
      <?= $content; ?>
      </div>

         
   <?php $this->endbody() ?>
</body>
</html>
<?php $this->endPage() ?>
		