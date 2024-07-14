<?php
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

$index = new ModeliXe('index.mxt');
$index -> SetModeliXe();

/* attribution des constantes : couleurs, version */
$index -> MxAttribut('couleur_fond', $Color_Fond);
$index -> MxAttribut('couleur_tableaux', $Color_Tableaux);
$index -> MxAttribut('color_hr', $Color_HR);
$index -> MxText('version', $Version);
$index -> MxText('titre', 'Il y a actuellement '.nbr_cartes().' cartes postales dans la base de donnée.');
$index -> MxText('dates', 'Elles vont de '.MaxAndMinDate());

/* bloc_ville */
$result = connect("SELECT * FROM $table WHERE pays='F' AND departement!='00' AND ville!='x'");

$index -> WithMxPath('bloc_ville', 'relative');

$ville = array();

while($row = mysql_fetch_array($result))
     $ville[] = $row['ville'];

$ville = ValeursUniques($ville);
sort($ville);

$a = 1;
for ($cpt=0; $cpt < count($ville); $cpt++)
{
  if ($a == $NbrColIndex + 1) $a = 1;
  if ($a == 1)
     $index -> MxText('index_ville', '<tr><td><a href="recherche.php?ville='.$ville[$cpt].'">'.ville($ville[$cpt]).'</a></td>');
  elseif($a == $NbrColIndex)
     $index -> MxText('index_ville', '<td><a href="recherche.php?ville='.$ville[$cpt].'">'.ville($ville[$cpt]).'</a></td></tr>');
  else
     $index -> MxText('index_ville', '<td><a href="recherche.php?ville='.$ville[$cpt].'">'.ville($ville[$cpt]).'</a></td>');

  $index -> MxBloc('', 'loop');
  $a++;
}

/* fin bloc_ville */

$index -> WithMxPath('');

/* bloc departement */

$result = connect("SELECT * FROM $table WHERE departement!='99' AND ville!='x' AND departement!='x'");

$index -> WithMxPath('bloc_departement', 'relative');

$departement = array();

while($row = mysql_fetch_array($result))
     $departement[] = $row['departement'];

$departement = ValeursUniques($departement);
sort($departement);

$a = 1;
for ($cpt=0; $cpt < count($departement); $cpt++)
{
 if ($a == $NbrColIndex + 1) $a = 1;
 if ($a == 1)
    $index -> MxText('index_departement', '<tr><td><a href="recherche.php?departement='.$departement[$cpt].'">'.departement($departement[$cpt]).' ('.ereg_replace('99', '', $departement[$cpt]).')</a></td>');
 elseif($a == $NbrColIndex)
    $index -> MxText('index_departement', '<td><a href="recherche.php?departement='.$departement[$cpt].'">'.departement($departement[$cpt]).' ('.ereg_replace('99', '', $departement[$cpt]).')</a></td></tr>');
 else
     $index -> MxText('index_departement', '<td><a href="recherche.php?departement='.$departement[$cpt].'">'.departement($departement[$cpt]).' ('.ereg_replace('99', '', $departement[$cpt]).')</a></td>');
 $index -> MxBloc('', 'loop');
 $a++;
}

/* fin bloc departement */

$index -> WithMxPath('');

/* bloc pays */

$result = connect("SELECT * FROM $table WHERE departement='99' AND pays!='x'");

$index -> WithMxPath('bloc_pays', 'relative');

$pays = array();

while($row = mysql_fetch_array($result))
     $pays[] = $row['pays'];

$pays = ValeursUniques($pays);
sort($pays);

$a = 1;
for ($cpt=0; $cpt < count($pays); $cpt++)
{
  if ($a == $NbrColIndex + 1) $a = 1;
  if ($a == 1)
     $index -> MxText('index_pays', '<tr><td><a href="recherche.php?pays='.$pays[$cpt].'">'.pays($pays[$cpt]).'</a></td>');
  elseif($a == $NbrColIndex)
     $index -> MxText('index_pays', '<td><a href="recherche.php?pays='.$pays[$cpt].'">'.pays($pays[$cpt]).'</a></td></tr>');
  else
     $index -> MxText('index_pays', '<td><a href="recherche.php?pays='.$pays[$cpt].'">'.pays($pays[$cpt]).'</a></td>');

  $index -> MxBloc('', 'loop');
  $a++;
}

/* fin bloc pays */

$index -> WithMxPath('');

/* bloc ville etrangère */

$result = connect("SELECT * FROM $table WHERE departement='99' AND ville!='x'");

$index -> WithMxPath('bloc_ville_e', 'relative');

$ville_e = array();

while($row = mysql_fetch_array($result))
     $ville_e[] = $row['ville'];

$ville_e = ValeursUniques($ville_e);
sort($ville_e);

$a = 1;
for ($cpt=0; $cpt < count($ville_e); $cpt++)
{
  if ($a == $NbrColIndex + 1) $a = 1;
  if ($a == 1)
     $index -> MxText('index_ville_e', '<tr><td><a href="recherche.php?ville='.$ville_e[$cpt].'">'.ville($ville_e[$cpt]).'</a></td>');
  elseif($a == $NbrColIndex)
     $index -> MxText('index_ville_e', '<td><a href="recherche.php?ville='.$ville_e[$cpt].'">'.ville($ville_e[$cpt]).'</a></td></tr>');
  else
     $index -> MxText('index_ville_e', '<td><a href="recherche.php?ville='.$ville_e[$cpt].'">'.ville($ville_e[$cpt]).'</a></td>');

  $index -> MxBloc('', 'loop');
  $a++;
}

/* fin bloc ville etrangère */

$index -> WithMxPath('');

/* bloc divers */
$index -> WithMxPath('bloc_divers', 'relative');

sort($Divers);

$a = 1;
for ($cpt=0; $cpt < count($Divers); $cpt++)
{
  if ($a == $NbrColIndex + 1) $a = 1;
  if ($a == 1)
     $index -> MxText('index_divers', '<tr><td><a href="recherche.php?autre='.$Divers[$cpt].'">'.$Divers[$cpt].'</a></td>');
  elseif($a == $NbrColIndex)
     $index -> MxText('index_divers', '<td><a href="recherche.php?autre='.$Divers[$cpt].'">'.$Divers[$cpt].'</a></td></tr>');
  else
    $index -> MxText('index_divers', '<td><a href="recherche.php?autre='.$Divers[$cpt].'">'.$Divers[$cpt].'</a></td>');

 $index -> MxBloc('', 'loop');
 $a++;
}

/* fin bloc divers */

$index -> MxWrite();
?>
