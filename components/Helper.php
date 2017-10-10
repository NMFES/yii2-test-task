<?php

namespace app\components;

use Yii;

class Helper {

    /**
     * Строит из входной строки валидный урл,
     * выбрасывая запрещенные символы и заменяя пробелы дефисом
     * @param string $string
     * @return string
     */
    public static function translit($string) {
        $string = mb_strtolower($string, Yii::$app->charset);

        $chars = array(
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'e',
            'ж' => 'zh',
            'з' => 'z',
            'и' => 'i',
            'й' => 'y',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'h',
            'ц' => 'c',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'sch',
            'ь' => '',
            'ы' => 'y',
            'ъ' => '',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya',
            ' ' => '-'
        );

        $string = strtr($string, $chars);
        $string = preg_replace('/[^a-zA-Z0-9\-_]/', '', $string);
        $string = trim($string, '_');

        return $string;
    }

}
