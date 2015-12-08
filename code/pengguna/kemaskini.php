<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="pengguna-daftar">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama_penuh') ?>

    <?= $form->field($model, 'nama_pengguna') ?>


    <?= $form->field($model, 'status')->radioList(
            array(1 => 'Aktif', 2 => 'Tidak Aktif'), 
            array('class' => 'radio')
        ); 
    ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- pengguna-daftar -->
