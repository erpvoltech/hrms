<?php

/* @var $this \yii\web\View */
/* @var $content string */

/*use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use frontend\models\User;*/

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;
use frontend\assets\AppAsset;
use common\models\User;

AppAsset::register($this);
#$logout url	=	 echo \Yii::$app->homeUrl . '/site/logout';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>HRMS</title>
    <?php $this->head() ?>
	<style>

.navbar-inverse {
    background-color: #1E6F66;
    border-color: #1E6F66;
}
.navbar-inverse .navbar-nav > li > a {
    color: #fff;
}
.navbar-inverse .navbar-brand {
    color: #fff;
}

.navbar-inverse .btn-link {
    color: #fff;
}
	</style>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        #'brandLabel' => Yii::$app->name,
        'brandLabel' => 'HRMS',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    
    
    if(Yii::$app->user->identity->role=='admin'){
    $menuItems = [
	
        ['label' => 'Signup', 'url' => ['/site/signup']],
        [
            'label' => 'Project',
            'items' => [
                
                ['label'=>'Create','url'=>['/project-details/index']],
				['label'=>'Project Import','url'=>['/project-details/import-project']],
				['label'=>'Attendance','url'=>['/project-details/attendance-menu']],
                 #'<li class="divider"></li>',
                 #'<li class="dropdown-header">Dropdown Header</li>',
                 #['label' => 'Level 1 - Dropdown B', 'url' => '#'],
            ],
        ],
        
        [
            'label' => 'Training',
            'items' => [
        ['label' => 'Topics', 'url' => ['/training-topics']],
		['label' => 'Training', 'url' => ['/postrectraining']],
		['label' => 'Attendance', 'url' => ['/postrectraining/attendance']],
		['label' => 'Existing Attendance', 'url' => ['/postrectraining/attendance-existing']],
		/* [
            'label' => 'Attendance',
            'items' => [
                 ['label' => 'New', 'url' => 'postrectraining/attendance'],
                 '<li class="divider"></li>',
                 #'<li class="dropdown-header">Dropdown Header</li>',
                 ['label' => 'Existing', 'url' => 'postrectraining/attendance-existing'],
            ],
        ],*/
		['label' => 'Report', 'url' => ['/postrectraining/attendancereport']],
		['label' => 'Report II', 'url' => ['/postrectraining/attendancereport-existing']],
         ],
          ],
        
        [
            'label' => 'MIS',
            'items' => [
		['label' => 'MIS', 'url' => ['/emp-details-front/index']],
		],
          ],
    ];	
	}
    
	if(Yii::$app->user->identity->role=='attendance admin' || Yii::$app->user->identity->role=='project admin' || Yii::$app->user->identity->role=='unit users' || Yii::$app->user->identity->role=='unit admin' || Yii::$app->user->identity->role=='mis view'){
    $menuItems = [
	
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'Change Password', 'url' => ['/project-details/resetpassword']],
        #['label' => 'Contact', 'url' => ['/site/contact']],
		/*[
            'label' => 'Project',
            'items' => [
                
                ['label'=>'Create','url'=>['/project-details/index']],
				['label'=>'Project Import','url'=>['/project-details/import-project']],
				['label'=>'Attendance','url'=>['/project-details/attendance-menu']],
                 #'<li class="divider"></li>',
                 #'<li class="dropdown-header">Dropdown Header</li>',
                 #['label' => 'Level 1 - Dropdown B', 'url' => '#'],
            ],
        ],*/
		];	
	}
		/*
		[
            'label' => 'Project',
            'items' => [
                ['label' => 'project','items'=>[['label'=>'Create','url'=>['/project-details/create']],['label'=>'Add Emp','url'=>['#']]]],
                 #'<li class="divider"></li>',
                 #'<li class="dropdown-header">Dropdown Header</li>',
                 #['label' => 'Level 1 - Dropdown B', 'url' => '#'],
            ],
        ],
		*/
		if(Yii::$app->user->identity->role=='training'){
			$menuItems = [
        [
            'label' => 'Training',
            'items' => [
        ['label' => 'Topics', 'url' => ['/training-topics']],
		['label' => 'Training', 'url' => ['/postrectraining']],
		['label' => 'Attendance', 'url' => ['/postrectraining/attendance']],
		['label' => 'Existing Attendance', 'url' => ['/postrectraining/attendance-existing']],
		/* [
            'label' => 'Attendance',
            'items' => [
                 ['label' => 'New', 'url' => 'postrectraining/attendance'],
                 '<li class="divider"></li>',
                 #'<li class="dropdown-header">Dropdown Header</li>',
                 ['label' => 'Existing', 'url' => 'postrectraining/attendance-existing'],
            ],
        ],*/
		['label' => 'Report', 'url' => ['/postrectraining/attendancereport']],
		['label' => 'Report II', 'url' => ['/postrectraining/attendancereport-existing']],
         ],
          ],
    ];			
		}
		
		
		if(Yii::$app->user->identity->role=='mis'){
			$menuItems = [
        [
            'label' => 'MIS',
            'items' => [
		['label' => 'MIS', 'url' => ['/emp-details-front/index']],
		],
          ],
    ];			
		}
	
    if (Yii::$app->user->isGuest) {
        #$menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        #$menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];		
		
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }	
	#echo '<a href="' . \Yii::$app->homeUrl . 'site/logout" style="color:#fff;"> <i class="fa fa-sign-out"></i> <span>Logout</span></a>';
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
