<?php
namespace App;)
public static function get() {
 return [
 // nous sommes dans un tableau, noter ‘[ ]’ et le séparateur ‘,’
 // indication du namespace pour le routage
 ‘namespace’ => ‘App\Controllers’,
 //indication du contrôleur par defaut
 ‘default_controller’ => ‘Home’,
 // indication de la méthode par défaut
 ‘default_method’ => ‘index’,
 ] ; // noter que l’instruction se termine ici, d’où le ‘ ;’
}
// accès à la base de données
‘db_type’ 		=> ‘pgsql’,		// nom du type défini par PDO
‘db_host’		=> ‘localhost’,
‘db_port’		=> ‘5432’,
‘db_name’		=> ‘contacts’,
‘db_username’		=> ‘posgres’,
‘db_password’		=> ‘123456’,


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Config
 *
 * @author dimit
 */
class Config {
    //put your code here
}
