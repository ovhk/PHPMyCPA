<?php
/*************************
 *     PHPMyCPA v2.1     *
 *   Olivier Vanhoucke   *
 *  webmaster@nanouk.org *
 * http://www.nanouk.org *
 *     janvier 2002      *
 *************************/

/* Version de PHPMyCPA */
$Version = 'v2.1';

/* copyright */
$Copyright = '(c) Collection Vanhoucke'; // texte
$Taille_Char = 2;                        // taille des caract�res

/* pourcentage de r�duction des miniatures (small) */
$Taille_Small = 23 / 100;      // 23%

/* config de MySQL */
$cfgHote = '';        // nom du serveur
$cfgUser = '';        // nom de l'utilisateur
$cfgPass = '';        // mot de passe
$db      = '';        // nom de la base
$table   = '';        // nom de la table

/* Couleurs */
$Color_Fond     = '#F5F3CF';   // couleur de fond des pages
$Color_Tableaux = '#F6F6F6';   // couleur de fond des tableaux
$Color_HR       = '#764F33';   // couleur des balises <hr>
/* pour la couleur du texte, voir styles.css */

/* mots cl�s de recherche */
$Divers = array('Arm�e', 'Basilique', 'Bateau', 'Cath�drale', 'Chapelle', 'Ch�teau', 'Ecole',
                'Eglise', 'Fort', 'Gare', 'Guerre', 'Inondations', 'March�', 'Moulin', 'Phare',
                'Pont', 'S�rie', 'Tour', 'Viaduc');

/* repertoires */
$dir_big       = 'big';
$dir_small     = 'small';
$dir_originaux = 'originaux';

/* nbr de colonnes tableaux */
$NbrColIndex = 4;    // dans l'index des villes, pays, d�partements
$NbrColRech  = 5;    // dans l'affichage des miniatures
?>
