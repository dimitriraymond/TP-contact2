<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        require "C:\xampp\htdocs\vendor\autoload.php"; //inclu le dossier vendor créer

        
        use Michelf\Markdown;  // plug in composer utiliser
        Markdown::defaultTransform  
        
        <?php
        if (file_exists('../vendor/autoload.php')) {  //test de autoload
 require '../vendor/autoload.php';
 } else {
 echo 'autoload n\'est pas chargé';
 }

 public class Config();
    $config = App\Config::get() ;  // activation de la configuration dans la classe ‘Config’  en invoquant la méthode statique ‘get‘ 
    new System\Route($config) ;     //initialisation du routage
        // put your code here
        ?>
    </body>
</html>
