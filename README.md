#Perso
Bundle perso avec deux trois petits trucs qui me servent ici et la.

Pour ajouter l'extension de twig dans le kernel :

    new Perso\TwigBundle\PersoTwigBundle(),

Ensuite on peut utiliser :

    Ces filtres :

    -reduce : Réduire une chaine
    -slugit : Transformer une chaine en slug

    Ces fonctions :    
    
    ##loremipsum
    La fonction loremipsum(nb,point) permet de retourner dynamiquement un nombre 
    de mots aléatoirement piochés dans les phrases typiques de Lorem Ipsum.
    

#Tools
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

#Views
##Mentions légales
J'ai mis une vue correspondant à une page de mentions légales, c'est pratique vu qu'elle est assez générique pour etre collée un peu partout. Il faut juste lui envoyer un tableau rempli avec ce qu'il faut et en avant...
Voila les arguments à faire passer à la vue :

    array(
                    'owner_name' => 'Phillipe Dupont',
                    'owner_company_name' => 'le client',
                    'owner_statut' => 'patron',
                    'owner_address' => '13 rue du code',
                    'site_url' => 'http://mon-site.fr',
                    'site_creator_agency' => 'John Doe votre agence web',
                    'site_creator_name' => 'John Doe',
                    'site_creator_url' => 'http://john-doe.fr',
                    'editor_manager' => 'sylvie textu',
                    'editor_contact' => 'contact@mon-site.fr',
                    'webmaster_name' => 'John Doe',
                    'webmaster_email' => 'contact@john-doe.fr',
                    'hoster' => 'serveur man',
                    'hoster_address' => '45 rue du clocher 45123 FOOBARVILLE',
                    'cnil' => false,
                    'cnil_number' => '123456789'
        )

Ensuite pour inclure la vue il faut rajouter un chemin perso dans la config de Twig vu que par defaut Twig va chercher les vues dans un format bien spécifique.
Donc dans app/config/config.yml

    twig:
        paths:
            "%kernel.root_dir%/../src/Perso/Views": vues_perso

Et dans la vue contenant le reste de votre site vous pouvez faire un include de cette page située dans le dossier perso :

    {% include '@vues_perso/mentions-legales.html.twig' %}

Et c'est tout. C'est presque plus long à lire qu'à mettre en place...

