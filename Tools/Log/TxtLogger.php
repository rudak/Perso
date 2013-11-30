<?php

namespace Perso\Tools\Log;

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

	public function __construct(){
		$this->path = '../src/Perso/Tools/Log/';
		$mois = array('Janvier','Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre');
		$this->file = date('Y').'_'.$mois[date('n')-1].'.log';
	}
	public function setUser($user){
		$this->user = $user;
		return $this;
	}
	public function setBranch($branch){
		$this->branch = $branch;
		return $this;
	}
	public function log($string){
		$this->string = $string;
		$old_content = $this->getContent();
		file_put_contents($this->getFilePath(), $this->get_line().$old_content);		
		return $this;
	}

	private function getFilePath(){
		return $this->path.$this->file;
	}

	private function get_line(){
		return sprintf("%s | %s | %s | %s\n",$this->getDate(),$this->user,$this->branch,$this->string);
	}

	private function getDate(){
		return date('Y-m-d H:i:s');
	}

	public function getLog(){
		return nl2br($this->getContent());
	}

	private function getContent(){
		if(file_exists($this->getFilePath()))
			return file_get_contents($this->getFilePath());
		else
			return null;
	}

	public function __toString(){
		return '{Objet TxtLogger}';
	}
}