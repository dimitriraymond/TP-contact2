<?php
use System\View ;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace System;

/**
 * Description of Route
 *
 * @author dimit
 */
class Route {
    
    Route($config){
        this.config = config;
        /* $url va contenir un tableau de la route demandée sous la forme ‘/page/’. Quand ‘explode’
	 * est exécutée, il trouve un premier ‘/’ dans l’URI  de la requête que la variable ‘$_SERVER’
	 * renvoie. */	
	$url = explode(‘/’, trim($_SERVER[‘REQUEST_URI’], ‘/’)) ;	
	
	/* Ensuite, la méthode $controller utilise un opérateur ternaire (if then else) afin de		 * vérifier si l’index 0 du tableau $url existe sinon le contrôleur par défaut est utilisé */
	$controller = !empty($url[0]) ? $url[0] : $config['default_controller'];	
	
	// Même principe pour la méthode qui est dans l’index 1	
	$method = !empty($url[1]) ? $url[1] : $config['default_method'];	
	
	// s’il y a d’autres arguments dans le tableau $url, il faut les récupérer	
	$args = !empty($url[2]) ? array_slice($url, 2) : array();	
	
	// Contient le chemin vers les contrôleurs tels que spécifié dans la classe Config	
	$class = $config['namespace'] . $controller;	
	
	// Vérifications classe, méthode - invocation de la méthode not_found() définie plus bas
	if (!class_exists($class)) {	
		return $this→not_found();	
	}
	
	if (!method_exists($class, $method)) {	
		return $this→not_found();	
	}
	
	// Vérifications faites, instanciation du contrôleur	
	$classInstance = new $class;	
	
	/* exécution de la classe en appelant 'class_user_func_array et en lui passant en premier
	 * paramètre un tableau : l'instance et la méthode et en deuxième paramètre d'autres éventuels
	 * arguments */	
	call_user_func_array(array($classInstance, $method), $args); 	
	
	// on a terminé d’écrire le constructeur. Définissons la fonction ‘not_found’	
	public function not_found() {	
		$view = new View();	
        return $view→render('404');	
	}

    }
    
}
