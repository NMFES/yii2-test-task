<?php

namespace app\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "categories".
 *
 * @property integer $id
 * @property string $title
 * @property string $link
 */
class Categories extends \yii\db\ActiveRecord {

    /**
     * Padding for one level of li-element
     */
    const TREE_LI_PADDING_LEFT = 50;

    /**
     * Category has some subcategories
     */
    const IS_NOT_LAST = 0;

    /**
     * Category doesn't have any subcategories
     */
    const IS_LAST = 1;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'categories';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['title', 'required'],
            ['title', 'string', 'max' => 30],
            ['link', 'required'],
            ['link', 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'link' => 'Link',
        ];
    }

    /**
     * Returns all subcategories for current category
     * @param Categories $category
     * @return array
     */
    public static function getSubCategories($category) {
        $path = $category ? $category['path'] . $category['id'] . '.' : '.';

        return self::find()
                        ->orderBy(['title' => 'SORT_ASC'])
                        ->where(['path' => $path])
                        ->all();
    }

    /**
     * Returns all categories for passed path
     * @param Categories $category
     * @return array
     */
    public static function getCategoriesTree($category) {
        $array = [];

        if ($category) {
            $ids = self::pathIDs($category['path']);

            $array = self::find()->orderBy(['path' => 'SORT_ASC'])->where(['id' => $ids])->all();
        }

        return $array;
    }

    /**
     * Builds and returns categories tree
     * @param type $categories
     * @return string
     */
    public static function buildTree($categories) {
        $categories = self::find()
                ->orderBy(['title' => 'SORT_ASC'])
                ->all();

        ob_start();

        self::subTree($categories);

        $tree = ob_get_contents();

        ob_end_clean();

        return $tree ? '<ul>' . $tree . '</ul>' : '';
    }

    /**
     * Generates one level of tree
     * @param array $categories
     * @param string $path
     * @param integer $level
     */
    private static function subTree(&$categories, $path = '.', $level = 0) {
        foreach ($categories as $category) {
            if ($category['path'] != $path) {
                continue;
            }

            if (!$category['is_last']) {
                echo '<li style="margin-left: ' . ($level * self::TREE_LI_PADDING_LEFT) . 'px">'
                . '<a href="' . $category['link'] . '">' . Html::encode($category['title']) . '</a>'
                . '</li>'
                . '<ul>';

                self::subTree($categories, $path . $category['id'] . '.', ($level + 1));

                echo '</ul>';
            } else {
                echo '<li style="margin-left: ' . ($level * self::TREE_LI_PADDING_LEFT) . 'px">'
                . '<a href="' . $category['link'] . '">' . Html::encode($category['title']) . '</a>'
                . '</li>';
            }
        }
    }

    /**
     * Returns array of categories IDs for passed path
     * @param string $path
     * @return array
     */
    public static function pathIDs($path = '') {
        $array = explode('.', trim($path, '.'));

        foreach ($array as $key => $value) {
            if (empty($value)) {
                unset($array[$key]);
            }
        }

        return $array;
    }

    /**
     * Deletes all subcategories for passed category
     * @param Categories $category
     */
    public static function deleteSubCategories($category) {
        $query = "DELETE FROM " . self::tableName() . " "
                . "WHERE path LIKE '" . $category['path'] . $category['id'] . ".%'";

        Yii::$app->db->createCommand($query)->execute();
    }

}
