<?php

namespace App\Entity;

class RecruitmentTask
{
    public function getMaxOfSeries($n)
    {
        if ($n < 1 || $n > 99999)
            return -1;
        else if ($n == 1)
            return 1;

        $elements = array(0, 1);

        for ($i = 2; $i <= $n; $i++) {
            // Evenly indexed elements
            if ($i % 2 == 0) {
                $elements[] = $elements[($i / 2)];
            } // Odd ones
            else {
                $elements[] = $elements[(($i - 1) / 2)]
                    + $elements[((($i - 1) / 2) + 1)];
            }
        }

        return max($elements);
    }
}