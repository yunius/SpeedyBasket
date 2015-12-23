<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Gestion_Ligne_Commande
 *
 * @author gilou
 */
class Gestion_Ligne_Commande {
    
    
    public function getLigneCommandes($idcommande) {
        
        $panier = [];
        $sql = "SELECT * FROM tb_ligne_commande WHERE id_commande = :id_commande";
        $requete = Connect::getInstance()->prepare($sql);
        $requete->execute([':id_commande' => $idcommande]);
        
        while ($lignes = $requete->fetch(PDO::FETCH_ASSOC)) {
            $panier[] = new Ligne_commande($lignes) ;
        }
        
        return $panier;               
    }
    
    public function getLigneCommande($idcommande, $idArticle) {
        
        $sql = "SELECT * FROM tb_ligne_commande WHERE id_commande LIKE :id_commande AND id_article LIKE :id_article";
        $requete = Connect::getInstance()->prepare($sql);
        $requete->execute([':id_commande' => $idcommande,
                           ':id_article' => $idArticle
                            ]);
        return new Ligne_commande($requete->fetch(PDO::FETCH_ASSOC));
	}
    
    public function exists(Ligne_commande $ligneCommande) {
        $sql ="SELECT COUNT(*) FROM tb_ligne_commande WHERE id_commande = :id_commande AND id_article = :id_article";
        $req = Connect::getInstance()->prepare($sql);
      	$req->execute([':id_commande' => $ligneCommande->getId_Commande(),
                       ':id_article' => $ligneCommande->getId_Article()
                        ]);
      	return (bool)$req->fetchColumn();
    }
    
    public function addLigneCommande(Ligne_commande $ligneCommande) {
        
        $requete = Connect::getInstance()->prepare('INSERT INTO tb_ligne_commande (id_article, id_commande, qte_cmde) VALUES (:idArticle, :idCommande, :qte_cmde)');
        $requete->bindValue(':idArticle', $ligneCommande->getId_Article(), PDO::PARAM_INT );
        $requete->bindValue(':idCommande', $ligneCommande->getId_Commande(), PDO::PARAM_INT );
        $requete->bindValue(':qte_cmde', $ligneCommande->getQte_Cmde(), PDO::PARAM_INT );
        $requete->execute();
    }
    
    public function updateLigneCommande(Ligne_commande $ligneCommande) {
        
        $sql = "UPDATE tb_ligne_commande SET qte_cmde = :qte_cmde WHERE id_article = :id_article AND id_commande = :id_commande";
        $requete = Connect::getInstance()->prepare($sql);
        $requete->bindValue(':qte_cmde', $ligneCommande->getQte_Cmde(), PDO::PARAM_INT);
        $requete->bindValue(':id_commande', $ligneCommande->getId_Commande(), PDO::PARAM_INT);
        $requete->bindValue(':id_article', $ligneCommande->getId_Article(), PDO::PARAM_INT);
        $requete->execute();
    }
    
    public function deleteLigneCommande(Ligne_commande $ligneCommande) {
        
        $sql = "DELETE FROM tb_ligne_commande WHERE id_article = :id_article AND id_commande = :id_commande";
        $requete = Connect::getInstance()->prepare($sql);
        $requete->execute([':id_article' => $ligneCommande->getId_Article(),
                           ':id_commande' => $ligneCommande->getId_Commande()
                          ]); 
    }
    
    public function getTVAs($idcommande) {
        $lesTVAs = [];
        $sql ="SELECT tb_tva.id_tva, t_taux FROM tb_tva
               JOIN tb_article ON tb_tva.id_tva = tb_article.id_tva
               JOIN tb_ligne_commande ON tb_article.id_article = tb_ligne_commande.id_article
               WHERE tb_ligne_commande.id_commande = :idcommande
               GROUP BY tb_tva.id_tva";
        $requete = Connect::getInstance()->prepare($sql);
        $requete->execute([':idcommande' => $idcommande]);
        while ($lignes = $requete->fetch(PDO::FETCH_ASSOC)) {
            
                $lesTVAs[] = $lignes;
            
        }
        return $lesTVAs;
    }
    
    public function countArtByTVA($id_commande, $id_tva ) {
        $nbArticle = [];
        $sql = "SELECT SUM(qte_cmde) AS nbarticle FROM tb_ligne_commande 
                JOIN tb_article ON tb_ligne_commande.id_article=tb_article.id_article 
                JOIN tb_tva ON tb_tva.id_tva=tb_article.id_tva 
                WHERE id_commande = ".$id_commande."
                AND tb_article.id_tva = ".$id_tva."";
        $requete = Connect::getInstance()->query($sql);
        $requete->execute();
        while ($lignes = $requete->fetch(PDO::FETCH_ASSOC)) {
            
                $nbArticle[] = $lignes;
            
        }
        return $nbArticle[0];
    }
    
    
}
