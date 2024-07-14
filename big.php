<?php
/*************************
 *     PHPMyCPA v2.1     *
 *   Olivier Vanhoucke   *
 *  webmaster@nanouk.org *
 * http://www.nanouk.org *
 *     janvier 2002      *
 *************************/

include('fonctions.inc.php');
include('MySQL.inc.php');
include('ModeliXe.php');
include('config.inc.php');

$big = new ModeliXe('big.mxt');
$big -> SetModeliXe();

/* attribution des constantes : couleurs, version */
$big -> MxAttribut('couleur_fond', $Color_Fond);
$big -> MxAttribut('couleur_tableaux', $Color_Tableaux);
$big -> MxAttribut('color_hr', $Color_HR);
$big -> MxText("version", $Version);

$result = connect("SELECT * FROM $table WHERE id='$id'");
$row = mysql_fetch_array($result);

while(list($key,$val) = each($row))
     ${$key} = $val;

if ($date == 0) $date = '';
else $date = ' - '.$date;

$big -> MxText('image', ombre_big($dir_big.'/'.id2file($id)));

if ($pays == 'F')
   $affichage = ville2($ville).' ('.ereg_replace('99', '', $departement).')'.$date.'<br>'.$description;
else
   $affichage = ville2($ville).' ('.pays($pays).')'.$date.'<br>'.$description;

$big -> MxText('texte', $affichage);

$big -> MxWrite();
?>
