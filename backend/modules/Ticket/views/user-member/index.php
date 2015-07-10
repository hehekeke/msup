<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MsupUserMemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Msup User Members');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-user-member-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Msup User Member',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'phone',
            'username',
            'email:email',
            'password_hash',
            // 'auth_key',
            // 'confirmed_at',
            // 'unconfirmed_email:email',
            // 'blocked_at',
            // 'role',
            // 'registration_ip',
            // 'created_at',
            // 'updated_at',
            // 'flags',
            // 'password_reset_token',
            // 'create_admin',
            // 'update_admin',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
