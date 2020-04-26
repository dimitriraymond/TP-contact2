<?php
use System\BaseController ;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app;

/**
 * Description of Home
 *
 * @author dimit
 */
class Home extends BaseController {
    public function index() {
 		return $this→view→render('default');
 	}
    public function sio(){
        return $this→view→render('sio');
    }
    //put your code here
}
