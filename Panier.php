<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Panier
 *
 * @author inpiron
 */
class Panier {
    
  /*  public function nbArtTva(Commande $commande) {
        $gestionnairecom = new Gestion_Commande();
        $gestionnairecom->getCommande($commande);
        
        $nblcomm = $gestionnairecom->gestionTva($idcommande);
        
        return $nblcomm;
        
        
    }*/
    
    public function partTva($totalHt, $totalTtc){
        $part = $totalTtc-$totalHt;
        return $part;
        
    }

    public function calculTva(Article $article) {
        // recuperation du taux tva par article
        $gestionnaire = new Gestion_Articles();
        $prixHt = $article->getA_pht();
        $tva = $gestionnaire->getTva($article);
        
        //calcul du prix ttc à partir du prix ht
        //$aPrixTtc = $prixHt*(1+(20.00/100));
        $aPrixTtc = $prixHt*(1+($tva/100));
        $aPrixTtc = number_format($aPrixTtc, 2, '.', '');
        
        return $aPrixTtc;
    
    }
    
    public function okStock($idArticle/*, $demande*/) {
        $managerA = new Gestion_Articles();
        $article = $managerA->getArticle($idArticle);
        if ($article->getA_quantite_stock() > 0) {
            return true;
        }
        else {
            return false;
        }
    }


    public function afficherArticles() {
        
        
        $managerA = new Gestion_Articles();
        $htmlOutput = '';
        $tableau = $managerA->getArticles();
        foreach ($tableau as $value) {
                $idArticle = $value->getId_article();
		$aDesignation = $value->getA_designation();
		$aPht = $value->getA_pht();
		$aDescription = $value->getA_description();
		$aQteStock = $value->getA_quantite_stock();
		$idCategorie = $value->getId_categorie();
		$urlImage = $value->getUrl_image();
                $idTva = $managerA->getTva($value);
                $aPrixTtc = $this->calculTva($value);
                
            
            if($aQteStock > 0) {    
                $htmlOutput .= utf8_encode( "<form action='' method='post'>
                                            <tr>
                                                <td><img src='ressources/$urlImage' class='img_prod' /></td>
                                                <td>$aDesignation</td>
                                                <td>$aPht</td>
                                                <td>$aPrixTtc</td>
                                                <td>$aDescription</td>
                                                <td>$idCategorie</td>
                                                <td>$idTva%</td>
                                                    <input type='hidden' name='id' value='".$idArticle."' />
                                                <td><input type='number' name='qte' value='1' min='1' max='".$aQteStock."' /></td>
                                                <td><input type='submit' name='valider' value='Ajouter' /></td>                                                
                                            </tr>
                                            </form>
                                            ");
            }
                
        }        
        return $htmlOutput;
    }
    
    
    public function afficherPanier($id_commande) {
        
        $managerL = new Gestion_Ligne_Commande();
        $managerA = new Gestion_Articles();
        $htmlOutput = '<img src="ressources/panier.png" class="icn_pan" />';
        $totalHt = 0;
        $totalTtc = 0;
        $liste = $managerL->getLigneCommandes($id_commande);
        $nbArt = $managerL->gestionArticle($id_commande);
        foreach ($liste as $lignecommande) {
            $qte = $lignecommande->getQte_Cmde();
            $idArticle = $lignecommande->getId_Article();
            $monArticle = $managerA->getArticle($idArticle);
            $aPrixTtc = $this->calculTva($monArticle);
            $aQteStock = $monArticle->getA_quantite_stock();
            $htmlOutput .= '<form action="" method="post"><div class="artPan"> <li> '.$monArticle->getA_designation().'    :   '.$aPrixTtc.' €</li>'
                    . '<input type="hidden" name="idArticle" value="'.$lignecommande->getId_Article().'" />'
                    . '<input type="hidden" name="idCommande" value="'.$lignecommande->getId_Commande().'" />'
                    . '<input type="number" name="qteLCommande" value="'.$qte.'" min="1" max="'.$aQteStock.'" />'
                    . '<input type="submit" name="updLCommande" value="modifier" />'
                    . '<input type="submit" name="supprimerLCommande" value="X" />'
                    . '</div></form><br />';
            $totalHt +=($monArticle->getA_pht()*$qte);
            $totalTtc +=($aPrixTtc*$qte);
            
            }
             $part = $this->partTva($totalHt, $totalTtc);
        $htmlOutput .= '<li>NB LIGNE : '.$nbArt.' </li>'
                . '     <li>TOTAL HT : '.$totalHt.' €</li>
                        <li>PART TAXE : '.$part.' €</li>
                        <li class="tt">TOTAL TTC : '.$totalTtc.' €</li>
                        <form action="" method="post">
                        <li><input type="submit" name="validerCommande" value="valider la commande" /></li>
                        </form>' 
                        ;
        
        return $htmlOutput;
    }
    
    
    
}


