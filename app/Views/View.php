<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace System;

/**
 * Description of View
 *
 * @author dimit
 */
class View {
   public function render ($path, $data = false) {
		if ($data) {

 // extraction des variables qui contiennent les contenus pour la vue
			foreach ($data as $key => $value) {
				${$key} = $value;  
			}
		}

		$filepath = "../app/views/$path.php"; // chemin vers les fichiers vue
		if( file_exists($filepath)) {
			require $filepath;
		} else {
			die ("Vue : $path chemin non trouvé ");
		}}

    //put your code here
}
