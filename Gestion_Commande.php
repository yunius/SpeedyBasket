<?php
/**
 * Description of Gestion_Commande
 *
 * 
 */
class Gestion_Commande {
    
    
    public function getCommmandes() {
        
        $panier = [];
        $sql = "SELECT * FROM tb_commande";
        $requete = Connect::getInstance()->prepare($sql);
        $requete->execute();
        
        while ($lignes = $requete->fetch(PDO::FETCH_ASSOC)) {
            $panier[] = new Commande($lignes) ;
        }
        
        return $panier;               
    }
    
    public function getCommande($idcommande) {
        
        $sql = "SELECT * FROM tb_commande WHERE id_commande = :id_commande";
        $requete = Connect::getInstance()->prepare($sql);
        $requete->execute([':id_commande' => $idcommande,
                            ]);
        return new Commande($requete->fetch(PDO::FETCH_ASSOC));
	}
    
    public function getLastCommande() {
        $sql = "SELECT `id_commande` FROM `tb_commande` ORDER BY `id_commande` DESC LIMIT 1";
        $reponse = Connect::getInstance()->query($sql);        
        $output = $reponse->fetch();
        return $output[0];
    }    
        
    
    public function addCommande(Commande $commande) {
        
        $requete = Connect::getInstance()->prepare('INSERT INTO tb_commande VALUES ()');       
        $requete->execute();
        
        
    }
    
    public function updateCommande(Commande $commande) {
        
        $sql = "UPDATE tb_commande SET c_dateretrait = :c_dateretrait, id_statut = :id_statut,
         client_id_pers = :client_id_pers, prepa_id_pers = :prepa_id_pers WHERE id_commande = :id_commande";
        $requete = Connect::getInstance()->prepare($sql);
        $requete->bindValue(':id_commande', $commande->getId_Commande(), PDO::PARAM_INT);
        $requete->bindValue(':c_dateretrait', $commande->getC_dateretrait());
        $requete->bindValue(':id_statut', $commande->getId_statut(), PDO::PARAM_INT);
        $requete->bindValue(':client_id_pers', $commande->getClient_id_pers(), PDO::PARAM_INT);
        $requete->bindValue(':prepa_id_pers', $commande->getPrepa_id_pers(), PDO::PARAM_INT);
        $requete->execute();
    }
    
    public function deleteCommande(Commande $commande) {
        
        $sql = "DELETE FROM tb_commande WHERE id_commande = :id_commande";
        $requete = Connect::getInstance()->prepare($sql);
        $requete->execute([':id_commande' => $commande->getId_Commande()
                          ]); 
    }
    
    
}
