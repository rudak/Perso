<?php

namespace Perso\Tools\Classes;

/**
 * Transforme un Objet DateInterval en 'intervale texte'.
 *
 * @author Rudak
 */
class DateHelper
{

    public static function getInterval(\DateTime $date)
    {
        $now = new \Datetime();
        return $now->diff($date);
    }

    public static function getText(\DateInterval $interval)
    {
        $y = $interval->format('%y');
        $m = $interval->format('%m');
        $d = $interval->format('%d');

        $jour = $mois = $an = null;
        // years
        if ($y > 0) {
            $an = $y . ' an' . (($y > 1) ? 's' : null);
        }
        // months
        if ($m > 0) {
            $an.= ($an != null) ? ', ' : null; // link
            $mois = $m . ' mois';
        }
        // days
        if ($d > 0) {
            if ($mois != null) {
                $mois.= ' et ';
            } else if ($an != null) {
                $an .= ' et ';
            }
        }
        $jour .= $d . ' jour' . (($d > 1) ? 's' : null);
        return $an . $mois . $jour;
    }

    public static function getNumberOfDays(\DateInterval $interval)
    {
        return $interval->format('%r%a');
    }

    public static function IsIntervalInTheFuture(\DateInterval $interval)
    {
        return !$interval->invert;
    }

}
