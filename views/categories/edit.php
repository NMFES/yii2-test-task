<?php
/* @var $this yii\web\View */
/* @var $model app\models\Categories */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Категории';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => $category ? ['categories/index'] : null];

foreach ($tree as $treeCategory) {
    $this->params['breadcrumbs'][] = ['label' => $treeCategory['title'], 'url' => ['categories/index', 'id' => $treeCategory['id']]];
}

if ($category) {
    $this->params['breadcrumbs'][] = ['label' => $category['title']];
}

$this->params['breadcrumbs'][] = ['label' => 'Редактирование категории'];
?>
<div class="row">
    <div class="col-xs-12">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'title'); ?>
        <?= $form->field($model, 'link'); ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']); ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
