<?php

namespace RocketStartup\FrontView;

class Template{

	private $nameTemplate 			= 'default';
	private $nameApp 				= 'main';
	private $replaceAllHtml     	= array();
	
	private $useCache 				= false;
	private $twig 			 		= null;
	private $fileTemplate 			= '404.tpl';
	private $pathTemplate 			= 'storage/apps/templates/';
	private $pathCache 				= 'storage/apps/cache/';

	
	public function __construct(){
		$appName =  \App::getInstance('App')->nameApplication;
		
		$this->nameApplication($appName);
		
		return $this;
	}


	public function render(){
		if(!empty($this->fileTemplate()) && file_exists($this->getPathTemplate().$this->fileTemplate())){
			$loader = new \Twig\Loader\FilesystemLoader($this->getPathTemplate());

			$this->twig = new \Twig\Environment($loader, [
				'cache' => ($this->useCache()==false?false:PATH_ROOT.$this->pathCache.$this->nameApplication().'_'.$this->nameTemplate())
			]);

			echo $this->twig->render($this->fileTemplate(), $this->replaceAllHtml);
		}else{
			throw new \Exception('Template '.$this->fileTemplate().' not found '.$this->getPathTemplate().$this->fileTemplate(), 1);
			
		}
	}
	
	public function nameApplication($v=null){
		if($v==null){
			return $this->nameApp;
		}else{
			$this->nameApp = $v;
			return $this;
		}
	}
	
	public function nameTemplate($v=null){
		if($v==null){
			return $this->nameTemplate;
		}else{
			$this->nameTemplate = $v;
			return $this;
		}
	}

	public function fileTemplate($v=null){
		if($v==null){
			return $this->fileTemplate;
		}else{
			$this->fileTemplate = $v;
			return $this;
		}
	}

 	public function content(array $parms){
		foreach ($parms as $key => $value) {
			$this->replaceAllHtml[$key] = $value;
		}
		return $this;
	}
	
	public function getPathTemplate(){
		return PATH_ROOT.$this->pathTemplate.$this->nameApplication().'_'.$this->nameTemplate().'/tpl/';
	}

	
	public function useCache($v=null){
		if(is_bool($v)){
			$this->useCache=$v;
			return $this;
		}else{
			return $this->useCache;
		}
		
	}

}