<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody();?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?><?= Yii::t('common','Color')?></h1>
	<?= Html::tag('p', Html::encode(''), ['class' => 'username']) ?>
    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
			
                <?= $form->field($model, 'verifyCode')->widget(\yii\captcha\Captcha::className(), ['template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>']) ?>
				
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php $this->endBody();?>
</body>
</html>
 <?php $this->endPage()?>