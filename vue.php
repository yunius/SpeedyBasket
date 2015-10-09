<?php

if(isset($_POST['updLCommande']) && isset($_POST['qteLCommande'])) {
    $managerU = new Gestion_Ligne_Commande();
    $lignCommAupd = $managerU->getLigneCommande($_COOKIE['NumCommande'], $_POST['idArticle']);
    $lignCommAupd->setQte_Cmde($_POST['qteLCommande']);
    $managerU->updateLigneCommande($lignCommAupd);
    header('location:index.php');

}

if(isset($_POST['supprimerLCommande'])) {
    $managerS = new Gestion_Ligne_Commande();
    $lignCommAsupp = $managerS->getLigneCommande($_COOKIE['NumCommande'], $_POST['idArticle']);
    $managerS->deleteLigneCommande($lignCommAsupp);
    header('location:index.php');
}

if (isset($_COOKIE['NumCommande'])) {
    echo 'commande en cours de traitement : commande n°'.$_COOKIE['NumCommande'].'<br />';
}
else {
    echo 'aucune commande n\'est en cours de traitement';
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
                    $cmd_Qte = $panier->verifStock($_POST['id'], $_POST['qte']);
                    $newligneCommande = array ( 'id_Article' => $_POST['id'],
                                       'id_Commande'=> $_COOKIE['NumCommande'],
                                       'qte_Cmde'   => $cmd_Qte);
                    $malignecommande = new Ligne_commande($newligneCommande);

                    $managerL = new Gestion_Ligne_Commande();
                    if($managerL->exists($malignecommande)) {               
                        $oldlignecommande = $managerL->getLigneCommande($malignecommande->getId_Commande(), $malignecommande->getId_Article());
                        $oldQte = $oldlignecommande->getQte_Cmde();
                        $newQte = $oldQte+$_POST['qte'];
                        $oldlignecommande->setQte_Cmde($newQte);
                        $managerL->updateLigneCommande($oldlignecommande);
                        echo $panier->okStock($_POST['id']);
                    }
                    else {
                    $managerL->addLigneCommande($malignecommande);

                    }
            } 
            
}

if(isset($_POST['validerCommande']) && isset($_COOKIE['NumCommande'])) {
            $managerC = new Gestion_Commande();
            $commandeAvalider = $managerC->getCommande($_COOKIE['NumCommande']);
            $commandeAvalider->setId_statut(2);
            $managerC->updateCommande($commandeAvalider);
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
                    <th>taux tva</th>
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

