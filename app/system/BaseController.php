<?php
use System\View ;/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system;

/**
 * Description of BaseController
 *
 * @author dimit
 */
class BaseController {
    
    public view;
    public url;
    
    public view(){
        $this→view = new View() ;
    }
    
    poblic function url(){
        ‘$this->url = $this→getUrl();
    }
    if (ENVIRONMENT == 'development') {	
			$whoops = new \Whoops\Run;	
			$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);	
			$whoops→register();
		}
protected function getUrl() {	
		$url = isset($_SERVER['REQUEST_URI']) ? rtrim($_SERVER['REQUEST_URI'], '/') : NULL;
		$url = filter_var($url, FILTER_SANITIZE_URL);	
		return $this->url = $url;	
	}

    
    //put your code here
}
