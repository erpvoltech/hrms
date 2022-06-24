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
    <style>
    .navbar-default{
      background-color: #1E6F66;
      height:60px;
      }.navbar-brand {
        padding: 0px;
      }
      .navbar-default .navbar-nav > li > a {
        color: #fff
      }
      .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus {
        color:#fff;
        background:none
      }
      .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
        color:#fff;
        background-color: transparent;
      }

      .footer {
        margin-top:280px;
        position: relative;
        right: 0;
        bottom: 0;
        left: 0;
        text-align: center;
      }
      </style>

      <div class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= \Yii::$app->homeUrl ?>"><i class="icon-home icon-white"> </i> <img src="<?= \Yii::$app->homeUrl ?>img/logo.png" style="width:160px;height:59px;">					</a>
          </div>
          <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
             <li class="menu-item "><a href="#"></a></li>
			 <?php if(Yii::$app->user->identity->role=='finance approval1'){ ?>
              <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>finance/index">Finance Approval1</a></li>
			 
			 <?php } else if(Yii::$app->user->identity->role=='finance approval2'){ ?>
			 
            <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>finance/approval">Finance Approval2 </a></li>
			
			 <?php } else if(Yii::$app->user->identity->role=='hr'){?>
			  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>finance/index">Finance Approval1</a></li>
			   <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>finance/approval">Finance Approval2 </a></li>
			 <?php }?>

          <!--Stationary Menu-->
          
            
            <!--End of Stationary Menu-->

          </ul>

          <!-- Right nav -->
          <ul class=" nav navbar-nav navbar-right" style="padding-top:15px;">

            <?php
            if (Yii::$app->user->isGuest) {
              echo '<a href="' . \Yii::$app->homeUrl . 'site/login" style="color:#fff;"> <i class="fa fa-sign-out"></i> <span >Login</span></a>';
            } else {

              echo '<a href="' . \Yii::$app->homeUrl . 'site/logout" style="color:#fff;"> <i class="fa fa-sign-out"></i> <span>Logout(' . Yii::$app->user->identity->username . ')</span></a>';
            }
            ?>
          </form>
        </li>
      </ul>
    </div>
  </div>
</div>
<div class="container">
  <?=
  Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
  ])
  ?>
  <?= Alert::widget() ?>
  <?= $content ?>
</div>
</div>

<footer class="footer">
  <div class="container">
    <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

    <p class="pull-right">Powered by Team ERP</p>
  </div>
</footer>

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
