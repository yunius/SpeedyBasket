<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Commande {
    
    private $id_commande;
    private $c_date;
    private $c_dateretrait;
    private $id_statut;
    private $client_id_pers;
    private $prepa_id_pers;
    
     
    
        
    /**
     * 
     * @param array $data
     * permet de d'attribuer les proprietés en fonction des parametres et des methode existante
     */
    public function hydrate(array $data) {
        foreach ($data as $key => $value) {
                $method = 'set'.ucfirst($key);

                if (method_exists($this, $method)) {
                        $this->$method($value);
                }
        }
    }
    
    /** 
      * @param array $data
      * @return Objet commande
      * construit un objet commande à partir de ses attribut
      */
    function __construct(array $data) {
        $this->hydrate($data);
    }
    
    
    
    function getId_commande() {
        return $this->id_commande;
    }

    function getC_date() {
        return $this->c_date;
    }

    function getC_dateretrait() {
        return $this->c_dateretrait;
    }

    function getId_statut() {
        return $this->id_statut;
    }

    function getClient_id_pers() {
        return $this->client_id_pers;
    }

    function getPrepa_id_pers() {
        return $this->prepa_id_pers;
    }

    function setId_commande($idcommande) {
        
            $this->id_commande = $idcommande;
        
    }

    function setC_date($c_date) {
        
            $this->c_date = $c_date;
        
    }

    function setC_dateretrait($c_dateretrait) {
        
            $this->c_dateretrait = $c_dateretrait;
        
    }

    function setId_statut($id_statut) {
        if (is_numeric($id_statut)){
            $this->id_statut = (int)$id_statut;
        }
    }

    function setClient_id_pers($client_id_pers) {
        if (is_numeric($client_id_pers)){
            $this->client_id_pers = $client_id_pers;
        }
    }

    function setPrepa_id_pers($prepa_id_pers) {
        if (is_numeric($prepa_id_pers)){
            $this->prepa_id_pers = $prepa_id_pers;
        }
    }



    
}

