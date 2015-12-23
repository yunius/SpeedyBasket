<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Gestion_Articles
 *
 * @author inpiron
 */
class Gestion_Articles {
    
    public function getArticles() {
        
        $liste = [];
        $sql = "SELECT * FROM tb_article";
        $requete = Connect::getInstance()->prepare($sql);
        $requete->execute();
        
        while ($lignes = $requete->fetch(PDO::FETCH_ASSOC)) {
            $liste[] = new Article($lignes) ;
        }        
        return $liste;             
    }
    
    public function getArticle($idArticle) {
        $sql = "SELECT *FROM tb_article WHERE id_article = :idArticle";
        $requete = Connect::getInstance()->prepare($sql);
        $requete->execute([':idArticle' => $idArticle]);
        return new Article($requete->fetch(PDO::FETCH_ASSOC));
    }
    
    public function getTva(Article $article) {
        $sql = "SELECT t_taux FROM tb_article
                    JOIN tb_tva ON tb_article.id_tva = tb_tva.id_tva
                    WHERE id_article = ".$article->getId_article()."                
               ";
        $reponse = Connect::getInstance()->query($sql);        
        $output = $reponse->fetch();
        return $output[0];
    }
    
    public function updateArticle(Article $article) {
        $sql = "UPDATE tb_article SET a_quantite_stock = :a_quantite_stock WHERE id_article = :id_article";
        $requete = Connect::getInstance()->prepare($sql);
        $requete->bindValue(':a_quantite_stock', $article->getA_quantite_stock(), PDO::PARAM_INT);
        $requete->bindValue(':id_article', $article->getId_article(), PDO::PARAM_INT);        
        $requete->execute();
    }
}
