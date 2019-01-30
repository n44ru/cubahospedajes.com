<?php

namespace AppBundle\Utils;

class ConvertDate
{
    public function convert($date)
    {
        $range1 = substr($date, 0, 8);
        $range2 = substr($date, 11, 18);
        return array('fecha1' => $range1, 'fecha2' => $range2);
    }

    public function date_format($date)
    {
        $y = substr($date, 6, 2);
        $m = substr($date, 3, 2);
        $d = substr($date, 0, 2);
        return $y . $m . $d;
    }

    public function date_back($date)
    {
        $d = substr($date, 4, 2);
        $m = substr($date, 2, 2);
        $y = substr($date, 0, 2);
        return $d . '/' . $m . '/' . $y;
    }
}