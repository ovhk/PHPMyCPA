<html>

<head>
<TITLE>Cartes postales Anciennes - PHPMyCPA <mx:text id="version"/> - Informations</TITLE>
<LINK rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body mXattribut="bgcolor:couleur_fond">
<center>
<table border="0" width="100%">
 <tr>
  <td width="110"><img src="img/logo_cpa.gif"></td>
  <td align="center"><a href=""><img src="img/cpa.gif" border="0"></a></td>
 </tr>
</table>
<table border="0" width="65%">
 <tr>
  <td>
      <small>
         PHPMy Cartes Postales Anciennes est �crit en <a href="http://www.php.net">php</a> et utilise
         le moteur de Template <a href="http://modelixe.phpedit.com">ModeliXe</a>
         ainsi que <a href="http://www.mysql.com">MySQL</a>.<br>
         Le but de ce script �tait dans un premier temps de pouvoir afficher proprement une collection
         de cartes postales.<br>
         Ensuite, il fallait pouvoir faire des recherches automatis�es,
         c'est l� que MySQL intervient : � partir du nom du fichier, une base de donn�es est g�n�r�e
         informant des champs (pays, d�partement, ville, description, date), ce qui rend une recherche
         beaucoup plus simple.<br>
         Puis, une fois le code bien avanc�, il a fallu commencer � scanner la collection pour faire
         les premiers tests. Il fallait donc scanner, enregistrer les grandes images, redimensionner
         pour faire des miniatures, r�enregistrer, puis comme il s'agit l� uniquement de la
         correspondance familliale sauv�e des flammes puis de l'humidit�, je me devais d'indiquer
         sur chaque photo "Collection Vanhoucke". C'est l� que vite d�bord� : il y a plus de 1200
         cartes, je me suis lanc� dans la programmation d'un script automatisant toutes ces �tapes
         afin de traiter les photos directement sorties du scanner.
      </small><br><br><br>
  </td>
 </tr>
 <tr>
  <td><u>Voici quelques statistiques</u></td>
 </tr>
 <tr>
  <td>
   <mx:text id="nbr_cartes"/> cartes postales de <mx:text id="dates"/><br>
   <mx:text id="nbr_ville"/> villes<br>
   <mx:text id="nbr_pays"/> pays<br>
  </td>
 </tr>
</table>
<br>
<hr width="90%" mXattribut="color:color_hr">
<a href="mailto:webmaster@nanouk.org"><small>Olivier Vanhoucke</small></a>
<br>
<font class="copyright">G�n�r� par <a href="info.php">PHPMyCPA</a> <mx:text id="version"/> en <mx:performanceTracer /> sec.</font>
</center>
</body>

</html>
