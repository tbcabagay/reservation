<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

use app\models\Package;
use app\models\PackageItem;
use app\models\Reservation;
use app\models\NewsSearch;
use app\models\PackageSearch;

use yii\web\NotFoundHttpException;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
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
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->latestNews();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = 'login';
    
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/administrator/default/index']);
        }
        return $this->render('login', [
            'model' => $model,
        ]);
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
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionExplore()
    {
        $searchModel = new PackageSearch();
        $dataProvider = $searchModel->catalog();

        return $this->render('explore', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReservation($slug)
    {
        $packageItem = $this->findPackageItemSlug($slug);
        $reservation = new Reservation();
        $reservation->scenario = Reservation::SCENARIO_NEW;

        if ($reservation->load(Yii::$app->request->post()) && $reservation->placeReservation($packageItem)) {
            Yii::$app->session->setFlash('reservationFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('reservation', [
                'reservation' => $reservation,
                'packageItem' => $packageItem,
            ]);
        }
    }

    public function actionAgreement($package_id, $slug)
    {
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('agreement', [
                'package' => $this->findPackage($package_id),
                'packageItem' => $this->findPackageItemSlug($slug),
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

    }

    public function actionGallery($slug)
    {
        $model = $this->findPackageItemSlug($slug);
        
        return $this->render('gallery', [
            'model' => $model,
            'packageItemGalleries' => $model->packageItemGalleries,
        ]);
    }

    protected function findPackageItemSlug($slug)
    {
        if (($model = PackageItem::find()->where(['slug' => $slug])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findPackage($id)
    {
        if (($model = Package::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
