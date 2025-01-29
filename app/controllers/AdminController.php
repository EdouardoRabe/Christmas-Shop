<?php

namespace app\controllers;

use Flight;

class AdminController {


    public function __construct() {
    }

    

 

    public function getTable(){
        $adminModel= Flight:: adminModel();
        $table= $adminModel-> getTableauDepotsNonConfirmes("confirmer-depot");
        $data=["table"=>$table, "page"=>"admin"];
        Flight:: render("base", $data);
    }

    public function getStart() {
        
        $generaliserModel=Flight::generaliserModel();
        $form= $generaliserModel-> generateAdminForms("noel_user_admin",["id_admin","nom","prenom"],"checkLoginAdmin","POST",["email"=>"admin.super@example.com","mot_de_passe"=>"adminpassword"]);
        $data = [
            "form"=> $form
        ];
        Flight::render('logAdmin', $data);
    }

    public function checkLogin(){
        
        $generaliserModel=Flight::generaliserModel();
        $data= $generaliserModel-> checkLogin("noel_user_admin",["id_admin","nom","prenom"],'POST',["id_admin"]);
        if($data["success"]==false){
            Flight::redirect('admin');
        }
        else{
            $_SESSION["id_admin"]=$data["data"]["id_admin"];
            Flight::redirect('accueilAdmin');
        }
    }

}
