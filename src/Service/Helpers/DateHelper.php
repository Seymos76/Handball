<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 22/10/18
 * Time: 16:53
 */

namespace App\Service\Helpers;


class DateHelper
{
    public function getNextSaturday(): ?string
    {
        $nextSaturday = strtotime("next Saturday");
        $saturday = date('d/m/Y', $nextSaturday);
        return $saturday;
    }

    public function getPreviousSaturday()
    {
        $sat = 6;
        $stmp = time(); #Get current timestamp
        $day = date('N',$stmp); #Get numeric day of week
        while($day != $sat) #Match to Saturday
        {
            $stmp = $stmp - 86400; #subtract i day
            $day = date('N',$stmp); #Get numeric day of week
        }
        $finish = date('d-m-Y',$stmp);#Saturday date
        return $finish;
    }

    public function getPreviousPreviousSaturday()
    {
        $stmp = time();
        $currentDay = self::getCurrentDayFormattedToInteger();
        if ($currentDay === 0) {
            $start = date('d-m-Y',$stmp); #7 days previous
        } else {
            $start = date('d-m-Y',$stmp - (86400*7)); #7 days previous
        }
        return $start;
    }

    public function getCurrentDayFormattedToInteger(): ?int
    {
        $date = new \DateTime('now');
        $formattedDate = $date->format('w');
        return (int)$formattedDate;
    }
}
