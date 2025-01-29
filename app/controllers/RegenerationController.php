<?php

namespace app\controllers;

use Flight;

class   RegenerationController {


    public function __construct() {
    }

    

 

    public function regenerer(){
        $cadeauxModel= Flight:: cadeauxModel();
        $generaliserModel= Flight:: generaliserModel();
        $aModifier = $_GET['cadeaux'] ?? [];
        $nouveaux= $cadeauxModel-> obtenirNouveauxCadeaux($_SESSION["id_user"],$aModifier);
        foreach($aModifier as $modif){
            $update= $generaliserModel-> updateTableData("noel_commande",["status"=>2],["id_user"=> $_SESSION["id_user"],"id_commande"=>$modif["id_commande"]]);

        }
        $insert= $generaliserModel-> insererDonnees("noel_commande",$nouveaux);
        $TotalPrix= $cadeauxModel-> getTotalPrixCadeauxNonConfirmes($_SESSION["id_user"]);
        $montantDeposer= $cadeauxModel ->getTotalDepotChecked($_SESSION["id_user"]);
        $message2="";
        if(isset($_SESSION["message2"])){
            $message2 = $_SESSION["message2"];
            unset($_SESSION["message2"]);
        }
        $cadeaux= $generaliserModel-> getTableData("noel_commande",["id_user"=> $_SESSION["id_user"], "status"=>1],[],[["noel_cadeaux", [["noel_commande.id_cadeau", "noel_cadeaux.id_cadeau"]]]]);
        $liste= $cadeauxModel-> getListeCadeaux($cadeaux, $TotalPrix, $montantDeposer, "combler",$message2);
        echo json_encode($liste);
    }

}
