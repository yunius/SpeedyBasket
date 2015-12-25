<?php

if(isset($_POST['updLCommande']) && isset($_POST['qteLCommande'])) {
    $managerU = new Gestion_Ligne_Commande();
    $panier = new Panier();
    $lignCommAupd = $managerU->getLigneCommande($_COOKIE['NumCommande'], $_POST['idArticle']);
    $lignCommAupd->setQte_Cmde($_POST['qteLCommande']);
    $readylignecommande = $panier->verifStock($lignCommAupd);
    $managerU->updateLigneCommande($readylignecommande);
    header('location:index.php');

}

if(isset($_POST['supprimerLCommande'])) {
    $managerS = new Gestion_Ligne_Commande();
    $lignCommAsupp = $managerS->getLigneCommande($_COOKIE['NumCommande'], $_POST['idArticle']);
    $managerS->deleteLigneCommande($lignCommAsupp);
    header('location:index.php');
}

if (isset($_COOKIE['NumCommande'])) {
    echo '<div id="message"> commande en cours de traitement : commande n°'.$_COOKIE['NumCommande'].'</div>';
}
else {
    echo '<div id="message"> aucune commande n\'est en cours de traitement</div>';
}

if(isset($_POST['valider']) && !isset($_COOKIE['NumCommande'])) {
            $panier = new Panier();
            if($panier->okStock($_POST['id'])) {
                
                $panier = new Panier();
                $managerC = new Gestion_Commande();
                $nvelleCommande = array();
                $macommande = new Commande($nvelleCommande);
                $managerC->addCommande($macommande);
                $numcommande = $managerC->getLastCommande();
                setcookie('NumCommande',$numcommande,time()+3600*24,null, null, false, true);
                $newligneCommande = array ( 'id_Article' => $_POST['id'],
                                           'id_Commande'=> $numcommande,
                                           'qte_Cmde'   => $_POST['qte']);
                $lignecommande = new Ligne_commande($newligneCommande);
                $managerL = new Gestion_Ligne_Commande();
                $managerL->addLigneCommande($lignecommande);
                header('location:index.php');  
            } 
            
            
            
}

if(isset($_POST['valider']) && isset($_COOKIE['NumCommande'])) {         
            $panier = new Panier();
            if($panier->okStock($_POST['id'])) {
                    
                    $newligneCommande = array ( 'id_Article' => $_POST['id'],
                                       'id_Commande'=> $_COOKIE['NumCommande'],
                                       'qte_Cmde'   => $_POST['qte']);
                    $malignecommande = new Ligne_commande($newligneCommande);

                    $managerL = new Gestion_Ligne_Commande();
                    if($managerL->exists($malignecommande)) {               
                        $oldlignecommande = $managerL->getLigneCommande($malignecommande->getId_Commande(), $malignecommande->getId_Article());
                        $oldQte = $oldlignecommande->getQte_Cmde();
                        $newQte = $oldQte+$_POST['qte'];
                        $oldlignecommande->setQte_Cmde($newQte);
                        $newlignecommande = $panier->verifStock($oldlignecommande);
                        $managerL->updateLigneCommande($newlignecommande);
                        
                    }
                    else {
                    $lignecommande = $panier->verifStock($malignecommande);
                    $managerL->addLigneCommande($lignecommande);

                    }
            } 
            
}

if(isset($_POST['validerCommande']) && isset($_COOKIE['NumCommande'])) {
            $managerC = new Gestion_Commande();
            $panier = new Panier();
            $commandeAvalider = $managerC->getCommande($_COOKIE['NumCommande']);
            $commandeAvalider->setId_statut(2);
            $panier->updateStocks($_COOKIE['NumCommande']);
            $managerC->updateCommande($commandeAvalider);
            setcookie('NumCommande',$_COOKIE['NumCommande'],time(),null, null, false, true);
            header('location:index.php');
}

if(isset($_POST['AnnulerCommande']) && isset($_COOKIE['NumCommande'])) {
            $managerC = new Gestion_Commande();
            $panier = new Panier();
            $commandeAannuler = $managerC->getCommande($_COOKIE['NumCommande']);
            $managerC->deleteCommande($commandeAannuler);
            setcookie('NumCommande',$_COOKIE['NumCommande'],time(),null, null, false, true);
            header('location:index.php');
}

?>

<body>
    <table class="aff_prod">
            <tr>
                    <th>image</th>
                    <th>designation</th>
                    <th>prix ht</th>
                    <th>prix ttc</th>
                    <th>description</th>
                    <th>categorie</th>
                    <th>taux de tva</th>
            </tr>
            <?php $affichage = new Panier();
            echo $affichage->afficherArticles();
            ?>
    </table>
    
    <div class="panier">
        <ul>
            <?php
            if (isset($_COOKIE['NumCommande'])) {
                echo $affichage->afficherPanier($_COOKIE['NumCommande']);
            }
            ?>
        </ul>
    </div>
</body>
</html>

