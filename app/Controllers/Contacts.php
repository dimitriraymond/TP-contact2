<?php
use App\Models\Contact
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Contacts
 *
 * @author dimit
 */
class Contacts extend BaseController{
    public function index(              //methode index qui instancie Contact et l'affecte a la varible $contact
            Contact= new Contact
            Contact= "$contact"
            )
    //put your code here
}
