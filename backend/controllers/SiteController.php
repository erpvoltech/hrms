<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\User;
use backend\models\Signup;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','updatelog', 'policylog'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','test','signup'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
       // return $this->render('index');
		if (Yii::$app->user->identity->role == 'unit admin'|| Yii::$app->user->identity->role == 'unit user') {
			return $this->redirect('../../frontend/web/index.php');
		}
		if(Yii::$app->user->identity->role=='finance approval1'|| Yii::$app->user->identity->role=='finance approval2' || Yii::$app->user->identity->role=='hr'){
			Yii::$app->response->redirect(['finance/dashboard']);
		}
		else{
			return $this->render('index');
		}
    }
	public function actionTest()
    {
        return $this->render('test');
    }
    
     public function actionUpdatelog()
    { 
        return $this->render('updatelog');
    }
	
	public function actionPolicylog() {
        return $this->render('policylog');
    }
   
   public function actionSignup()
    {
        $model = new Signup();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                return $this->render('userlist');
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
   
    public function actionLogin()
    {
       $this->layout ='login_layout';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
	
	/**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
	
		 
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
	
	
}
