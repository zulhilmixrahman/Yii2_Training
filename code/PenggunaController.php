<?php

namespace app\controllers;

use yii;
use yii\data\ActiveDataProvider;
use app\models\Pengguna;
use app\models\Bahagian;
use app\models\Unit;

class PenggunaController extends \yii\web\Controller {

    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Pengguna::find(),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDaftar() {
        $model = new Pengguna();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('daftar', [
                        'model' => $model
            ]);
        }
    }

    public function actionPapar($id) {
        return $this->render('papar', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionKemaskini($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id_bahagian]);
        } else {
            return $this->render('kemaskini', [
                        'model' => $model,
            ]);
        }
    }

    public function actionHapus($id) {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($id) {
        if (($model = Pengguna::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('No record found.');
        }
    }

    public function actionOptionbahagian() {
        $id = Yii::$app->request->post('id');
        $count = Bahagian::find()->where(['id_jabatan' => $id])->count();
        $list = Bahagian::find()->where(['id_jabatan' => $id])->all();

        if ($count > 0) {
            foreach ($list as $list) {
                echo '<option value="' . $list->id_bahagian . '">' . $list->nama_bahagian . '</option>';
            }
        } else {
            echo '<option>Tiada Rekod</option>';
        }
    }

    public function actionOptionunit() {
        $id = Yii::$app->request->post('id');
        $count = Unit::find()->where(['id_bahagian' => $id])->count();
        $list = Unit::find()->where(['id_bahagian' => $id])->all();

        if ($count > 0) {
            foreach ($list as $list) {
                echo '<option value="' . $list->id_unit . '">' . $list->nama_unit . '</option>';
            }
        } else {
            echo '<option>Tiada Rekod</option>';
        }
    }

}
