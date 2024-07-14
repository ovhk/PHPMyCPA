<?php
/*************************
 *     PHPMyCPA v2.1     *
 *   Olivier Vanhoucke   *
 *  webmaster@nanouk.org *
 * http://www.nanouk.org *
 *     janvier 2002      *
 *************************/
include('config.inc.php');
$size = GetImageSize($image);
$width = $size[0];
$height = $size[1];
$image = ImageCreateFromJpeg($image);

$black = imageColorResolve($image, 0, 0, 0); // noir
$white = imageColorResolve($image, 255, 255, 255); // blanc
/*   NE MARCHE PAS CHEZ CERTAIN HEBERGEUR -> lib GD

detection de la moyenne des teintes pour ecrire soit en noir, soit en blanc

for($i=1,$moy_color=0;$i<=10;$i++)
{
 $color_index = ImageColorat($image, ($width - 1.2 * $i), ($height - 20 * $i));
 $tbl_colors = ImageColorsForIndex($image, $color_index);
 $moy_color = $moy_color + $tbl_colors["red"] + $tbl_colors["green"] + $tbl_colors["blue"];
}

$moy_color = $moy_color / 30;

if ($moy_color >= 128) $color = $black;
else $color = $white;
*/

$color = $white; // couleur par defaut

ImageStringUp($image, $Taille_Char, ($width - 20), ($height - 15), $Copyright, $color);
//header("Content-type: image/jpeg");
ImageJPEG($image);
ImageDestroy($image);
?>
