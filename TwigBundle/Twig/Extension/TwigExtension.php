<?php

namespace Perso\TwigBundle\Twig\Extension;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\TwigBundle\Loader\FilesystemLoader;
use Perso\Tools\Slug\Slug;
use Perso\Tools\Lorem\OwnLorem;

class TwigExtension extends \Twig_Extension {
    
    private $OwnLorem;

    public function getName() {
        return 'PersoTwigBundleExt';
    }

    public function getFilters() {
        return array(
            'reduce' => new \Twig_Filter_Method($this, 'reduireChaine'),
            'slugit' => new \Twig_Filter_Method($this, 'slugit'),
        );
    }

    public function getFunctions() {
        return array(
            'loremipsum' => new \Twig_Function_Method($this, 'loremIpsum'),
        );
    }

    /**
     * Reduit la chaine $chaine a la taille $taille
     * @param type $chaine
     * @param type $taille
     * @return type
     */
    public function reduireChaine($chaine = '', $taille = 50) {
        return $this->decouper($chaine, $taille);
    }

    /**
     * Découpe propremenent une $chaine de $taille mots et rajoute $fin a la fin
     * @param type $chaine
     * @param type $taille
     * @param type $fin
     * @return type
     */
    private function decouper($chaine = '', $taille = 50, $fin = '...') {
        if (strlen($chaine) <= $taille) {
            return $chaine;
        }

        $tab = preg_split('/([\s\n\r]+)/', $chaine, null, PREG_SPLIT_DELIM_CAPTURE);
        $taille_comparaison = 0;
        $eclat = 0;
        for (; $eclat < count($tab); ++$eclat) {
            $taille_comparaison += strlen($tab[$eclat]);
            if ($taille_comparaison > $taille){
                break;
            }
        }
        return trim(implode(array_slice($tab, 0, $eclat))) . $fin;
    }

    /**
     * Renvoie un $nb de mots aléatoires issus de phrase type lorem ipsum
     * @param type $nb
     * @param type $point
     * @return type
     */
    public function loremIpsum($nb = 20, $point = true) {
        if($this->OwnLorem == null){
            $this->OwnLorem = new OwnLorem();
        }
        return Ucfirst($this->OwnLorem->getOutstring($nb) . ($point ? '.' : null));
    }

    /**
     * Renvoie le slug d'une chaine $str rentrée en parametre
     * @param type $str
     * @return type
     */
    public function slugit($str) {
        $slug = new Slug();
        return $slug->giveTheString($str)->getMySlug();
    }

}
