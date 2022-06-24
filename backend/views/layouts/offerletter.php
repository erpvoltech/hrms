<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;
#use common\models\user;

#$id		=	Yii::$app->user->identity->id;

#$userid	=	Yii::app()->user->id; 

AppAsset::register($this);
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
   <body>
      <?php $this->beginBody() ?>

      <div class="wrap">        
         <div class="container">           
            <?= $content ?>
         </div>
      </div>

      <?php $this->endBody() ?>
   </body>
</html>
<?php $this->endPage() ?>


<!--
<li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Setup</a>
                              <ul class="dropdown-menu">
                                <li class="menu-item "><a href="#">Page with comments</a></li>
                                <li class="menu-item "><a href="#">Page with comments disabled</a></li>
                                <li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">More</a>
                                  <ul class="dropdown-menu"><li><a href="#">3rd level link more options</a></li><li><a href="#">3rd level link</a></li></ul>
                                </li>
                              </ul>
                            </li>-->
