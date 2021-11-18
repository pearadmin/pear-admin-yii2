<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
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
        return $this->render('index');
    }

    public function actionGetwebinfo(){
        $sql1='SELECT
					ip,
					FROM_UNIXTIME(created_at, "%Y-%m-%d"),
					COUNT(*) as num
				FROM
					yp_admin_log
				WHERE
					FROM_UNIXTIME(created_at, "%Y-%m-%d") = date_format(NOW(), "%Y-%m-%d")
				GROUP BY
					ip';
        $rows1=Yii::$app->db->createCommand($sql1)->query();
        $todayLogs = [];
        foreach($rows1 as $k=>$value){
            $todayLogs[$k]['ip'] = $value['ip'];
            $todayLogs[$k]['FROM_UNIXTIME'] = $value['FROM_UNIXTIME(created_at, "%Y-%m-%d")'];
            $todayLogs[$k]['num'] = $value['num'];
        }

        $sql = 'SELECT
					FROM_UNIXTIME(created_at, "%Y-%m-%d") as date,
					COUNT(*) as num
				FROM
					yp_admin_log
				GROUP BY
					FROM_UNIXTIME(created_at, "%Y-%m-%d")';
        $rows=Yii::$app->db->createCommand($sql.' order by created_at desc  limit 30')->query();
        $x = [];
        $y = [];
        foreach($rows as $value){
            $x[]=$value['date'];
            $y[]=$value['num'];
        }

        $rows2 =Yii::$app->db->createCommand($sql.' order by created_at desc')->query();

        $todayLogsNum = 0;
        $totalLogsNum = 0;
        $curStrTime = date('Y-m-d',time());
        foreach ($rows2 as $value){
            if($curStrTime == $value['date']){
                $todayLogsNum += $value['num'];
            }

            $totalLogsNum += $value['num'];
        }

        //$ip = $this->get_client_ip();
        $id = Yii::$app->user->identity->id;
        $sql3 = 'SELECT
					ip,
					FROM_UNIXTIME(created_at, "%Y-%m-%d"),
					COUNT(*) as num
				FROM
					yp_admin_log
				WHERE
					admin_id = \''.$id.'\'
				GROUP BY
					FROM_UNIXTIME(created_at, "%Y-%m-%d")';
        $rows3 =Yii::$app->db->createCommand($sql3)->query();
        $logsNumSelf = 0;
        $logsNumTodaySelf = 0;
        foreach ($rows3 as $value){
            if($value['FROM_UNIXTIME(created_at, "%Y-%m-%d")'] == $curStrTime){
                $logsNumTodaySelf = intval($value['num']);
            }
            $logsNumSelf += $value['num'];
        }

        return json_encode(['x'=>array_reverse($x),'y'=>array_reverse($y),'todayLogs'=>$todayLogs,
            'todayLogsNum'=>$todayLogsNum,
            'totalLogsNum'=>$totalLogsNum,
            'logsNumSelf'=>$logsNumSelf,
            'logsNumTodaySelf'=>$logsNumTodaySelf,
            ]);
    }

    public function actionError403(){
        return $this->render('403');
    }

    public function actionError404(){
        return $this->render('404');
    }

    public function actionError500(){
        return $this->render('500');
    }

    public function actionContent()
    {
        return $this->render('content');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

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

    function get_client_ip() {
        $ip = $_SERVER['REMOTE_ADDR'];
        if (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
            foreach ($matches[0] AS $xip) {
                if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                    $ip = $xip;
                    break;
                }
            }
        }
        return $ip;
    }


}
