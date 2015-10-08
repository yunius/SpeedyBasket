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
    
    public function calculTva(Article $article) {
        $gestionnaire = new Gestion_Articles();
        $prixHt = $article->getA_pht();
        $tva = $gestionnaire->getTva($article);
        
        //$aPrixTtc = $prixHt*(1+(20.00/100));
        $aPrixTtc = $prixHt*(1+($tva/100));
        
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
        $htmlOutput = '<img src="ressources/panier.png" />';
        $total = 0;
        $totalTtc = 0;
        $liste = $managerL->getLigneCommandes($id_commande);
        foreach ($liste as $lignecommande) {
            $qte = $lignecommande->getQte_Cmde();
            $idArticle = $lignecommande->getId_Article();
            $monArticle = $managerA->getArticle($idArticle);
            $aPrixTtc = $this->calculTva($monArticle);
            $htmlOutput .= '<form action="" method="post"><li> '.$monArticle->getA_designation().'     prix :'.$aPrixTtc.' € TTC</li><input type="hidden" name="idArticle" value="'.$lignecommande->getId_Article().'" />'
                    . '<input type="hidden" name="idCommande" value="'.$lignecommande->getId_Commande().'" />'
                    . '<input type="number" name="qteLCommande" value="'.$qte.'" />'
                    . '<input type="submit" name="updLCommande" value="modifier" />'
                    . '<input type="submit" name="supprimerLCommande" value="X" />'
                    . '</form><br />';
            $total +=($monArticle->getA_pht()*$qte);
            $totalTtc +=($aPrixTtc*$qte);
            
            }
        $htmlOutput .= '<li>TOTAL HT : '.$total.' €</li>
                        <li>TOTAL TTC : '.$totalTtc.' €</li>
                        <form action="" method="post">
                        <li><input type="submit" name="validerCommande" value="valider la commande" /></li>
                        </form>' 
                        ;
        
        return $htmlOutput;
    }
    
    
    
}


