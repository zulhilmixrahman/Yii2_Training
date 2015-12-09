<?php

namespace app\models;

use Yii;
use app\models\Jabatan;
use app\models\Bahagian;
use app\models\Unit;

//use yii\base\NotSupportedException;
//use yii\db\ActiveRecord;
//use yii\helpers\Security;
//use yii\web\IdentityInterface;

/**
 * This is the model class for table "pengguna".
 *
 * @property integer $id_pengguna
 * @property string $nama_pengguna
 * @property string $nama_penuh
 * @property string $kata_laluan
 * @property integer $id_unit
 * @property integer $id_bahagian
 * @property integer $id_jabatan
 * @property integer $status
 */
class Pengguna extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {

    public $username, $password, $rememberMe;
    public $carian;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'pengguna';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['nama_penuh', 'id_unit', 'id_bahagian', 'id_jabatan', 'status'], 'required'],
            [['id_unit', 'id_bahagian', 'id_jabatan', 'status'], 'integer'],
            [['nama_pengguna', 'nama_penuh', 'kata_laluan'], 'string', 'max' => 255],
            [['nama_pengguna'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id_pengguna' => 'Id Pengguna',
            'nama_pengguna' => 'ID Pengguna',
            'nama_penuh' => 'Nama Penuh',
            'kata_laluan' => 'Kata Laluan',
            'id_unit' => 'Unit',
            'id_bahagian' => 'Bahagian',
            'id_jabatan' => 'Jabatan',
            'status' => 'Status',
            'namaJabatan' => 'Jabatan',
            'namaBahagian' => 'Bahagian',
            'namaUnit' => 'Unit'
        ];
    }

//Overide beforeSave
    public function beforeSave($insert) {
        if ($this->isNewRecord && isset($this->kata_laluan)) {
            $this->kata_laluan = Yii::$app->getSecurity()
                    ->generatePasswordHash($this->kata_laluan);
        }
        return parent::beforeSave($insert);
    }

//Set Relationship with table 'Jabatan'
    public function getJabatan() {
        return $this->hasOne(Jabatan::className(), ['id_jabatan' => 'id_jabatan']
        );
    }

//Set Relationship with table 'Bahagian'
    public function getBahagian() {
        return $this->hasOne(Bahagian::className(), ['id_bahagian' => 'id_bahagian']
        );
    }

//Set Relationship for table 'Unit'
    public function getUnit() {
        return $this->hasOne(Unit::className(), ['id_unit' => 'id_unit']
        );
    }

//Getter for Nama Jabatan
    public function getNamaJabatan() {
        return $this->jabatan->nama_jabatan;
    }

//Getter for Nama Bahagian
    public function getNamaBahagian() {
        return $this->bahagian->nama_bahagian;
    }

//Getter for Nama Unit
    public function getNamaUnit() {
        return $this->unit->nama_unit;
    }

    public function login($username, $password) {
        $count = $this->find()->where('nama_pengguna = :username', array(':username' => $username))->count();
        $pengguna = $this->findOne(['nama_pengguna' => $username]);

        if ($count > 0) {
            if (Yii::$app->getSecurity()->validatePassword($password, $pengguna->kata_laluan)) {
                return Yii::$app->user->login($pengguna, $this->rememberMe ? 3600 * 24 * 30 : 0);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /** INCLUDE USER LOGIN VALIDATION FUNCTIONS* */
    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    /* modified */
    public static function findIdentityByAccessToken($token, $type = null) {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

}
