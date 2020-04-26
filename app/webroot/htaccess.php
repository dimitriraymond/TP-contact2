<?php
Options -Indexes

<IfModule mod_rewrite.c>
        RewriteEngine On                        //s'assurer que le module réécriture esdt bien chargé
	RewriteBase /
        RewriteCond %{REQUEST_FILENAME} !-d	//empêche la redirection automatique vers index.php
	RewriteCond %{REQUEST_URI} (.*)/$	
	RewriteRule ^(.+)/$ $1 [R=307,L]	
	
	RewriteCond %{REQUEST_FILENAME} !-f	
	RewriteCond %{REQUEST_FILENAME} !-d	
	RewriteRule ^(.*)$ index.php?$1 [QSA,L]

</IfModule>

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

