<?
/*************************
 *     PHPMyCPA v2.1     *
 *   Olivier Vanhoucke   *
 *  webmaster@nanouk.org *
 * http://www.nanouk.org *
 *     janvier 2002      *
 *************************/

include('ModeliXe.php');
include('MySQL.inc.php');
include('fonctions.inc.php');
include('config.inc.php');

$recherche = new ModeliXe('recherche.mxt');
$recherche -> SetModeliXe();

/* attribution des constantes : couleurs, version */
$recherche -> MxAttribut('couleur_fond', $Color_Fond);
$recherche -> MxAttribut('couleur_tableaux', $Color_Tableaux);
$recherche -> MxAttribut('color_hr', $Color_HR);
$recherche -> MxText('version', $Version);

/* bloc_titre */
$recherche -> WithMxPath('bloc_titre');
if (isset($ville)) $titre = 'Recherche dans la ville de : '.ville($ville);
elseif (isset($departement)) $titre = 'Recherche dans le département : '.departement($departement);
elseif (isset($pays)) $titre = 'Recherche dans le pays : '.pays($pays);
elseif (isset($autre)) $titre = 'Recherche avec comme mot clé : '.$autre;
elseif (isset($tout)) $titre = 'La collection complète';
$recherche -> MxText('titre', $titre);
/* fin bloc_titre */

$recherche -> WithMxPath('');

if (isset($tout) && $tout == 1)
   $result = connect("SELECT * FROM $table ORDER BY ville ASC");
elseif (isset($pays))
    $result = connect("SELECT * FROM $table WHERE pays='$pays' ORDER BY ville ASC");
elseif (isset($autre))
    $result = connect("SELECT * FROM $table WHERE description REGEXP '$autre' ORDER BY ville ASC");
else
    $result = connect("SELECT * FROM $table WHERE ville='$ville' OR departement='$departement' AND !(description REGEXP 'Série') ORDER BY ville ASC");

/* bloc_recherche */
$recherche -> WithMxPath('bloc_recherche', 'relative');
$i = 1;
while($row = mysql_fetch_array($result))
{
  $id          = $row['id'];
  $description = $row['description'];
  $date        = $row['date'];
  $ville       = $row['ville'];
  $departement = $row['departement'];
  $pays        = $row['pays'];

  if ($date == 0) $date = '';
  else $date = ' - '.$date;

  if ($i == $NbrColRech + 1) $i=1;

  if ($i == 1)
     $affichage = '<tr><td align="center" width="150">'."\n";
  else
     $affichage = '<td align="center" width="150">'."\n";

  $affichage .= '<table border="0" width="130" CELLSPACING="0" CELLPADDING="0"><tr>'."\n";
  $affichage .= '<td align=center>'."\n";
  $affichage .= '<br><a href="big.php?id='.$id.'"><img src="small/'.id2file($id).'" border="0" alt="Cliquez pour agrandir"></a>'."\n";
  $affichage .= '</td></tr><tr>'."\n";
  $affichage .= '<td align="center"><small>'."\n";
  if ($pays == 'F')
     $affichage .= '<a href="recherche.php?ville='.$ville.'">'.ville2($ville).'</a> (<a href="recherche.php?departement='.$departement.'">'.ereg_replace('99', '', $departement).'</a>)'.$date.'<br>'.$description."\n";
  else
     $affichage .= '<a href="recherche.php?ville='.$ville.'">'.ville2($ville).'</a> (<a href="recherche.php?pays='.$pays.'">'.pays($pays).'</a>)'.$date.'<br>'.$description."\n";
  $affichage .= '</small></td>'."\n";
  $affichage .= '</tr></table>'."\n";

  if ($i == $NbrColRech)
     $affichage .= '</td></tr>'."\n";
  else
     $affichage .= '</td>'."\n";

  $recherche -> MxText('recherche', $affichage);
  $recherche -> MxBloc('', 'loop');

  $i++;
}

/* fin bloc_recherche */

$recherche -> MxWrite();
?>
