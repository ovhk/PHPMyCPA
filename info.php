<?
/*************************
 *     PHPMyCPA v2.1     *
 *   Olivier Vanhoucke   *
 *  webmaster@nanouk.org *
 * http://www.nanouk.org *
 *     janvier 2002      *
 *************************/

include('ModeliXe.php');
include('config.inc.php');
include('MySQL.inc.php');

$info = new ModeliXe('info.mxt');
$info -> SetModeliXe();

/* attribution des constantes : couleurs, version */
$info -> MxAttribut('couleur_fond', $Color_Fond);
$info -> MxAttribut('color_hr', $Color_HR);
$info -> MxText('version', $Version);

/* STATISTIQUES */
$info -> MxText('nbr_cartes', nbr_cartes());
$info -> MxText('dates', MaxAndMinDate());
$info -> MxText('nbr_ville', nbr_ville());
$info -> MxText('nbr_pays', nbr_pays());

$info -> MxWrite();
?>
