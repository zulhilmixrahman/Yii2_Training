<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Senarai Pengguna';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pengguna-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Tambah Pengguna', ['daftar'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => 'Bil'
            ],
            'nama_pengguna',
            'nama_penuh',
            [
                'attribute' => 'jabatan',
                'label' => 'Jabatan',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data['jabatan']['nama_jabatan'];
                }
            ],
            [
                'attribute' => 'bahagian',
                'label' => 'Bahagian',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data['bahagian']['nama_bahagian'];
                }
            ],
            [
                'attribute' => 'unit',
                'label' => 'Unit',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data['unit']['nama_unit'];
                }
            ],
            [
                'attribute' => 'status',
                'label' => 'Status',
                'value' => function($data) {
                    if ($data['status'] == 1)
                        return 'Aktif';
                    else
                        return 'Tidak Aktif';
                },
                'filter' => true
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                //Custom Button Position
                'template' => '{papar} {kemaskini} {hapus} {alert}',
                //Custom Link Button
                'buttons' => [
                    'papar' => function ($url, $model) {
                        //Papar Button jika status aktif
                        return $model->status === 1 ? Html::a('<span class="glyphicon glyphicon-search"></span>', $url) : '';
                    },
                    'kemaskini' => function ($url, $model) {
                        //Papar Button jika status aktif
                        return $model->status === 1 ? Html::a('<span class="glyphicon glyphicon-edit"></span>', $url) : '';
                    },
                    'hapus' => function ($url, $model) {
                        //Papar Button jika status tidak aktif
                        return $model->status === 2 ? Html::a('<span class="glyphicon glyphicon-remove"></span>', $url) : '';
                    },
                    'alert' => function($url, $model) {
                        //custom button
                        return Html::a('<span class="glyphicon glyphicon-road"></span>', '#', ['onclick' => 'alertName("' . $model->nama_pengguna . '")']);
                    }
                ],
                //Custom URL for each button
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'papar') {
                        $params = array_merge(["pengguna/papar"], ['id' => $model->id_pengguna]);
                        return Yii::$app->urlManager->createUrl($params);
                    }
                    if ($action === 'kemaskini') {
                        $params = array_merge(["pengguna/kemaskini"], ['id' => $model->id_pengguna]);
                        return Yii::$app->urlManager->createUrl($params);
                    }
                    if ($action === 'hapus') {
                        $params = array_merge(["pengguna/hapus"], ['id' => $model->id_pengguna]);
                        return Yii::$app->urlManager->createUrl($params);
                    }
                }
            ],
        ],
    ]);
    ?>

</div>
<script>
    function alertName(name) {
        alert(name);
    }
</script>