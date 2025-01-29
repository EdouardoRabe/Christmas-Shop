<?php

namespace app\models;

use Exception;
use Flight;
use PDO;

class AdminModel
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    
    function getTableauDepotsNonConfirmes($action) {
        $generaliserModel = Flight::generaliserModel();
        $depots = $generaliserModel->getTableData(
            "noel_depot", 
            ["is_ckecked" => 1], 
            [],
            [[
                "noel_user", 
                [["noel_depot.id_user", "noel_user.id_user"]] ]
            ]
        );
        $html = '<section id="depots-non-confirmes" style="padding-top:150px; padding-bottom:100px; margin-bottom:200px">
                    <div class="deposit-section py-5">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-10">
                                    <div class="card shadow-lg">
                                        <div class="card-body">
                                            <h2 class="text-center mb-4">Dépôts Non Confirmés</h2>
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Id_user</th>
                                                        <th>Nom du Client</th>
                                                        <th>Montant</th>
                                                        <th>Date du Dépôt</th>
                                                        <th>Commission (%)</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
    
        foreach ($depots as $depot) {
            $html .= '<tr>
                        <td>' . htmlspecialchars($depot['id_user']) . '</td>
                        <td>' . htmlspecialchars($depot['nom']) . ' ' . htmlspecialchars($depot['prenom']) . '</td>
                        <td>' . htmlspecialchars($depot['montant']) . ' €</td>
                        <td>' . htmlspecialchars($depot['date_depot']) . '</td>
                        <td>
                            <form action="'.$action.'" method="POST">
                                <input type="hidden" name="id_depot" value="' . htmlspecialchars($depot['id_depot']) . '">
                                <input type="number" name="commission" class="form-control" min="0" max="100" placeholder="%" required style="width: 80px;" />
                        </td>
                        <td>
                                <button type="submit" class="btn btn-success">Confirmer</button>
                            </form>
                        </td>
                      </tr>';
        }
    
        $html .= '</tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
    </section>';
    
        return $html;
    }
    
    public function getMontantDepot($idDepot) {
        try {
            $query = "SELECT montant 
                      FROM noel_depot 
                      WHERE id_depot = :id_depot";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(["id_depot" => $idDepot]);
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['montant'] !== null ? (float) $result['montant'] : 0;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération du montant du dépôt : " . $e->getMessage());
        }
    }
    
    
    
    
    
    

}

?>