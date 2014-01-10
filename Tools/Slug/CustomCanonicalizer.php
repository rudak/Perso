<?php

namespace Perso\Tools\Slug;

use FOS\UserBundle\Util\CanonicalizerInterface as FosCanon;
use Perso\Tools\Slug\Slug;

/**
 * Description de CustomCanonicalizer
 *  
 * Utilise la classe slug pour renvoyer un simple slug a partir de la chaine 
 * string, ce qui peut servir de canonicalizer perso pour fosuserBundle vu
 * que celui par default.. bof...
 * 
 * @author Rudak
 */
class CustomCanonicalizer implements FosCanon {

    public function canonicalize($string) {
        $Slug = new Slug();
        return $Slug->giveTheString($string)->getMySlug();
    }

}
