<?php

namespace Perso\Tools\Classes;

/**
 * Description of SecurityChecker
 *
 * @author rudak
 */
class SecurityChecker {

    /**
     * Vérifie si un fichier est vraiment une image ou alors une saloperie
     * 
     * @param type $image_path
     * @return boolean|string
     */
    public static function is_image($image_path) {
        if (!$f = fopen($image_path, 'rb')) {
            return false;
        }

        $data = fread($f, 8);
        fclose($f);

        $unpacked = unpack("H12", $data);
        if (array_pop($unpacked) == '474946383961' || array_pop($unpacked) == '474946383761')
            return "gif";
        $unpacked = unpack("H4", $data);
        if (array_pop($unpacked) == 'ffd8')
            return "jpg";
        $unpacked = unpack("H16", $data);
        if (array_pop($unpacked) == '89504e470d0a1a0a')
            return "png";

        return false;
    }

    /**
     * Ne laisse passer que mes tags autorisés et vire le reste .
     * 
     * @param type $str
     * @return type
     */
    public static function clear_my_tags($str) {
        $str = self::tags_autorises($str);
        $str = self::supprimer_tags_vides($str);
        $str = self::multiples_espaces($str);
        $str = self::mise_en_forme($str);
        return $str;
    }

    private static function mise_en_forme($content) {
        $content = str_replace("<br></p>", "</p>", $content);
        $content = str_replace("</p><p>", "</p>\n<p>", $content);

        $content = str_replace("</p><h1>", "</p>\n<h1>", $content);
        $content = str_replace("</p><h2>", "</p>\n<h2>", $content);
        $content = str_replace("</p><h3>", "</p>\n<h3>", $content);
        $content = str_replace("</p><h4>", "</p>\n<h4>", $content);

        $content = str_replace("</h1><p>", "</h1>\n<p>", $content);
        $content = str_replace("</h2><p>", "</h2>\n<p>", $content);
        $content = str_replace("</h3><p>", "</h3>\n<p>", $content);
        $content = str_replace("</h4><p>", "</h4>\n<p>", $content);
        $content = str_replace("<thead><", "<thead>\n<", $content);      
        $content = str_replace("</thead><", "</thead>\n<", $content);
        $content = str_replace("<tr><", "<tr>\n<", $content);
        $content = str_replace("</tr><", "</tr>\n<", $content);        
        $content = str_replace("</td><", "</td>\n<", $content);
        
        $content = str_replace("\n\n", "\n", $content);

        return $content;
    }

    private static function supprimer_tags_vides($result) {
        $regexps = array(
            '~<(\w+)\b[^\>]*>\s*</\\1>~',
            '~<\w+\s*/>~'
        );

        do {
            $string = $result;
            $result = preg_replace($regexps, '', $string);
        } while ($result != $string);

        return $result;
    }

    private static function multiples_espaces($string) {
        // $string = trim(preg_replace('/ {2,}/', ' ', $string));
        return preg_replace('/\s+/', ' ', $string);
    }

    private static function tags_autorises($str) {
        return strip_tags($str, '<code><span><div><label><a><br><p><b><i><del><strike><u><img><video><audio><iframe><object><embed><param><blockquote><mark><cite><small><ul><ol><li><hr><dl><dt><dd><sup><sub><big><pre><code><figure><figcaption><strong><em><table><tr><td><th><tbody><thead><tfoot><h1><h2><h3><h4><h5><h6>');
    }

}