ALTER TABLE `tb_ligne_commande` 
DROP FOREIGN KEY `FK_ligne_commande_id_commande`;
 
ALTER TABLE `tb_ligne_commande` 
    ADD CONSTRAINT `FK_ligne_commande_id_commande` FOREIGN KEY (`id_commande`) 
    REFERENCES `db_speedymarket`.`tb_commande`(`id_commande`) 
    ON DELETE CASCADE ON UPDATE RESTRICT;
