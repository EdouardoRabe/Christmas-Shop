<?php

namespace app\controllers;

use Flight;

class DepotController {


    public function __construct() {
    }

    

    public function deposer(){
        $generaliserModel=Flight::generaliserModel();
        $montant = Flight::request()->data->amount;
        $donne = $generaliserModel ->insererDonnee("noel_depot",["id_user"=>$_SESSION["id_user"], "montant" => $montant, "is_ckecked"=>1]);
        $_SESSION["message"]=$donne;
        Flight::redirect('accueil#depot');
    }

    public function generer(){
        $generaliserModel=Flight::generaliserModel();
        $filles = Flight::request()->data->nombre_filles;
        $garcons = Flight::request()->data->nombre_garcons;
        $cadeauxModel= Flight:: cadeauxModel();
        $cadeaux= $cadeauxModel-> attribuerCadeaux($_SESSION["id_user"],$filles, $garcons);
        $donne = $generaliserModel ->insererDonnees("noel_commande",$cadeaux);
        Flight::redirect('accueil#cadeaux');
    }

    public function confirmer(){
        $generaliserModel=Flight::generaliserModel();
        $id_depot= Flight:: request()-> data->id_depot;
        $commission= Flight:: request()-> data->commission;
        $adminModel=Flight:: adminModel();
        $montant=$adminModel-> getMontantDepot($id_depot);
        $donne = $generaliserModel ->insererDonnee("noel_depot",["id_user"=>$_SESSION["id_user"], "montant" => $montant*$commission/100*-1, "is_ckecked"=>0]);
        $update= $generaliserModel-> updateTableData("noel_depot",["is_ckecked"=>0],["id_depot"=>$id_depot]);
        Flight::redirect("accueilAdmin");
    }

    public function combler(){
        $cadeauxModel= Flight:: cadeauxModel();
        $generaliserModel=Flight::generaliserModel();
        $TotalPrix= $cadeauxModel-> getTotalPrixCadeauxNonConfirmes($_SESSION["id_user"]);
        $montantDeposer= $cadeauxModel ->getTotalDepotChecked($_SESSION["id_user"]);
        $donne = $generaliserModel ->insererDonnee("noel_depot",["id_user"=>$_SESSION["id_user"], "montant" => $TotalPrix-$montantDeposer, "is_ckecked"=>0]);
        Flight::redirect('accueil#cadeaux');
    }

}
