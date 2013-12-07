<?php

namespace Perso\Tools\Classes;

# ========================================================================#
#
#  	Author:    rudak
#	
#	Inscrit des phrases dans un fichier texte, pour faire une sorte de log
#	simplifié d'actions effectuées par des utilisateurs.
# 	Une sorte d'historique.
#
#
# ========================================================================#

Class TxtLogger {

    private $file;
    private $path;
    private $user = 'inconnu';
    private $branch;

    public function __construct() {
        $this->path = '../src/Perso/Tools/Log/';
        $mois = array('Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre');
        $this->file = date('Y') . '_' . $mois[date('n') - 1] . '.log';
    }

    public function setUser($user) {
        $this->user = $user;
        return $this;
    }

    public function setBranch($branch) {
        $this->branch = $branch;
        return $this;
    }

    public function log($string) {
        $this->string = $string;
        $content = $this->getContent();
        if(is_array($content)){
            array_unshift($content, $this->getNewEntry());
        } else {
            $content = array($this->getNewEntry());
        }

        file_put_contents($this->getFilePath(), json_encode($content));
        return $this;
    }

    private function getFilePath() {
        return $this->path . $this->file;
    }

    private function get_line($line) {
        return sprintf("<p><span id='date'>%s</span><span id='user'>%s</span><span id='branch'>%s</span><span id='string'>%s</span></p>", $line->date, $line->user, $line->branch, $line->string);
    }

    private function getNewEntry() {
        return array(
            'user' => $this->user,
            'branch' => $this->branch,
            'string' => $this->string,
            'date' => $this->getDate(),
        );
    }

    private function getDate() {
        return date('Y-m-d H:i:s');
    }

    public function getLog() {
        $html = '';
        $content = $this->getContent();
        if (count($content)) {
            foreach ($content as $line) {
                $html .= $this->get_line($line);
            }
        }
        return $html;
    }

    private function getContent() {
        if (file_exists($this->getFilePath()))
            return json_decode(file_get_contents($this->getFilePath()));
        else
            return array();
    }

    public function __toString() {
        return '{Objet TxtLogger}';
    }

}
