<?php

namespace app\controllers;

use app\models\Categories;
use Yii;

class CategoriesController extends \yii\web\Controller {

    /**
     * Index page with all subcategories in current category
     * @param integer $id
     * @return string
     */
    public function actionIndex($id = 0) {
        $category = $this->getModel($id);

        return $this->render('index', [
                    'category' => $category,
                    'categories' => Categories::getSubCategories($category),
                    'model' => new Categories()
        ]);
    }

    /**
     * Creates a new category
     * @param integer $id
     * @return string
     */
    public function actionCreate($id = 0) {
        $category = $this->getModel($id);

        $model = new Categories();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // if we adding category to existing parent category
            // we need to set parent as not last
            if ($category) {
                $category->is_last = Categories::IS_NOT_LAST;
                $category->save(false);
            }

            // sets path and is_last prop for new category
            $model->path = $category ? $category['path'] . $category['id'] . '.' : '.';
            $model->is_last = Categories::IS_LAST;
            $model->save(false);

            return $this->redirect(['categories/index', 'id' => $id]);
        }

        return $this->render('create', [
                    'category' => $category,
                    'model' => $model
        ]);
    }

    /**
     * Deletes the selected category and subcategories
     * @param integer $id
     * @return void
     */
    public function actionDelete($id) {
        $category = $this->getModel($id);

        Categories::deleteSubCategories($category);

        $category->delete();

        // returns to previous page if exists
        return $this->goBack((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null));
    }

    /**
     * Edit page
     * @param integer $id
     * @return string
     */
    public function actionEdit($id = 0) {
        $category = $this->getModel($id);

        if ($category->load(Yii::$app->request->post()) && $category->save()) {
            $pathIDS = Categories::pathIDs($category['path']);

            // redirects to parent category or to categories page
            return $this->redirect(['categories/index', 'id' => count($pathIDS) ? end($pathIDS) : null]);
        }

        return $this->render('edit', [
                    'category' => $category,
                    'model' => $category
        ]);
    }

    /**
     * Searches for a category in db
     * @param integer $id
     * @return Categories
     * @throws \yii\web\NotFoundHttpException
     */
    private function getModel($id) {
        $category = $id ? Categories::findOne($id) : [];

        if ($id && !is_object($category)) {
            throw new \yii\web\NotFoundHttpException('Категория не найдена');
        }

        return $category;
    }

}
