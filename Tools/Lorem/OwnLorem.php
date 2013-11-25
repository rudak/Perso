<?php

namespace Perso\Tools\Lorem;

/**
 * Description of OwnLorem
 *
 * @author rudak
 */
class OwnLorem {

    /**
     * Renvoie un $nb de mots aléatoires issus de phrase type lorem ipsum
     * @param type $nb
     * @param type $point
     * @return type
     */
    private function loremIpsum($nb = 20) {
        $out = '';
        preg_match_all("([a-zA-z]+)", strtolower($this->getString()), $match);
        $word = $match[0];
        $nbWords = count($word) - 1;
        shuffle($word);

        for ($i = 0; $i < $nb; $i++) {
            if ($i <= $nbWords) {
                $out .= $word[$i] . ' ';
            } else {
                // si le nombre de mots dépasse le nombre dispo on refou les 
                // index a zéro, on secoue la boite a mots et roule ma poule
                $i -= $nbWords;
                $nb -= $nbWords;
                shuffle($word);
                $out .= $word[$i] . ' ';
            }
        }
        return $out;
    }

    /**
     * Renvoie la phrase sur laquelle on fais la découpe
     * @return string
     */
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

    public function getOutstring($nb){
        return trim($this->loremIpsum($nb));
    }
}
