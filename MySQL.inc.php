<?php
/*************************
 *     PHPMyCPA v2.1     *
 *   Olivier Vanhoucke   *
 *  webmaster@nanouk.org *
 * http://www.nanouk.org *
 *     janvier 2002      *
 *************************/

function connect($sql)
{
  include('config.inc.php');

  if ($connect = mysql_connect($cfgHote, $cfgUser, $cfgPass))
  {
    mysql_select_db($db);
    if ($result = mysql_query($sql))
       $return = $result;
    else
       $return = FALSE;
  }

  mysql_close($connect);
  return $return;
}

/* Fonctions pour les statistiques */

function nbr_cartes()
{
  include('config.inc.php');
  $tot = mysql_num_rows(connect("SELECT * FROM $table"));
  return $tot;
}

function MaxAndMinDate()
{
  include('config.inc.php');
  $max = mysql_fetch_row(connect("SELECT MAX(date) FROM $table"));
  $min = mysql_fetch_row(connect("SELECT MIN(date) FROM $table WHERE date!='0'"));
  $dates = $min[0].' à '.$max[0].'.';
  return $dates;
}

function nbr_ville()
{
  include('config.inc.php');
  include('fonctions.inc.php');
  $result = connect("SELECT ville FROM $table");
  while($row = mysql_fetch_array($result))
     $ville[] = $row['ville'];
  $ville = ValeursUniques($ville);
  return count($ville);
}

function nbr_pays()
{
  include('config.inc.php');
  //include("fonctions.inc.php");
  $result = connect("SELECT pays FROM $table");
  while($row = mysql_fetch_array($result))
     $pays[] = $row['pays'];
  $pays = ValeursUniques($pays);
  return count($pays);
}
?>
