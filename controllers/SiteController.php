<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\Response;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Package;
use app\models\PackageItem;
use app\models\Reservation;
use app\models\NewsSearch;
use app\models\PackageSearch;
use app\models\MenuPackage;
use app\models\Spa;

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

    public function actionPackages()
    {
        $searchModel = new PackageSearch();
        $dataProvider = $searchModel->catalog();

        return $this->render('packages', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReservation($slug)
    {
        $packageItem = $this->findPackageItemSlug($slug);
        $reservation = new Reservation();
        $reservation->scenario = Reservation::SCENARIO_NEW;
        $reservation->cc_cvv = '012';

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

    public function actionConfirmReservation($id)
    {
        $model = $this->findReservation($id);
        $model->changeStatus(Reservation::STATUS_NEW);

        return $this->render('confirm-reservation', [
            'model' => $model,
        ]);
    }

    public function actionGallery($slug)
    {
        $model = $this->findPackageItemSlug($slug);
        
        return $this->render('gallery', [
            'model' => $model,
            'packageItemGalleries' => $model->packageItemGalleries,
        ]);
    }

    public function actionServices()
    {
        return $this->render('services', [
            'model' => Spa::find()->all(),
        ]);
    }

    public function actionMenus()
    {
        $model = MenuPackage::find()->with(['menuItems' => function($query) {
            $query->orderBy(['menu_category_id' => SORT_ASC]);
        }])->all();
        $result = [];
        if (!empty($model)) {
            foreach ($model as $menuPackage) {
                $result['package'][$menuPackage->id] = [
                    'title' => $menuPackage->title,
                    'amount' => $menuPackage->amount,
                ];
                foreach ($menuPackage->menuItems as $menuItem) {
                    $result['package'][$menuPackage->id]['menu'][$menuItem->menuCategory->id]['category'] = $menuItem->menuCategory->category;
                    $result['package'][$menuPackage->id]['menu'][$menuItem->menuCategory->id]['items'][] = [
                        'title' => $menuItem->title,
                        'description' => $menuItem->description,
                        'photo' => $menuItem->photo,
                    ];
                }
            }
        }
        return $this->render('menus', [
            'model' =>  $result,
        ]);
    }

    public function actionCheckRoomAvailability()
    {
        $request = Yii::$app->request;
        $response = Yii::$app->response;
        if ($request->isAjax && $request->isPost) {
            $date = $post = $request->post('date');
            $item = $post = $request->post('item');

            $count = PackageItem::getVacancyCount($item, $date);

            if ($count > 0) {
                $data = [
                    'status' => 'success',
                    'message' => Yii::t('app', 'There {n, plural, =1{is one room} other{are # rooms}} available on the chosen date.', ['n' => $count]),
                ];
            } else {
                $data = [
                    'status' => 'danger',
                    'message' => Yii::t('app', 'There is no room available on the chosen date.'),
                ];
            }

            $response->format = Response::FORMAT_JSON;
            $response->data = $data;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findPackageItemSlug($slug)
    {
        if (($model = PackageItem::find()->where(['slug' => $slug])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findReservation($id)
    {
        if (($model = Reservation::find()->where([
            'id' => $id,
            'status' => Reservation::STATUS_FOR_VERIFICATION,
        ])->limit(1)->one()) !== null) {
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
