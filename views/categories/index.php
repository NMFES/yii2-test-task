<?php
/* @var $this yii\web\View */
/* @var $model app\models\Categories */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Категории';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => $category ? ['categories/index'] : null];

foreach ($tree as $treeCategory) {
    $this->params['breadcrumbs'][] = ['label' => $treeCategory['title'], 'url' => ['categories/index', 'id' => $treeCategory['id']]];
}

if ($category) {
    $this->params['breadcrumbs'][] = ['label' => $category['title']];
}
?>
<div class="row">
    <div class="col-xs-12">
        <div class="controls-block">
            <a href="<?= Url::toRoute(['categories/create', 'id' => $category ? $category['id'] : null]); ?>" class="btn btn-success">
                <span class="glyphicon glyphicon-plus"></span>
            </a>
        </div>
    </div>
    <div class="col-xs-12">
        <?php if (count($categories)): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>
                            <?= $model->getAttributeLabel('id'); ?>
                        </th>
                        <th>
                            <?= $model->getAttributeLabel('title'); ?>
                        </th>
                        <th style="width: 190px"></th>
                    </tr>
                </thead>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td>
                            <?= $category['id']; ?>
                        </td>
                        <td>
                            <?= Html::encode($category['title']); ?>
                        </td>
                        <td>
                            <a href="<?= Url::toRoute(['categories/index', 'id' => $category['id']]); ?>" class="btn btn-default">
                                <span class="glyphicon glyphicon-eye-open"></span>
                            </a>
                            <a href="<?= Url::toRoute(['categories/create', 'id' => $category['id']]); ?>" class="btn btn-success">
                                <span class="glyphicon glyphicon-plus"></span>
                            </a>
                            <a href="<?= Url::toRoute(['categories/edit', 'id' => $category['id']]); ?>" class="btn btn-info">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                            <a href="<?= Url::toRoute(['categories/delete', 'id' => $category['id']]); ?>" class="btn btn-danger">
                                <span class="glyphicon glyphicon-remove"></span>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <div class="alert alert-info">
                <strong>Пусто!</strong>
                <p>
                    Эта категория не содержит дочерних категорий
                </p>
            </div>
        <?php endif; ?>
    </div>
</div>