<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Article
 *
 * @author inpiron
 */
class Article {
    private $id_article ;
    private $a_designation;
    private $a_pht;
    private $a_description;
    private $a_quantite_stock;
    private $a_visible;
    private $id_categorie;
    private $id_tva ;
    private $url_image;

    public function hydrate(array $data) {
        foreach ($data as $key => $value) {
                $method = 'set'.ucfirst($key);

                if (method_exists($this, $method)) {
                        $this->$method($value);
                }
        }
    }

    function __construct(array $data) {
        $this->hydrate($data);
    }


            
    function getId_article() {
        return $this->id_article;
    }

    function getA_designation() {
        return $this->a_designation;
    }

    function getA_pht() {
        return $this->a_pht;
    }

    function getA_description() {
        return $this->a_description;
    }

    function getA_quantite_stock() {
        return $this->a_quantite_stock;
    }

    function getA_visible() {
        return $this->a_visible;
    }

    function getId_categorie() {
        return $this->id_categorie;
    }

    function getId_tva() {
        return $this->id_tva;
    }

    function setId_article($id_article) {
        
          $this->id_article = (int)$id_article;  
        
        
    }

    function setA_designation($a_designation) {
        if(is_string($a_designation)){
        $this->a_designation = $a_designation;
        }
    }

    function setA_pht($a_pht) {
        $this->a_pht = (float)$a_pht;
    }

    function setA_description($a_description) {
    if(is_string($a_description)){
        $this->a_description = $a_description;
        }
    }

    function setA_quantite_stock($a_quantite_stock) {
    if(is_numeric($a_quantite_stock)){
        $this->a_quantite_stock = $a_quantite_stock;
        }
    }

    function setA_visible($a_visible) {
    if(is_bool($a_visible)){
        $this->a_visible = $a_visible;
        }
    }

    function setId_categorie($id_categorie) {
    if(is_numeric($id_categorie)){
        $this->id_categorie = $id_categorie;
        }
    }

    function setId_tva($id_tva) {
    if(is_numeric($id_tva)){
        $this->id_tva = $id_tva;
        }
    }
    
    function getUrl_image() {
        return $this->url_image;
    }
    
    function setUrl_image($url_image) {
    if(is_string($url_image)){
        $this->url_image = $url_image;
        }
    }


}       
            
        
        

