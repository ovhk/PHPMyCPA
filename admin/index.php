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
<input type="submit" name="base" value="Cr�er la base de donn�es">
<?php
if($base == 'Cr�er la base de donn�es')
{
  $res = read_file();
  if ($res) echo '<font color="red">La base a �t� cr��e avec succ�s</font>';
  else echo '<font color="red">ECHEC � la cr�ation</font>';
}
else
{
  $base = '';
  $res  = '';
}
?>
