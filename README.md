#Perso
=====

Bundle perso avec deux trois petits trucs qui me servent ici et la.

Pour ajouter l'extension de twig dans le kernel :

    new Perso\TwigBundle\PersoTwigBundle(),

Ensuite on peut utiliser :

    Ces filtres :

    -reduce : Réduire une chaine
    -slugit : Transformer une chaine en slug

    Ces fonctions :
    
    -loremipsum : Renvoie du texte LoremIpsum a la volée

#Tools

=====

Il y a une classe de compression d'image bien utile et facile à utiliser dans le 
dossier Classes => ResizeImage.

Pour l'utiliser il faut l'inclure dans votre fichier, controller ou entité
    
    use Perso\Tools\Classes\ResizeImage;

Et ensuite le code est assez simple, voici un exemple de méthode tres simple :
    
    private function compression($chemi_absolu_vers_image) {
        $resizeObj = new ResizeImage($chemi_absolu_vers_image);
        // Redimensionement de l'image (options: exact, portrait, landscape, auto, crop)
        $resizeObj->resizeImage($max_width,$max_height, 'auto');
        // Sauvegarde de l'image
        $resizeObj->saveImage($chemi_absolu_vers_image, $quality);
    }

Voila, rien de plus, l'image est compressée et remplace désormais l'ancienne.