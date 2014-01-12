<?php

namespace Perso\Tools\Classes;

/**
 * Petite methode statique permetant d'encrypter un plainpassword
 *
 * @author Rudak
 */
class Encrypter {

    static $iterations = 1583;

    static function encrypt($plainPassword, $salt=null) {        
        $i = 0;
        $out = '';
        do {
            $out .= sha1($out.$plainPassword . $i . $salt . $out);
        } while (++$i < self::$iterations);

        return substr($out,0,20);
    }

}
