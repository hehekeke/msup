<?php
use Yii;
use backend\modules\Ticket\Ticket;
use backend\components\GlobalFunc;
use yii\helpers\Html;
/* @var $this \yii\web\View */
/* @var $content string */
?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link href="<?= Yii::getAlias("@adminStatics")?>/ticket/web/css/basic.css" rel="stylesheet" />
    <link href="<?= Yii::getAlias("@adminStatics")?>/ticket/web/css/style.css" rel="stylesheet" />
</head>

    <?php $this->beginBody() ?>
    
    <!-- 主体框架 开始 -->

    <div id="page-wrapper" style='min-height: 204px;<?php if (Yii::$app->request->get('iframe')) echo 'margin-left:0px;'?>' >
 
            <?php echo $content; ?>
       
    </div>
    <!-- 主体框架 结束 -->

        <?php $this->endBody();?>
</body>
</html>
<?php $this->endPage() ?>
