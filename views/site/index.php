<?php

use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="jumbotron">
        <h1>Все работает!</h1>

        <p><a class="btn btn-lg btn-success" href="<?= Url::toRoute(['categories/index']); ?>">Перейти к редактированию</a></p>

        <?php if ($tree): ?>
            <div class="tree">
                <?= $tree; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                <strong>Пусто!</strong>
                <p>
                    Категории не найдены
                </p>
            </div>
        <?php endif; ?>
    </div>
</div>
