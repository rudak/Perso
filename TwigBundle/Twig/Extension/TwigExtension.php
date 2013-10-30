<?php

namespace Perso\TwigBundle\Twig\Extension;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\TwigBundle\Loader\FilesystemLoader;

use Perso\Tools\Slug\Slug;

class TwigExtension extends \Twig_Extension {

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

    public function reduireChaine($chaine = '', $taille = 50) {
        return $this->decouper($chaine, $taille);
    }

    private function decouper($chaine = '', $taille = 50, $fin = '...') {
        if (strlen($chaine) <= $taille) {
            return $chaine;
        }
        $tab = preg_split('/([\s\n\r]+)/', $chaine, null, PREG_SPLIT_DELIM_CAPTURE);
        $taille_comparaison = 0;
        $eclat = 0;
        for (; $eclat < count($tab); ++$eclat) {
            $taille_comparaison += strlen($tab[$eclat]);
            if ($taille_comparaison > $taille)
                break;
        }
        return trim(implode(array_slice($tab, 0, $eclat))) . $fin;
    }

    public function loremIpsum($nb = 20, $point = true) {
        $out = '';
        preg_match_all("([a-zA-z]+)", strtolower($this->getString()), $match);
        $word = $match[0];
        $nbWords = count($word) - 1;
        shuffle($word);

        for ($i = 0; $i < $nb; $i++) {
            if ($i <= $nbWords)
                $out .= $word[$i] . ' ';
            else {
                // si le nombre de mots dépasse le nombre dispo on refou les 
                // index a zéro, on secoue la boite a mots et roule ma poule
                $i -= $nbWords;
                $nb -= $nbWords;
                shuffle($word);
                $out .= $word[$i] . ' ';
            }
        }
        return Ucfirst(trim($out) . ($point ? '.' : null));
    }

    private function getString() {
        return 'Lorem ipsum dolor sit amet chatte consectetur adipiscing elit Maecenas 
            sagittis volutpat Duis est eros iaculis et fermentum vitae pharetra et magna 
            Aenean at lorem id nulla pulvinar consecteturIn vel arcu ut enim mollis vehicula
            Suspendisse ornare imperdiet elementum Nunc mauris tortor feugiat quis aliquam at
            gravida ut dolor Mauris eget laoreet ante Proin porttitor nulla ac leo tincidunt 
            quis venenatis nisl tincidunt Sed elit sem volutpat ac dapibus eu fringilla in sem
            Sed dolor est adipiscing ac eleifend consequat laoreet id leo Cum socilis natoque 
            penatibus et magnis dis parturient montes nascetur ridiculus mus Suspendisse 
            varius vulputate pretium Duis tincidunt dapibus tincidunt Vivamus suscipit 
            interdum quam a rutrum ipsum elementum at Suspendisse non eleifend sapien Morbi 
            faucibus risus et massa feugiat ac adipiscing libero fringilla';
    }
    
    public function slugit($str){
        $slug = new Slug();
        return $slug->giveTheString($str)->getMySlug();
    }
}