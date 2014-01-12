<?php

namespace Perso\Tools\Classes;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

/**
 * Petite methode statique permetant d'encrypter un plainpassword
 *
 * @author Rudak
 */
class Encrypter implements PasswordEncoderInterface {

    static $iterations = 1583;

    static function encodePassword($plainPassword, $salt = null) {
        $i = 0;
        $out = '';
        do {
            $out .= sha1($out . $plainPassword . $i . $salt . $out);
        } while (++$i < self::$iterations);

        return substr($out, 0, 20);
    }

    public function isPasswordValid($encoded, $raw, $salt) {
        return $encoded === $this->encodePassword($raw, $salt);
    }

}
