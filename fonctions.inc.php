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
  // On récupère les mêmes valeurs dans 1 seule case
  $uTableau = array();
  for ($i = 0, $n = count($tableau); $i < $n; $i++)
    $uTableau[$tableau[$i]] = 1;

  // On crée le nouveau tableau
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
		 'ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ',
		 'AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn');
  $chaine = strtolower($chaine);
  $chaine = ereg_replace(' ', '_', $chaine);
  return $chaine.'.jpg';
}

function departement($nom)
{
 $dept = array(
 '00' => 'Régions',
 '01' => 'Ain',
 '02' => 'Aisne',
 '03' => 'Allier',
 '04' => 'Alpes de Haute Provence',
 '05' => 'Hautes Alpes',
 '06' => 'Alpes Maritimes',
 '07' => 'Ardèche',
 '08' => 'Ardennes',
 '09' => 'Ariége',
 '10' => 'Aube',
 '11' => 'Aude',
 '12' => 'Averyon',
 '13' => 'Bouche du Rhône',
 '14' => 'Calvados',
 '15' => 'Cantal',
 '16' => 'Charente',
 '17' => 'Charente Maritime',
 '18' => 'Cher',
 '19' => 'Corrèze',
 '2a' => 'Corse du Sud',
 '2b' => 'Haute Corse',
 '21' => 'Côte d Or',
 '22' => 'Côtes d Armor',
 '23' => 'Creuse',
 '24' => 'Dordogne',
 '25' => 'Doubs',
 '26' => 'Drôme',
 '27' => 'Eure',
 '28' => 'Eure et Loire',
 '29' => 'Finistère',
 '30' => 'Gard',
 '31' => 'Haute Garonne',
 '32' => 'Gers',
 '33' => 'Gironde',
 '34' => 'Herault',
 '35' => 'Ille et Vilaine',
 '36' => 'Indre',
 '37' => 'Indre et Loire',
 '38' => 'Isère',
 '39' => 'Jura',
 '40' => 'Landes',
 '41' => 'Loir et Cher',
 '42' => 'Loire',
 '43' => 'Haute Loire',
 '44' => 'Loire Atlantique',
 '45' => 'Loiret',
 '46' => 'Lot',
 '47' => 'Lot et Garonne',
 '48' => 'Lozère',
 '49' => 'Maine et Loire',
 '50' => 'Manche',
 '51' => 'Marne',
 '52' => 'Haute Marne',
 '53' => 'Mayenne',
 '54' => 'Meurthe et Moselle',
 '55' => 'Meuse',
 '56' => 'Morbihan',
 '57' => 'Moselle',
 '58' => 'Nièvre',
 '59' => 'Nord',
 '60' => 'Oise',
 '61' => 'Orne',
 '62' => 'Pas de Calais',
 '63' => 'Puy de Dôme',
 '64' => 'Pyrenées Atlantiques',
 '65' => 'Hautes Pyrenées',
 '66' => 'Pyrenées orientales',
 '67' => 'Bas Rhin',
 '68' => 'Haut Rhin',
 '69' => 'Rhône',
 '70' => 'Haute Saône',
 '71' => 'Saône et Loire',
 '72' => 'Sarthe',
 '73' => 'Savoie',
 '74' => 'Haute Savoie',
 '75' => 'Paris',
 '76' => 'Seine Maritime',
 '77' => 'Seine et Marne',
 '78' => 'Yvelines',
 '79' => 'Deux Sèvres',
 '80' => 'Somme',
 '81' => 'Tarn',
 '82' => 'Tarn et Garonne',
 '83' => 'Var',
 '84' => 'Vaucluse',
 '85' => 'Vendée',
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
 '974' => 'Réunion',
 '99'  => 'Pays Etranger',
 'x' => 'Inconnus'
 );

 return $dept[$nom];
}

function pays($nom)
{
 $pays = array(
'A'   => 'Autriche',
'ADN' => 'Yémen (ex-Aden)',
'AFG' => 'Afghanistan',
'AL'  => 'Albanie',
'AND' => 'Andorre',
'AUS' => 'Australie',
'B'   => 'Belgique',
'BD'  => 'Bangladesh',
'BDS' => 'Barbade',
'BG'  => 'Bulgarie',
'BH'  => 'Bélize (ex-Honduras-britannique)',
'BOL' => 'Bolivie',
'BR'  => 'Brésil',
'BRN' => 'Bahreïn',
'BRU' => 'Brunéi',
'BS'  => 'Bahamas',
'BUR' => 'Myanmar (ex-Birmanie)',
'BVI' => 'îles Vierges',
'C'   => 'Cuba',
'CAM' => 'Cameroun',
'CDN' => 'Canada',
'CH'  => 'Suisse',
'CI'  => 'Côte d Ivoire',
'CL'  => 'Sri Lanka (ex-Ceylan)',
'CO'  => 'Colombie',
'CR'  => 'Costa Rica',
'CS'  => 'ex-Tchécoslovaquie',
'CY'  => 'Chypre',
'D'   => 'Allemagne',
'DK'  => 'Danemark',
'DOM' => 'Rép dominicaine',
'DY'  => 'Bénin (ex-Dahomey)',
'DZ'  => 'Algérie',
'E'   => 'Espagne',
'EAK' => 'Kenya',
'EAT' => 'Tanzanie (ex-Tanganyika)',
'EAU' => 'Ouganda',
'EAZ' => 'Tanzanie (ex-Zanzibar)',
'EC'  => 'Équateur',
'EIR' => 'Irlande',
'ES'  => 'El Salvador',
'ET'  => 'Égypte',
'ETH' => 'Éthiopie',
'EW'  => 'Estonie',
'F'   => 'France',
'FJI' => 'Fidji',
'FL'  => 'Liechtenstein',
'FR'  => 'îles Féroé',
'G'   => 'Gabon',
'GB'  => 'Royaume-Uni',
'GBA' => 'Alderney',
'GBG' => 'Guernesey',
'GBJ' => 'Jersey',
'GBM' => 'île de Man',
'GBZ' => 'Gibraltar',
'GCA' => 'Guatemala',
'GH'  => 'Ghana',
'GR'  => 'Grèce',
'GUY' => 'Guyana (ex-Guyane-britannique)',
'H'   => 'Hongrie',
'HJK' => 'Jordanie',
'HK'  => 'Hong Kong',
'I'   => 'Italie',
'IL'  => 'Israël',
'IND' => 'Inde',
'IR'  => 'Iran',
'IRL' => 'Irlande',
'IRQ' => 'Iraq',
'IS'  => 'Islande',
'J'   => 'Japon',
'JA'  => 'Jamaïque',
'K'   => 'Kampuchea (ex-Cambodge)',
'KWT' => 'Koweït',
'KT'  => 'Koweït',
'L'   => 'Luxembourg',
'LAO' => 'Laos',
'LAR' => 'Libye',
'LT'  => 'Libye',
'LB'  => 'Libéria',
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
'MS'  => 'île Maurice',
'MW'  => 'Malawi',
'N'   => 'Norvège',
'NA'  => 'Antilles néerlandaises',
'NAU' => 'Nauru',
'NEP' => 'Népal',
'NIC' => 'Nicaragua',
'NIG' => 'Niger',
'NL'  => 'Pays-Bas',
'NZ'  => 'Nouvelle-Zélande',
'P'   => 'Portugal',
'PA'  => 'Panama',
'PAK' => 'Pakistan',
'PE'  => 'Pérou',
'PL'  => 'Pologne',
'PNG' => 'Papouasie-Nouvelle-Guinée',
'PY'  => 'Paraguay',
'Q'   => 'Qatar',
'RA'  => 'Argentine',
'RB'  => 'Botswana',
'RC'  => 'Taïwan',
'RCA' => 'Centrafrique',
'RCB' => 'Congo',
'RCH' => 'Chili',
'RG'  => 'Guinée',
'RH'  => 'Haïti',
'RHV' => 'Burkina',
'HV'  => 'Burkina',
'RI'  => 'Indonésie',
'RIM' => 'Mauritanie',
'RL'  => 'Liban',
'RM'  => 'Madagascar',
'RMM' => 'Mali',
'RO'  => 'Roumanie',
'ROK' => 'Corée',
'ROU' => 'Uruguay',
'RP'  => 'Philippines',
'RPC' => 'Chine',
'PI'  => 'Philippines',
'RSM' => 'Saint-Marin',
'RSR' => 'Zimbabwe (ex-Rhodésie)',
'ZW'  => 'Zimbabwe (ex-Rhodésie)',
'RU'  => 'Burundi',
'RWA' => 'Rwanda',
'S'   => 'Suède',
'SA'  => 'Arabie saoudite',
'SD'  => 'Swaziland',
'SF'  => 'Finlande',
'SGP' => 'Singapour',
'SME' => 'Suriname',
'SN'  => 'Sénégal',
'SO'  => 'Somalie',
'SU'  => 'Russie (ex-URSS)',
'SUD' => 'Soudan',
'SWA' => 'Namibie',
'ZA'  => 'Namibie',
'SY'  => 'Seychelles',
'SYR' => 'Syrie',
'T'   => 'Thaïlande',
'TD'  => 'Tchad',
'TCH' => 'Tchad',
'TG'  => 'Togo',
'TN'  => 'Tunisie',
'TR'  => 'Turquie',
'TT'  => 'Trinité et Tobago',
'U'   => 'Uruguay',
'USA' => 'États-Unis',
'V'   => 'Vatican',
'VN'  => 'Viêt-Nam',
'WAG' => 'Gambie',
'WAL' => 'Sierra Leone',
'WAN' => 'Nigeria',
'WD'  => 'Dominique (îles du Vent)',
'WG'  => 'Grenade (îles du Vent)',
'WL'  => 'Ste-Lucie (îles du Vent)',
'WS'  => 'Samoa occidentales',
'WV'  => 'St-Vincent (îles du vent)',
'YAR' => 'Yémen',
'YU'  => 'ex-Yougoslavie',
'YV'  => 'Venezuela',
'Z'   => 'Zambie',
'ZA'  => 'Afrique du Sud',
'ZM'  => 'Zimbabwe',
'ZR'  => 'Zaïre',
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

