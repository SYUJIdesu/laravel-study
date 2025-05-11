<?php

namespace App\Values;

use Carbon\Carbon;

class DateValue
{
    /**
     * タイムスタンプからCarbonオブジェクトを取得する
     *
     * @param  int  $timestamp
     */
    public static function getCarbonFromTimestamp(float|int|string $timestamp): Carbon
    {
        return Carbon::createFromTimestamp($timestamp);
    }
}
