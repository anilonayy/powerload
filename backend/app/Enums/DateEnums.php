<?php

namespace App\Enums;

final class DateEnums
{
    const MONTHS_AS_NUMBER = [1,2,3,4,5,6,7,8,9,10,11,12];
    const MONTHS_AS_NAME = [
        "tr_TR" => ['Ocak','Şubat','Mart','Nisan','Mayıs','Haziran','Temmuz','Ağustos','Eylül', 'Ekim', 'Kasım', 'Aralık'],
    ];
    const MYSQL_DATE_FORMAT = 'Y-m-d';
    const MYSQL_DATETIME_FORMAT = 'Y-m-d H:i:s';
    const YEARLY_DATE_FREQUENCY_COUNT = 12; // this means weights calculated since 12 years ago.
    const YEARLY_DATE_FREQUENCY = 1;
    const MONTHLY_DATE_FREQUENCY = 2;
    const WEEKLY_DATE_FREQUENCY_COUNT = 12; // this means weights calculated since 12 week ago.
    const WEEKLY_DATE_FREQUENCY = 3;

}
