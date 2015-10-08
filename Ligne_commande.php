<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ligne_commande
 *
 * @author gilou
 */
class Ligne_commande {
    
    private $id_Article;
    private $id_Commande;
    private $qte_Cmde;
    
    public function Hydrate(array $data) {
        foreach ($data as $key => $value) {
            $method = 'set'.ucfirst($key);
            
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
    
    public function __construct(array $data) {
        $this->Hydrate($data);
    }
    
    
    function getId_Article() {
        return $this->id_Article;
    }

    function getId_Commande() {
        return $this->id_Commande;
    }

    function getQte_Cmde() {
        return $this->qte_Cmde;
    }

    function setId_Article($id_Article) {
        if (is_numeric($id_Article)) {
            $this->id_Article = $id_Article;
        }
        
    }

    function setId_Commande($id_Commande) {
        if (is_numeric($id_Commande)) {
            $this->id_Commande = $id_Commande;
        }
        
    }

    function setQte_Cmde($qte_Cmde) {
        if (is_numeric($qte_Cmde)) {
            $this->qte_Cmde = $qte_Cmde;
        }
        
    }


    
}
