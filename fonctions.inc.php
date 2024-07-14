<?php
/*************************
 *     PHPMyCPA v2.1	 *
 *   Olivier Vanhoucke	 *
 *  webmaster@nanouk.org *
 * http://www.nanouk.org *
 *     janvier 2002	 *
 *************************/

function ombre_big($image)
{
	if(!is_readable($image))
	{
		die('image introuvable');
	}

	$taille = GetImageSize($image);
	$html = '<table border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td rowspan="2" colspan="2">
				<a href="javascript:window.history.back()">
				  <img src="copyright.php?image='.$image.'" border="0" alt="Retour">
				</a></td>
				<td><img src="img/ombre_1.gif"></td>
			</tr>
			<tr>
				<td><img src="img/ombre_2.gif" height="'.($taille[1]-5).'" width="6"></td>
			</tr>
			<tr>
				<td><img src="img/ombre_3.gif"></td>
				<td><img src="img/ombre_4.gif" height="8" width="'.($taille[0]-7).'"></td>
				<td><img src="img/ombre_5.gif"></td>
			</tr>
		</table>';

	return $html;
}

function ValeursUniques($tableau)
{
  // On r�cup�re les m�mes valeurs dans 1 seule case
  $uTableau = array();
  for ($i = 0, $n = count($tableau); $i < $n; $i++)
    $uTableau[$tableau[$i]] = 1;

  // On cr�e le nouveau tableau
  reset($uTableau);
  $tUnique = array();
  for ($i = 0, $n = count($uTableau); $i < $n; $i++) {
    $tUnique[] = key($uTableau);
    next($uTableau);
  }
  return $tUnique;
}

function id2file($id)
{
  include('config.inc.php');

  $sql = "SELECT * FROM $table WHERE id=$id";

  if (mysql_connect($cfgHote, $cfgUser, $cfgPass))
  {
    mysql_select_db($db);
    if ($result = mysql_query($sql))
    {
      $row = mysql_fetch_array($result);
      $chaine = $row['pays'].'__'.$row['departement'].'__'.$row['ville'].'__'.$row['description'].'__'.$row['date'];
    }
  }

  $chaine = strtr($chaine,
		 '�����������������������������������������������������',
		 'AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn');
  $chaine = strtolower($chaine);
  $chaine = ereg_replace(' ', '_', $chaine);
  return $chaine.'.jpg';
}

function departement($nom)
{
 $dept = array(
 '00' => 'R�gions',
 '01' => 'Ain',
 '02' => 'Aisne',
 '03' => 'Allier',
 '04' => 'Alpes de Haute Provence',
 '05' => 'Hautes Alpes',
 '06' => 'Alpes Maritimes',
 '07' => 'Ard�che',
 '08' => 'Ardennes',
 '09' => 'Ari�ge',
 '10' => 'Aube',
 '11' => 'Aude',
 '12' => 'Averyon',
 '13' => 'Bouche du Rh�ne',
 '14' => 'Calvados',
 '15' => 'Cantal',
 '16' => 'Charente',
 '17' => 'Charente Maritime',
 '18' => 'Cher',
 '19' => 'Corr�ze',
 '2a' => 'Corse du Sud',
 '2b' => 'Haute Corse',
 '21' => 'C�te d Or',
 '22' => 'C�tes d Armor',
 '23' => 'Creuse',
 '24' => 'Dordogne',
 '25' => 'Doubs',
 '26' => 'Dr�me',
 '27' => 'Eure',
 '28' => 'Eure et Loire',
 '29' => 'Finist�re',
 '30' => 'Gard',
 '31' => 'Haute Garonne',
 '32' => 'Gers',
 '33' => 'Gironde',
 '34' => 'Herault',
 '35' => 'Ille et Vilaine',
 '36' => 'Indre',
 '37' => 'Indre et Loire',
 '38' => 'Is�re',
 '39' => 'Jura',
 '40' => 'Landes',
 '41' => 'Loir et Cher',
 '42' => 'Loire',
 '43' => 'Haute Loire',
 '44' => 'Loire Atlantique',
 '45' => 'Loiret',
 '46' => 'Lot',
 '47' => 'Lot et Garonne',
 '48' => 'Loz�re',
 '49' => 'Maine et Loire',
 '50' => 'Manche',
 '51' => 'Marne',
 '52' => 'Haute Marne',
 '53' => 'Mayenne',
 '54' => 'Meurthe et Moselle',
 '55' => 'Meuse',
 '56' => 'Morbihan',
 '57' => 'Moselle',
 '58' => 'Ni�vre',
 '59' => 'Nord',
 '60' => 'Oise',
 '61' => 'Orne',
 '62' => 'Pas de Calais',
 '63' => 'Puy de D�me',
 '64' => 'Pyren�es Atlantiques',
 '65' => 'Hautes Pyren�es',
 '66' => 'Pyren�es orientales',
 '67' => 'Bas Rhin',
 '68' => 'Haut Rhin',
 '69' => 'Rh�ne',
 '70' => 'Haute Sa�ne',
 '71' => 'Sa�ne et Loire',
 '72' => 'Sarthe',
 '73' => 'Savoie',
 '74' => 'Haute Savoie',
 '75' => 'Paris',
 '76' => 'Seine Maritime',
 '77' => 'Seine et Marne',
 '78' => 'Yvelines',
 '79' => 'Deux S�vres',
 '80' => 'Somme',
 '81' => 'Tarn',
 '82' => 'Tarn et Garonne',
 '83' => 'Var',
 '84' => 'Vaucluse',
 '85' => 'Vend�e',
 '86' => 'Vienne',
 '87' => 'Haute Vienne',
 '88' => 'Vosges',
 '89' => 'Yonne',
 '90' => 'Territoire de Belfort',
 '91' => 'Essonne',
 '92' => 'Hauts de Seine',
 '93' => 'Seine Saint Denis',
 '94' => 'Val de Marne',
 '95' => 'Val d Oise',
 '971' => 'Guadeloupe',
 '972' => 'Martinique',
 '973' => 'Guyane',
 '974' => 'R�union',
 '99'  => 'Pays Etranger',
 'x' => 'Inconnus'
 );

 return $dept[$nom];
}

function pays($nom)
{
 $pays = array(
'A'   => 'Autriche',
'ADN' => 'Y�men (ex-Aden)',
'AFG' => 'Afghanistan',
'AL'  => 'Albanie',
'AND' => 'Andorre',
'AUS' => 'Australie',
'B'   => 'Belgique',
'BD'  => 'Bangladesh',
'BDS' => 'Barbade',
'BG'  => 'Bulgarie',
'BH'  => 'B�lize (ex-Honduras-britannique)',
'BOL' => 'Bolivie',
'BR'  => 'Br�sil',
'BRN' => 'Bahre�n',
'BRU' => 'Brun�i',
'BS'  => 'Bahamas',
'BUR' => 'Myanmar (ex-Birmanie)',
'BVI' => '�les Vierges',
'C'   => 'Cuba',
'CAM' => 'Cameroun',
'CDN' => 'Canada',
'CH'  => 'Suisse',
'CI'  => 'C�te d Ivoire',
'CL'  => 'Sri Lanka (ex-Ceylan)',
'CO'  => 'Colombie',
'CR'  => 'Costa Rica',
'CS'  => 'ex-Tch�coslovaquie',
'CY'  => 'Chypre',
'D'   => 'Allemagne',
'DK'  => 'Danemark',
'DOM' => 'R�p dominicaine',
'DY'  => 'B�nin (ex-Dahomey)',
'DZ'  => 'Alg�rie',
'E'   => 'Espagne',
'EAK' => 'Kenya',
'EAT' => 'Tanzanie (ex-Tanganyika)',
'EAU' => 'Ouganda',
'EAZ' => 'Tanzanie (ex-Zanzibar)',
'EC'  => '�quateur',
'EIR' => 'Irlande',
'ES'  => 'El Salvador',
'ET'  => '�gypte',
'ETH' => '�thiopie',
'EW'  => 'Estonie',
'F'   => 'France',
'FJI' => 'Fidji',
'FL'  => 'Liechtenstein',
'FR'  => '�les F�ro�',
'G'   => 'Gabon',
'GB'  => 'Royaume-Uni',
'GBA' => 'Alderney',
'GBG' => 'Guernesey',
'GBJ' => 'Jersey',
'GBM' => '�le de Man',
'GBZ' => 'Gibraltar',
'GCA' => 'Guatemala',
'GH'  => 'Ghana',
'GR'  => 'Gr�ce',
'GUY' => 'Guyana (ex-Guyane-britannique)',
'H'   => 'Hongrie',
'HJK' => 'Jordanie',
'HK'  => 'Hong Kong',
'I'   => 'Italie',
'IL'  => 'Isra�l',
'IND' => 'Inde',
'IR'  => 'Iran',
'IRL' => 'Irlande',
'IRQ' => 'Iraq',
'IS'  => 'Islande',
'J'   => 'Japon',
'JA'  => 'Jama�que',
'K'   => 'Kampuchea (ex-Cambodge)',
'KWT' => 'Kowe�t',
'KT'  => 'Kowe�t',
'L'   => 'Luxembourg',
'LAO' => 'Laos',
'LAR' => 'Libye',
'LT'  => 'Libye',
'LB'  => 'Lib�ria',
'LR'  => 'Lettonie',
'LS'  => 'Lesotho (ex-Basutoland)',
'LT'  => 'Lituanie',
'M'   => 'Malte',
'MA'  => 'Maroc',
'MAL' => 'Malaisie',
'PTM' => 'Malaisie',
'MC'  => 'Monaco',
'MEX' => 'Mexique',
'MOC' => 'Mozambique',
'MS'  => '�le Maurice',
'MW'  => 'Malawi',
'N'   => 'Norv�ge',
'NA'  => 'Antilles n�erlandaises',
'NAU' => 'Nauru',
'NEP' => 'N�pal',
'NIC' => 'Nicaragua',
'NIG' => 'Niger',
'NL'  => 'Pays-Bas',
'NZ'  => 'Nouvelle-Z�lande',
'P'   => 'Portugal',
'PA'  => 'Panama',
'PAK' => 'Pakistan',
'PE'  => 'P�rou',
'PL'  => 'Pologne',
'PNG' => 'Papouasie-Nouvelle-Guin�e',
'PY'  => 'Paraguay',
'Q'   => 'Qatar',
'RA'  => 'Argentine',
'RB'  => 'Botswana',
'RC'  => 'Ta�wan',
'RCA' => 'Centrafrique',
'RCB' => 'Congo',
'RCH' => 'Chili',
'RG'  => 'Guin�e',
'RH'  => 'Ha�ti',
'RHV' => 'Burkina',
'HV'  => 'Burkina',
'RI'  => 'Indon�sie',
'RIM' => 'Mauritanie',
'RL'  => 'Liban',
'RM'  => 'Madagascar',
'RMM' => 'Mali',
'RO'  => 'Roumanie',
'ROK' => 'Cor�e',
'ROU' => 'Uruguay',
'RP'  => 'Philippines',
'RPC' => 'Chine',
'PI'  => 'Philippines',
'RSM' => 'Saint-Marin',
'RSR' => 'Zimbabwe (ex-Rhod�sie)',
'ZW'  => 'Zimbabwe (ex-Rhod�sie)',
'RU'  => 'Burundi',
'RWA' => 'Rwanda',
'S'   => 'Su�de',
'SA'  => 'Arabie saoudite',
'SD'  => 'Swaziland',
'SF'  => 'Finlande',
'SGP' => 'Singapour',
'SME' => 'Suriname',
'SN'  => 'S�n�gal',
'SO'  => 'Somalie',
'SU'  => 'Russie (ex-URSS)',
'SUD' => 'Soudan',
'SWA' => 'Namibie',
'ZA'  => 'Namibie',
'SY'  => 'Seychelles',
'SYR' => 'Syrie',
'T'   => 'Tha�lande',
'TD'  => 'Tchad',
'TCH' => 'Tchad',
'TG'  => 'Togo',
'TN'  => 'Tunisie',
'TR'  => 'Turquie',
'TT'  => 'Trinit� et Tobago',
'U'   => 'Uruguay',
'USA' => '�tats-Unis',
'V'   => 'Vatican',
'VN'  => 'Vi�t-Nam',
'WAG' => 'Gambie',
'WAL' => 'Sierra Leone',
'WAN' => 'Nigeria',
'WD'  => 'Dominique (�les du Vent)',
'WG'  => 'Grenade (�les du Vent)',
'WL'  => 'Ste-Lucie (�les du Vent)',
'WS'  => 'Samoa occidentales',
'WV'  => 'St-Vincent (�les du vent)',
'YAR' => 'Y�men',
'YU'  => 'ex-Yougoslavie',
'YV'  => 'Venezuela',
'Z'   => 'Zambie',
'ZA'  => 'Afrique du Sud',
'ZM'  => 'Zimbabwe',
'ZR'  => 'Za�re',
'x'   => 'Inconnu'
 );
 return $pays[$nom];
}

function ville($nom)
{
 if($nom == 'x') $nom = 'Inconnues';

 return $nom;
}

function ville2($nom)
{
 if($nom == 'x') $nom = 'Inconnue';

 return $nom;
}
?>

