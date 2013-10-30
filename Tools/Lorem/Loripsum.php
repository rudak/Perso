<?php

namespace Perso\Tools\Lorem;

/*
 * http://loripsum.net/api
 * 
 * (integer) - The number of paragraphs to generate.
 * short, medium, long, verylong - The average length of a paragraph.
 * decorate - Add bold, italic and marked text.
 * link - Add links.
 * ul - Add unordered lists.
 * ol - Add numbered lists.
 * dl - Add description lists.
 * bq - Add blockquotes.
 * code - Add code samples.
 * headers - Add headers.
 * allcaps - Use ALL CAPS.
 * prude - Prude version.
 * plaintext - Return plain text, no HTML.
 *  
 */

Class Loripsum {

    private $url = 'http://loripsum.net/api';
    private $url_params;

    function __construct($auto = false) {
        if($auto){
            $this->set_options(array(8,'code','bq','ul','link','long','headers','ol','decorate','prude'));            
        }
    }

    public function set_options(array $options) {
        foreach ($options as $option) {
            if (in_array($option, $this->get_available_options()) || is_numeric($option)) {
                $this->url_params .= '/' . $option;
            }
        }
    }

    public function get_stuff() {
        return file_get_contents($this->url . $this->url_params);
    }

    private function get_available_options() {
        return array(
            'short', 'medium', 'long',
            'verylong', 'decorate', 'link',
            'ul', 'ol', 'dl', 'bq', 'code',
            'headers', 'allcaps', 'prude', 'plaintext'
        );
    }
}