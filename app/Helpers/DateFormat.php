<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateFormat
{
    private static $mountEqual = array(
        'Январь – Канътар айы',
        'Февраль – Увыт айы',
        'Март – Навруз айы',
        'Апрель – Коькек айы',
        'Май – Курал айы',
        'Июнь – Тамбыз айы',
        'Июль – Шилле айы',
        'Август – Сары тамбыз айы',
        'Сентябрь – Кырк кийик айы',
        'Октябрь – Казан айы',
        'Ноябрь – Караша айы',
        'Декабрь – Карагыс айы',
    );

    private static $dayEqual = array(

        'Понедельник',
        'Вторник',
        'Среда',
        'Четверг',
        'Пятница',
        'Суббота',
        'Воскресенье',

    );

    public static function getDateHeader()
    {
        $month = date('n') - 1;
        $day = date('w') - 1;
        return self::$dayEqual[$day] . ', '.date('d').' '. self::$mountEqual[$month] . ' ' . date(' Y');
//        return 'adad';
    }
}