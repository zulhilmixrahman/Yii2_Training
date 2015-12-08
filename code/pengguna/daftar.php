<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Jabatan;
?>
<div class="pengguna-daftar">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama_pengguna') ?>

    <?= $form->field($model, 'nama_penuh') ?>

    <?= $form->field($model, 'kata_laluan') ?>

    <?=
    $form->field($model, 'id_jabatan')->dropdownList(
            Jabatan::find()->select(['nama_jabatan'])
                    ->indexBy('id_jabatan')->column(), [
        'prompt' => '-- Pilih Jabatan --',
        'onchange' => '
                $.post("' . Yii::$app->urlManager->createUrl('pengguna/optionbahagian') . '", {id:$(this).val()}).done(function(data) {
                  $("#pengguna-id_bahagian").html(data);
                });
            '
            ]
    );
    ?>

    <?=
    $form->field($model, 'id_bahagian')->dropDownList([], [
        'prompt' => '-- Pilih Jabatan Dahulu --',
        'onchange' => '
                $.post("' . Yii::$app->urlManager->createUrl('pengguna/optionunit') . '", {id:$(this).val()}).done(function(data) {
                  $("#pengguna-id_unit").html(data);
                });
            '
    ]);
    ?>

    <?= $form->field($model, 'id_unit')->dropDownList([], ['prompt' => '-- Pilih Bahagian Dahulu --']) ?>

    <?=
    $form->field($model, 'status')->radioList(
            array(1 => 'Aktif', 2 => 'Tidak Aktif'), array('class' => 'radio')
    );
    ?>

    <div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>

</div><!-- pengguna-daftar -->
