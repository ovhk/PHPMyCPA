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
         PHPMy Cartes Postales Anciennes est écrit en <a href="http://www.php.net">php</a> et utilise
         le moteur de Template <a href="http://modelixe.phpedit.com">ModeliXe</a>
         ainsi que <a href="http://www.mysql.com">MySQL</a>.<br>
         Le but de ce script était dans un premier temps de pouvoir afficher proprement une collection
         de cartes postales.<br>
         Ensuite, il fallait pouvoir faire des recherches automatisées,
         c'est là que MySQL intervient : à partir du nom du fichier, une base de données est générée
         informant des champs (pays, département, ville, description, date), ce qui rend une recherche
         beaucoup plus simple.<br>
         Puis, une fois le code bien avancé, il a fallu commencer à scanner la collection pour faire
         les premiers tests. Il fallait donc scanner, enregistrer les grandes images, redimensionner
         pour faire des miniatures, réenregistrer, puis comme il s'agit là uniquement de la
         correspondance familliale sauvée des flammes puis de l'humidité, je me devais d'indiquer
         sur chaque photo "Collection Vanhoucke". C'est là que vite débordé : il y a plus de 1200
         cartes, je me suis lancé dans la programmation d'un script automatisant toutes ces étapes
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
<font class="copyright">Généré par <a href="info.php">PHPMyCPA</a> <mx:text id="version"/> en <mx:performanceTracer /> sec.</font>
</center>
</body>

</html>
