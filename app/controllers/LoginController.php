<?php

namespace app\controllers;

use Flight;

class LoginController {


    public function __construct() {
    }

    

    public function getStart() {
        $generaliserModel=Flight::generaliserModel();
        $form= $generaliserModel-> generateLoginSignupForms("noel_user",["id_user"],["id_user","nom","prenom"],"signUp","checkLogin","POST");
        $data = [
            "form"=> $form
        ];
        Flight::render('login', $data);
    }

    public function checkLogin(){
        $generaliserModel=Flight::generaliserModel();
        $data= $generaliserModel-> checkLogin("noel_user",["id_user","nom","prenom"],'POST',["id_user"]);
        if($data["success"]==false){
            Flight::redirect('/');
        }
        else{
            $_SESSION["id_user"]=$data["data"]["id_user"];
            Flight::redirect('accueil');
        }
    }

    public function signUp(){
        $generaliserModel=Flight::generaliserModel();
        $insert= $generaliserModel-> insertData("noel_user", ["id_user"], "POST");
        if($insert["success"]==false){
            Flight::redirect('/');
        }
        else{
            $data=  $generaliserModel -> getLastInsertedId("noel_user","id_user");
            $_SESSION["id_user"]=$data["last_id"];
            Flight::redirect('accueil');
        }
    }

    public function getAccueil(){
        $images = ['1.png', '2.png', '3.png', '4.png'];
        $cadeauxModel= Flight:: cadeauxModel();
        $generaliserModel=Flight::generaliserModel();
        $montantDeposer= $cadeauxModel ->getTotalDepotChecked($_SESSION["id_user"]);
        $banner= $cadeauxModel-> getBanner($images, $montantDeposer);
        $message="";
        if(isset($_SESSION["message"])){
            $message = $_SESSION["message"];
            unset($_SESSION["message"]);
        }
        $message2="";
        if(isset($_SESSION["message2"])){
            $message2 = $_SESSION["message2"];
            unset($_SESSION["message2"]);
        }
        $TotalPrix= $cadeauxModel-> getTotalPrixCadeauxNonConfirmes($_SESSION["id_user"]);
        $action2="traitement-depot";
        $depot= $cadeauxModel-> getFormDepot($action2,$message);
        $action="traitement-enfants";
        $enfant= $cadeauxModel-> getFormNombreEnfants($action);
        $cadeaux= $generaliserModel-> getTableData("noel_commande",["id_user"=> $_SESSION["id_user"], "status"=>1],[],[["noel_cadeaux", [["noel_commande.id_cadeau", "noel_cadeaux.id_cadeau"]]]]);
        $liste= $cadeauxModel-> getListeCadeaux($cadeaux,$TotalPrix, $montantDeposer,"combler", $message2);
        $data=[ "banner"=> $banner, "depot"=> $depot, "enfant" => $enfant, "cadeaux"=> $liste, "page"=>"accueil"];
        Flight:: render("base", $data);
    }

}
