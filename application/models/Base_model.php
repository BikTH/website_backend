<?php


class Base_model extends Mydatabase{
    public function __construct(){
        parent::__construct();
        
    }
    
    
    // RENVOIT LA DERNIERE CONNEXION DE L'USER EN PARAMETRE
    public function get_last_connection($user){
        $query = $this->Base->getthis("connection", array("admin"=> $user));
        return $query;
    }
    
    

}