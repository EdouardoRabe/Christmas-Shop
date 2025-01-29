<?php

namespace app\models;

use Exception;
use PDO;

class CadeauxModel
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    public function attribuerCadeaux($idUser, $nbFilles, $nbGarcons)
    {
        try {
            $queryGarcons = "SELECT id_cadeau FROM noel_cadeaux WHERE id_genre IN (1, 3) ORDER BY RAND()";
            $queryFilles = "SELECT id_cadeau FROM noel_cadeaux WHERE id_genre IN (2, 3) ORDER BY RAND()";
            $stmtGarcons = $this->bdd->prepare($queryGarcons);
            $stmtFilles = $this->bdd->prepare($queryFilles);
            $stmtGarcons->execute();
            $cadeauxGarcons = $stmtGarcons->fetchAll(PDO::FETCH_COLUMN);
            $stmtFilles->execute();
            $cadeauxFilles = $stmtFilles->fetchAll(PDO::FETCH_COLUMN);
            $cadeauxAttribues = [];
            $reshuffle = function (&$cadeaux, $query) {
                $stmt = $this->bdd->prepare($query);
                $stmt->execute();
                $cadeaux = $stmt->fetchAll(PDO::FETCH_COLUMN);
            };

            for ($i = 0; $i < $nbFilles; $i++) {
                if (empty($cadeauxFilles)) {
                    $reshuffle($cadeauxFilles, $queryFilles);
                }
                $idCadeau = array_shift($cadeauxFilles);
                $cadeauxAttribues[] = [
                    "id_user" => $idUser,
                    "id_cadeau" => $idCadeau,
                    "genre" => 2,
                    "status" => 1
                ];
            }

            for ($i = 0; $i < $nbGarcons; $i++) {
                if (empty($cadeauxGarcons)) {
                    $reshuffle($cadeauxGarcons, $queryGarcons);
                }
                $idCadeau = array_shift($cadeauxGarcons);
                $cadeauxAttribues[] = [
                    "id_user" => $idUser,
                    "id_cadeau" => $idCadeau,
                    "genre" => 1,
                    "status" => 1
                ];
            }

            return $cadeauxAttribues;

        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'attribution des cadeaux : " . $e->getMessage());
        }
    }

    public function obtenirIdCadeauParCommande($idCommande) {
        $query = "SELECT id_cadeau FROM noel_commande WHERE id_commande = :id_commande";
        $stmt = $this->bdd->prepare($query);
        $stmt->execute(["id_commande"=> $idCommande]);
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultat ? $resultat['id_cadeau'] : null;
    }
    

    public function obtenirNouveauxCadeaux($idUser, $cadeauxAChanger) {
        try {
            $cadeauxReattribues = [];
            $idsAChanger = [];
            $genresAChanger = [];
            foreach ($cadeauxAChanger as $cadeauAChanger) {
                $idCadeau = $this->obtenirIdCadeauParCommande($cadeauAChanger['id_commande']);
                if ($idCadeau) {
                    $idsAChanger[] = $idCadeau;
                    $genresAChanger[] = $cadeauAChanger['genre'];
                } else {
                    continue;
                }
            }
            foreach ($cadeauxAChanger as $index => $cadeauAChanger) {
                $genreAChanger = $cadeauAChanger['genre'];
                if ($genreAChanger == 1) {
                    $idGenresDisponibles = [1, 3];
                } elseif ($genreAChanger == 2) {
                    $idGenresDisponibles = [2, 3];
                } else {
                    throw new Exception("Genre inconnu pour l'enfant.");
                }
                $query = "
                    SELECT id_cadeau, id_genre
                    FROM noel_cadeaux
                    WHERE id_cadeau NOT IN (" . implode(',', $idsAChanger) . ") 
                    AND id_genre IN (" . implode(',', $idGenresDisponibles) . ")
                    ORDER BY RAND()
                    LIMIT 1
                ";
                $stmt = $this->bdd->prepare($query);
                $stmt->execute();
                $cadeauxDisponibles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($cadeauxDisponibles)) {
                    $cadeauTrouve = $cadeauxDisponibles[0];
                    $cadeauxReattribues[] = [
                        "id_user" => $idUser,
                        "id_cadeau" => $cadeauTrouve['id_cadeau'],
                        "genre" => $genreAChanger,
                        "status" => 1
                    ];
                } else {
                    $cadeauxReattribues[] = [
                        "id_user" => $idUser,
                        "id_cadeau" => $cadeauAChanger['id_cadeau'],
                        "genre" => $genreAChanger,
                        "status" => 1
                    ];
                }
            }
            return $cadeauxReattribues;
    
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'attribution des nouveaux cadeaux : " . $e->getMessage());
        }
    }
    





    function getBanner($images, $montantDeposer) {
        $html = "<section class=\"banner mb-5\">
                    <div id=\"carouselExampleSlidesOnly\" class=\"carousel slide\" data-bs-ride=\"carousel\">
                        <div class=\"carousel-inner\">";
        
        foreach ($images as $index => $image) {
            $activeClass = ($index === 0) ? "active" : "";
            
            $html .= "<div class=\"carousel-item $activeClass\">
                        <div class=\"row\">
                            <div class=\"col-md-6\">
                                <img class=\"img-fluid w-75\" src=\"assets/img/$image\" alt=\"Image carousel " . ($index + 1) . "\">
                            </div>
                            <div class=\"col-md-6 m-auto\">
                                <h1 class=\"fw-bold display-4\">
                                    <span style=\"color:#eb4444; font-size:30px;\">
                                        BIENVENUE SUR 
                                    </span><br>
                                    <span style=\"font-family:cursive; font-size:60px;\">CHRISTMAS SHOP</span>
                                </h1>
                                <p>
                                    Notre site est un site spécialisé dans la vente de cadeaux de Noël. Vous pouvez voir des suggestions et ainsi faire 
                                    des dépôts d'argent à l'aide du lien suivant. Vous avez maintenant <strong>$montantDeposer $ </strong> sur votre compte.
                                </p>
                                <a class=\"btn nike-btn px-3 py-2\" href=\"#depot\">
                                    <i class=\"fa-solid fa-wallet me-2\"></i>
                                    DEPOSER DE L'ARGENT
                                </a>
                            </div>
                        </div>
                    </div>";
        }
    
        $html .= "</div>
                </div>
            </section>";
    
        return $html;
    }

    function getFormDepot($action, $message = null) {
        $html = '<section id="depot" style="padding-top:150px; padding-bottom:100px; margin-bottom:200px">
                    <div class="deposit-section py-5">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <div class="card shadow-lg">
                                        <div class="card-body">
                                            <h2 class="text-center mb-4">Effectuer un Dépôt</h2>
                                            <form action="'.$action.'" method="POST" id="depositForm">
                                                <div class="mb-3">
                                                    <label for="amount" class="form-label">Montant du Dépôt</label>
                                                    <input type="number" class="form-control" id="amount" name="amount" placeholder="Entrez le montant" required>
                                                </div>';
    
        if ($message) {
            $html .= '<div class="alert ' . ($message['status'] == 'success' ? 'alert-success' : 'alert-danger') . '" role="alert">
                        ' . $message['message'] . '
                      </div>';
        }
        $html .= '<button type="submit" class="btn nike-btn px-3 py-2 w-100">Déposer</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>';
    
        return $html;
    }

    function getFormNombreEnfants($action) {
        $html = '<section id="nombre-enfants" style="padding-top:150px; padding-bottom:100px; margin-bottom:200px">
                    <div class="deposit-section py-5">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <div class="card shadow-lg">
                                        <div class="card-body">
                                            <h2 class="text-center mb-4">Saisir le nombre d\'enfants</h2>
                                            <form action="'.$action.'" method="POST" id="nombreEnfantsForm">
                                                <div class="mb-3">
                                                    <label for="nombre_filles" class="form-label">Nombre de Filles</label>
                                                    <input type="number" class="form-control" id="nombre_filles" name="nombre_filles" placeholder="Entrez le nombre de filles" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nombre_garcons" class="form-label">Nombre de Garçons</label>
                                                    <input type="number" class="form-control" id="nombre_garcons" name="nombre_garcons" placeholder="Entrez le nombre de garçons" required>
                                                </div>
                                                <button type="submit" class="btn nike-btn px-3 py-2 w-100">Generer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>';
        return $html;
    }

    function getListeCadeaux($cadeaux,$totalAchat, $totalDeposer,$action, $message = null) {
        if ($message) {
            
            $htmlMessage ='<div class="alert ' . ($message['status'] == 'success' ? 'alert-success' : 'alert-danger') . '" role="alert">
                        ' . $message['message'] . '

                      </div>';;
                    if($message['status']=='error'){
                        $htmlMessage.='<h3 style="text-align:center; margin-bottom:20px;">Voulez  vous deposer ' . $totalAchat - $totalDeposer . ' $ ?</h3>
                            <div class="form-group d-flex" style="transform:translate(-20%);margin-left:50%;">
                                <button type="submit" class="btn btn-success me-2" name="deposer"><a href="'.$action.'">Deposer</a></button>
                            </div>
                        ';
                    }
        } else {
            $htmlMessage = '';
        }
        if (empty($cadeaux)) {
            return '<section id="cadeaux" class="container mb-5 text-center">
                        ' . $htmlMessage . '
                        <div class="alert alert-warning py-4" style="background-color: #FFF4E5; border: 1px solid #FFD6A1; color: #FA804C; border-radius: 10px;">
                            <h1 class="fw-bold">Aucun cadeau trouvé</h1>
                            <p class="mb-0">Veuillez générer les cadeaux pour pouvoir les voir !</p>
                        </div>
                    </section>';
        }
        $html = '<section id="cadeaux" class="container mb-5">
                    <div class="casual-shoes">
                        <h1 class="fw-bold py-3">CADEAUX</h1>
                        <h4 style="text-align:center; margin-bottom:20px;">Votre achat est de ' . $totalAchat . ' $ et votre solde est de ' . $totalDeposer . ' $</h4>
                         ' . $htmlMessage . ' 
                        <div class="row">';
                       
        
        foreach ($cadeaux as $cadeau) {
            $genre = ($cadeau["genre"] == 1) ? "Garçon" : "Fille";
            $html .= '<div class="col-md-6 col-lg-4 col-sm-12 mb-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <h6>' . $genre . '</h6>
                                <img class="img-fluid" src="' . htmlspecialchars($cadeau['image']) . '" alt="">
                                <h5 class="card-title fw-bold mt-4">' . htmlspecialchars($cadeau['nom']) . '</h5>
                                <p class="card-text">' . htmlspecialchars($cadeau['description']) . '</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="fw-bold" style="color:#FA804C">$' . number_format($cadeau['prix_unite'], 2) . '</h3>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="cadeau-' . htmlspecialchars($cadeau['id_commande']) . '" value="' . htmlspecialchars($cadeau['id_commande']) . '">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
        }
        $html .= '</div></div></section>';
        return $html;
    }
    
    

    public function getTotalDepotChecked($idUser) {
        try {
            $query = "SELECT SUM(montant) AS total_depot 
                      FROM noel_depot 
                      WHERE id_user = :id_user AND is_ckecked = 0";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(["id_user"=> $idUser]);
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_depot'] !== null ? (float) $result['total_depot'] : 0;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération du total des dépôts : " . $e->getMessage());
        }
    }

    public function getTotalPrixCadeauxNonConfirmes($idUser) {
        try {
            $query = "SELECT SUM(c.prix_unite) AS total_prix
                      FROM noel_commande nc
                      INNER JOIN noel_cadeaux c ON nc.id_cadeau = c.id_cadeau
                      WHERE nc.id_user = :id_user AND nc.status = 1";
            
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(["id_user"=> $idUser]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_prix'] !== null ? (float) $result['total_prix'] : 0;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération du total des prix des cadeaux : " . $e->getMessage());
        }
    }
    
    
    
    
    
    
    

}

?>