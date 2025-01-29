<?php

namespace app\controllers;

use Flight;

class ConfirmationController {


    public function __construct() {
    }

    

 

    public function confirmer(){
        
        $cadeauxModel= Flight:: cadeauxModel();
        $generaliserModel= Flight:: generaliserModel();
        $TotalPrix= $cadeauxModel-> getTotalPrixCadeauxNonConfirmes($_SESSION["id_user"]);
        $montantDeposer= $cadeauxModel ->getTotalDepotChecked($_SESSION["id_user"]);
        if($TotalPrix>$montantDeposer){
            $message=["message"=>"Le cout de votre achat depasse votre depot","status"=>"error"];
        }
        else{
            $soustrait= $generaliserModel-> insererDonnee("noel_depot",["id_user"=>$_SESSION["id_user"], "montant" => $TotalPrix*-1, "is_ckecked"=>0]);
            $update= $generaliserModel-> updateTableData("noel_commande",["status"=>0],["id_user"=> $_SESSION["id_user"],"status"=>1]);
            $message=["message"=>"Cadeaux acheter avec succes", "status"=>"success"];
        }
        $_SESSION["message2"]=$message;
        Flight::redirect('accueil#cadeaux');
    }

}
