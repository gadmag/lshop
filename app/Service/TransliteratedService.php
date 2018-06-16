<?php


namespace App\Service;


trait TransliteratedService
{

    public  function transliterate($textCyr = null, $textLat = null)
    {
        $cyr = array(
            'ж', 'ч', 'ы', 'щ', 'ш', 'ю', 'а', 'б', 'в', 'г', 'д', 'е', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ъ', 'ь', 'я', 'э',
            'Ж', 'Ч', 'Ы', 'Щ', 'Ш', 'Ю', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ъ', 'Ь', 'Я', 'Э');
        $lat = array(
            'zh', 'ch', 'y', 'sht', 'sh', 'yu', 'a', 'b', 'v', 'g', 'd', 'e', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', '"', '\'', 'ya', 'eh',
            'Zh', 'Ch', 'Y', 'Sht', 'Sh', 'Yu', 'A', 'B', 'V', 'G', 'D', 'E', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'c', '"', '\'', 'Ya', 'Eh');
        if ($textCyr) {
            $str = str_replace($cyr, $lat, $textCyr);
            $str = strtolower($str);
            $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
            $str = trim($str, "-");
            return $str;
        } else if ($textLat) {
            $str = str_replace($lat, $cyr, $textLat);
            $str = strtolower($str);
            $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
            $str = trim($str, "-");
            return $str;
        } else
            return null;
    }
}