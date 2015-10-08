<?php

function classLoad($classname) {
	require $classname.'.php';
}
spl_autoload_register('classLoad');

?>


<!DOCTYPE html>

<html>
<head>
	<title>SpeedyMarket</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="template/panier.css"/>
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
</head>
        
    
        
        
          <?php
            include 'vue.php';
          
            //$panier = new Panier();
            //$panier->nbArticleParTVA(12);
            
            /*$manager = new Gestion_Commande();
            $MesCommandes = $manager->getCommmandes();
            var_dump($MesCommandes);*/
            
            /*$nvelleCommande = array();
            $commande = new Commande($nvelleCommande);
            $manager->addCommande($commande);*/
            /*$manager = new Gestion_Articles();
            $produit = $manager->getArticle(13);
            $nomProduit = $produit->getA_designation();
            
            
            $tva = $manager->getTva($produit);
            
            echo 'le produit - '.$nomProduit.' - a un taux de TVA de '.$tva.'%';*/
            
            
            
            
          ?>  
        
        
    </body>
</html>
