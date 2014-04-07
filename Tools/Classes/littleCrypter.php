<?php

namespace Perso\Tools\Classes;

/**
 * Description of littleCrypt
 *
 * @author Rudak
 */
class littleCrypter
{

    public static function encrypteur($private_key, $chaineToCrypt)
    {
        $private_key = md5($private_key);
        $letter = -1;
        $new_str = '';
        $strlen = strlen($chaineToCrypt);

        for ($i = 0; $i < $strlen; $i++) {
            $letter++;
            if ($letter > 31) {
                $letter = 0;
            }
            $neword = ord($chaineToCrypt{$i}) + ord($private_key{$letter});
            if ($neword > 255) {
                $neword -= 256;
            }
            $new_str .= chr($neword);
        }
        return base64_encode($new_str);
    }

    public static function decrypteur($private_key, $chaineToDecrypt)
    {
        $private_key = md5($private_key);
        $letter = -1;
        $new_str = '';
        $chaineToDecrypt = base64_decode($chaineToDecrypt);
        $strlen = strlen($chaineToDecrypt);
        for ($i = 0; $i < $strlen; $i++) {
            $letter++;
            if ($letter > 31) {
                $letter = 0;
            }
            $neword = ord($chaineToDecrypt{$i}) - ord($private_key{$letter});
            if ($neword < 1) {
                $neword += 256;
            }
            $new_str .= chr($neword);
        }
        return $new_str;
    }

}
