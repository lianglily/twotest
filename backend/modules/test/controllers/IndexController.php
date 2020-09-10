<?php
namespace backend\modules\test\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\component\MyComponent;
use yii\base\Event;
use yii\helpers\ArrayHelper;

/**
 * Site controller
 */
class IndexController extends Controller
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
			'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' =>  substr(rand(1000,9999), 0),
				'backColor' => 0x000000,//背景颜色
				'maxLength' => 6, //最大显示个数
				'minLength' => 5,//最少显示个数
				'padding' => 5,//间距
				'height' => 40,//高度
				'width' => 130,  //宽度
				'foreColor' => 0xffffff,     //字体颜色
				'offset' => 4,        //设置字符偏移量 有效果
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
		
		
		$model = new LoginForm();
		return $this->renderPartial($this->action->id,[
                'model' => $model,
            ]);
    }

   
}
