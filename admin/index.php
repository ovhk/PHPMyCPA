<?php
/*************************
 *     PHPMyCPA v2.1     *
 *   Olivier Vanhoucke   *
 *  webmaster@nanouk.org *
 * http://www.nanouk.org *
 *     janvier 2002      *
 *************************/

include('fonctions.inc.php');

if(!isset($base)) $base = '';
?>
<form action="<? echo $PHP_SELF; ?>" method="post">
<input type="submit" name="base" value="Créer la base de données">
<?php
if($base == 'Créer la base de données')
{
  $res = read_file();
  if ($res) echo '<font color="red">La base a été créée avec succès</font>';
  else echo '<font color="red">ECHEC à la création</font>';
}
else
{
  $base = '';
  $res  = '';
}
?>
