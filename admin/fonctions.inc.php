<?php
/*************************
 *     PHPMyCPA v2.1	 *
 *   Olivier Vanhoucke	 *
 *  webmaster@nanouk.org *
 * http://www.nanouk.org *
 *     janvier 2002	 *
 *************************/

function make_small($image)
{
 include('../config.inc.php');
 $size = GetImageSize($image);
 $width_src   = $size[0];
 $height_src  = $size[1];
 $width_dest  = $width_src * $Taille_Small;
 $height_dest = $height_src * $Taille_Small;
 $img_src = ImageCreateFromJpeg($image);
 $img_dest = ImageCreate($width_dest,$height_dest);
 ImageCopyResized($img_dest, $img_src, 0, 0, 0, 0, $width_dest, $height_dest, $width_src, $height_src);
 $image = ereg_replace('../'.$dir_big.'/', '', $image);
 ImageJPEG($img_dest, '../'.$dir_small.'/'.$image);
 ImageDestroy($img_dest);
}

function save_base($pays, $departement, $ville, $description, $date)
{
  include('../config.inc.php');
  $connect = @mysql_connect($cfgHote, $cfgUser, $cfgPass);
  mysql_select_db($db);
  $liste_valeurs = "'', '$pays', '$departement', '$ville', '$description', '$date'";
  $sql = "INSERT INTO $table VALUES ($liste_valeurs)";
  $result = mysql_query($sql);
  mysql_close($connect);
  return $result;
}

function chn2file($chaine)
{
  $chaine = strtr($chaine,
		 'ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ',
		 'AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn');
  $chaine = strtolower($chaine);
  return $chaine;
}

function read_file()
{
  include('../config.inc.php');
  $dir = '../'.$dir_originaux;
  $ma_liste = '';
  $myDirectory = opendir($dir);
  while($entryName = readdir($myDirectory))
  {
   if ($entryName != '.' && $entryName != '..')
   {
     $ma_liste .= '$entryName'.'|' ;
   }
  }
  closedir($myDirectory);
  $entree = explode('|', $ma_liste);
  $nbr_entree = (count($entree)-1);

  for($i=0;$i<$nbr_entree;$i++)
  {
    copy($dir.'/'.$entree[$i], '../'.$dir_big.'/'.chn2file($entree[$i]));
    make_small('../'.$dir_big.'/'.chn2file($entree[$i])); // creation des miniatures
    $tbl_entree[$i] = explode('__', $entree[$i]);
  }

  for($j=0;$j<$nbr_entree;$j++)
  {
    $pays = $tbl_entree[$j][0];
    $departement = $tbl_entree[$j][1];
    $ville = ereg_replace('_', ' ', $tbl_entree[$j][2]);
    $description = ereg_replace('_', ' ', $tbl_entree[$j][3]);
    if ($tbl_entree[$j][4][0] == 0) $date = 0;
    else $date = substr($tbl_entree[$j][4], 0, 4);

    if ($result = save_base($pays, $departement, $ville, $description, $date)) $result = $result & TRUE;
  }
  return $result;
}
?>

