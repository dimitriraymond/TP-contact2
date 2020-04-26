<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Contact
 *
 * @author dimit
 */
class Contact extend BaseModel {
    
    public function getContact() {
        Select return $this→db→select() From Contacts
    } ; 
    
    
    //put your code here
}
