<?php
/*
Licence et conditions d'utilisations-----------------------------------------------------------------------------

-English---------------------------------------------------------------------------------------------------------
Copyright (C) 2001  - AUTHOR
			    - ANDRE thierry
		    - ADDING
			    - VILDAY Laurent.
			    - MOULRON Diog�ne.
			    - DELVILLE Romain.
			    - BOUCHERY Frederic.
			    - PERRICHOT Florian.
			    - RODIER Phillipe.
			    - HOUZE S�bastien.

This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General
Public License as published by the Free Software Foundation; either version 2.1 of the License, or (at your option)
any later version.

This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License for more
details.

You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to :

Free Software Foundation,
Inc., 59 Temple Place,
Suite 330, Boston,
MA 02111-1307, +tats-Unis.
------------------------------------------------------------------------------------------------------------------

-Fran�ais---------------------------------------------------------------------------------------------------------
ModeliXe est distribu� sous licence LGPL, merci de laisser cette en-t�te, gage et garantie de cette licence.
ModeliXe est un moteur de template destin� � �tre utilis� par des applications �crites en PHP.
ModeliXe peut �tre utilis� dans des scripts vendus � des tiers aux titres de la licence LGPL. ModeliXe n'en reste
pas moins OpenSource et libre de droits en date du 23 Ao�t 2001.

Copyright (C) 2001  - Auteur
			    - ANDRE thierry
		    - Ajouts
			    - VILDAY Laurent.
			    - MOULRON Diog�ne.
			    - DELVILLE Romain.
			    - BOUCHERY Frederic.
			    - PERRICHOT Florian.
			    - RODIER Phillipe.
			    - HOUZE S�bastien.

Cette biblioth�que est libre, vous pouvez la redistribuer et/ou la modifier selon les termes de la Licence Publique
G�n�rale GNU Limit�e publi�e par la Free Software Foundation version 2.1 et ult�rieure.

Cette biblioth�que est distribu�e car potentiellement utile, mais SANS AUCUNE GARANTIE, ni explicite ni implicite,
y compris les garanties de commercialisation ou d'adaptation dans un but sp�cifique. Reportez-vous � la Licence
Publique G�n�rale GNU Limit�e pour plus de d�tails.

Vous devez avoir re�u une copie de la Licence Publique G�n�rale GNU Limit�e en m�me temps que cette biblioth�que;
si ce n'est pas le cas, �crivez �:

Free Software Foundation,
Inc., 59 Temple Place,
Suite 330, Boston,
MA 02111-1307, Etats-Unis.

Pour tout renseignements mailez � modelixe@free.fr ou thierry.andre@freesbee.fr
--------------------------------------------------------------------------------------------------------------------
*/
error_reporting(E_ALL);

if (@is_file('Mxconf.php')) include ('Mxconf.php');
include('ErrorManager.php');

class ModeliXe extends ErrorManager {

    var $template = '';
    var $page = '';
    var $type = '';
    var $absolutePath = '';
    var $relativePath = '';
    var $sessionParameter = '';
    var $mXParameterFile = '';
    var $mXTemplatePath = '';
    var $mXCachePath = '';
    var $mXUrlKey = '';

    var $flagSystem = 'xml';
    var $adressSystem = 'relative';
    var $mXVersion = 'beta 6.6';

    var $mXCacheDelay = 0;
    var $debut = 0;
    var $fin = 0;
    var $ExecutionTime = 0;

    var $mXcompress = false;
    var $mXsetting = false;
    var $mXmodRewrite = false;
    var $performanceTracer = false;

    var $mXsignature = true;

    var $templateContent = array();
    var $sheetBuilding = array();
    var $deleted = array();
    var $loop = array();
    var $IsALoop = array();
    var $xPattern = array();
    var $formField = array();
    var $checker = array();
    var $attribut = array();
    var $url = array();
    var $attributKey = array();
    var $htmlAtt = array();
    var $select = array();
    var $hidden = array();
    var $image = array();
    var $text = array();
    var $father = array();
    var $son = array();
    var $replacement = array();

    var $flagArray = array(0 => 'hidden', 1 => 'select', 2 => 'image', 3 => 'text', 4 => 'checker', 5 => 'formField');
    var $attributArray = array(0 => 'attribut');

    //MX Generator----------------------------------------------------------------------------------------------------

    //Constructeur de ModeliXe
    function ModeliXe ($template, $sessionParameter = '', $templateFileParameter = '', $cacheDelay = 0){

	$time = explode(' ',microtime());
	$this -> debut = $time[1] + $time[0];

	//Gestion des param�tres par d�faut
	//Definition du systeme de compression
	if (defined('MX_COMPRESS')) {
	    $this -> mXcompress = MX_COMPRESS;
	    if ($this -> mXcompress != 'enabled') $this -> mXcompress = false;
	    else $this -> mXcompress = true;
	    }
	if (defined('MX_REWRITEURL')) {
	    $this -> mXmodRewrite = MX_REWRITEURL;
	    if ($this -> mXmodRewrite != 'on') $this -> mXmodRewrite = false;
	    else $this -> mXmodRewrite = true;
	    }
	if (defined('MX_SIGNATURE') && MX_SIGNATURE == 'off') $this -> mXsignature = false;
	if (defined('MX_TEMPLATE_PATH')) {
	    $this -> mXTemplatePath = MX_TEMPLATE_PATH;
	    if ($this -> mXTemplatePath[strlen($this -> mXTemplatePath) - 1] != '/' && $this -> mXTemplatePath) $this -> mXTemplatePath .= '/';
	    if (! is_dir($this -> mXTemplatePath)) $this -> ErrorTracker(5, 'The MX_TEMPLATE_PATH (<b>'.$this -> mXTemplatePath.'</b>) is not a directory.', 'ModeliXe');
	    }
	if (defined('MX_DEFAULT_PARAMETER') && !$templateFileParameter) $templateFileParameter = MX_DEFAULT_PARAMETER;
	if (defined('MX_FLAGS_TYPE')) {
	    switch (strtolower(MX_FLAGS_TYPE)){
		case 'classical':
		    $this -> flagSystem = 'classical';
		    break;
		case 'pear':
		    $this -> flagSystem = 'classical';
		    break;
		case 'xml':
		    $this -> flagSystem = 'xml';
		    break;
		default:
		    $this -> ErrorTracker(1, 'This type of flag system ('.MX_FLAGS_TYPE.') is unrecognized.', 'ModeliXe');
		}
	    }

	if (defined('MX_CACHE_PATH')) {
	    if (($this -> mXCachePath = MX_CACHE_PATH) && $this -> mXCachePath[strlen($this -> mXCachePath) - 1] != '/' && $this -> mXCachePath) $this -> mXCachePath .= '/';
	    if (! is_dir($this -> mXCachePath) && $this -> mXCachePath != '') $this -> ErrorTracker(5, 'The MX_CACHE_PATH is not a directory.', 'ModeliXe');

	    if ($cacheDelay > 0) $this -> mXCacheDelay = (integer)$cacheDelay;
	    elseif (defined('MX_CACHE_DELAY') && (integer)MX_CACHE_DELAY > 0) $this -> mXCacheDelay = (integer)MX_CACHE_DELAY;
	    }
	if (defined('MX_PERFORMANCE_TRACER') && MX_PERFORMANCE_TRACER == 'on') $this -> performanceTracer = true;

	$this -> ErrorManager();

	//Gestion des param�tres de sessions
	if ($sessionParameter) $this -> sessionParameter = $sessionParameter;

	//Fichier de param�tre
	if ($templateFileParameter) {
	    if (@is_file($templateFileParameter)) $this -> mXParameterFile = $templateFileParameter;
	    else $this -> ErrorTracker(3, 'The path to the mXparameterFile (<b>'.$templateFileParameter.'</b>) is incorrect, he can\'t be read.', 'ModeliXe');
	    }

	//Instanciation de la ressource templates
	if (@is_file($this -> mXTemplatePath.$template)) $this -> template = $template;
	elseif (isset($template)) $this -> template = $template;
	else $this -> ErrorTracker (5, 'No template file defined.', 'ModeliXe');

	//Test du cache et insertion �ventuelle
	if ($this -> mXCacheDelay > 0){
	    $this -> mXUrlKey = $this -> GetMD5UrlKey();

	    if ($this -> MxCheckCache()) $this -> MxGetCache();
	    }

	//Affectation du path d'origine
	if ($this -> ErrorChecker()) {
	    $this -> absolutePath = substr(basename($this -> template), 0, strpos(basename($this -> template), '.'));
	    $this -> relativePath = $this -> absolutePath;
	    }
	}

    //M�thode d'instanciation du template
    function SetModelixe(){
	$this -> GetMxFile();
	if ($this -> ErrorChecker()) $this -> MxParsing($this -> templateContent[$this -> absolutePath]);

	$this -> mXsetting = true;
	}

    //Recherche du fichier de template
    function GetMxFile($source = '', $absolutePath = '', $dyn = ''){
	if ($dyn) $dyn = 'Dynamic';

	if (! $source) $source = $this -> mXTemplatePath.$this -> template;

	if (@is_file($source)) {

	    if (! $read = @fopen($source, 'rb')) $this -> ErrorTracker (3, 'Can\'t open this template file <b>'.$this -> template.'</b> in read.', 'GetMxFile');
	    else {

		if (! $result = @fread($read, filesize($source)))  $this -> ErrorTracker (3, 'Can\'t read the template file <b>'.$source.'</b>.', 'GetMxFile');
		fclose($read);
		}
	    }
	else $this -> ErrorTracker(3, 'Opening template <b>'.$source.'</b> failed.', 'GetMxFile');

	if (empty($result)) $result = '[no parsing, template file not found or invalid]';
	if ($this -> mXsignature && $source != $this -> mXTemplatePath.$this -> template) $result = "\n<!--[ModeliXe ".$this -> mXVersion.']-- [StartOf'.$dyn.'Inclusion : '.$source."] -->\n\n".$result."\n\n<!--[ModeliXe ".$this -> mXVersion.']-- [EndOf'.$dyn.'Inclusion : '.$source."] -->\n";

	//Affectation du path d'origine, et du content du template
	if ($source == $this -> mXTemplatePath.$this -> template) $this -> templateContent[$this -> absolutePath] = $result;
	else return $result;
	}

    //Lecture du fichier de configuration
    function GetParameterParsing($template){
	$debut = false;

	if (! $read = @fopen($this -> mXParameterFile, 'r')) $this -> ErrorTracker(4, 'The mXParameterFile (<b>'.$this -> mXParameterFile.'</b>) can\'t be open, the first parsing can\'t be do.', 'GetParameterParsing');
	while (! feof($read) && $this -> ErrorChecker()){
	    $ligne = @fgets($read, 1200);

	    if ($ligne[0] != '#' && $signal) {
		if (! $debut){
		    $keyC = trim(substr($ligne, 0, strpos($ligne, '=') - 1));

		    //Gestion du multiligne, d�but d'une valeur sur plusieurs lignes
		    if (($content = trim(substr($ligne, strpos($ligne, '=') + 1))) && substr($content, 0, 3) == '"""') {
			$debut = true;
			$content = substr($content, 3);
			}
		    }
		//Gestion du multiligne, fin d'une valeur sur plusieurs lignes
		else {
		    if (substr(trim($ligne), strlen(trim($ligne)) - 3) == '"""') {
			$debut = false;
			$content .= substr($ligne, 0, strpos($ligne, '"""'));
			}
		    else $content .= $ligne;
		    }

		//Si nous ne sommes pas dans une valeur sur plusieurs lignes (valeur compl�te)
		if (! $debut){
		    switch ($this -> flagSystem){
			    case 'xml':
				$flagRegexp = '<mx:preformating id="'.$keyC.'"/>';
				$attRegexp = 'mXpreformating="'.$keyC.'"';
				break;
			    case 'classical':
				$flagRegexp = '{preformating id="'.$keyC.'"}';
				$attRegexp = '{preformatingAtt id="'.$keyC.'"}';
				break;
			    }

		    if ($signal == 'flag') $template = str_replace($flagRegexp, $content, $template);
		    if ($signal == 'attribut') $template = str_replace($attRegexp, $content, $template);
		    }
		}

	    //Changement d'�tat pour les param�tres
	    if (chop($ligne) == '#flag') $signal = 'flag';
	    if (chop($ligne) == '#attribut') $signal = 'attribut';
	    }

	if ($read) @fclose($read);

	return $template;
	}

    //MX Builder-----------------------------------------------------------------------------------------
    function MxBloc($index, $mod, $value = ''){
	$mod = substr(strtolower($mod), 0, 4);

	if ($this -> adressSystem == 'relative') {
	    if ($index) $index = $this -> relativePath.'.'.$index;
	    else $index = $this -> relativePath;
	    }
	else $index = $this -> absolutePath.'.'.$index;

	$fat = $this -> father[$index];
	if (! $fat && $index != $this -> absolutePath) $this -> ErrorTracker(2, 'The current path (<b>'.$index.'</b>) does not exist, or was deleting, him or his father, before.', 'MxBloc');
	
	switch ($mod){
	    //Looping
	    case 'loop':
		$this -> MxLoopBuilder($index);
		break;
	    //Deleting
	    case 'dele':
		$this -> sheetBuilding[$index] = '   ';
		$this -> loop[$index] = '';
		$this -> deleted[$index] = true;
		break;
	    //Concatenating
	    case 'appe':
		if (@is_file($value)) $value = $this -> GetMxFile($value, $index, 'dyn');
		$this -> templateContent[$index] .= $value;
		break;
	    //Replacing
	    case 'repl':
		if (@is_file($value)) $value = $this -> GetMxFile($value, $index, 'dyn');
		$this -> sheetBuilding[$index] = $value;
		$this -> replacement[$index] = true;
		break;
	    //Modify template references of this bloc
	    case 'modi':
		$this -> sheetBuilding[$index] = '';
		$this -> loop[$index] = '';
		if (@is_file($value)) $value = $this -> GetMxFile($value, $index, 'dyn');
		$this -> templateContent[$index] = $value;
		$this -> MxParsing($value, $index, $this -> father[$index]);
		break;
	    //Reset, destroy all references
	    case 'rese':
		$this -> sheetBuilding[$index] = '';
		$this -> loop[$index] = '';
		$this -> templateContent[$index] = '';
		$ind = substr($index, strrpos($index, '.') + 1);
		$this -> templateContent[$fat] = str_replace('<mx:inclusion id="'.$ind.'"/>', '', $this -> templateContent[$fat]);
		$this -> deleted[$index] = true;
		$this -> xPattern['inclusion'][$index] = '';
		break;
	    }
	}

    function MxFormField($index, $type, $name, $value, $attribut = ''){
	if ($this -> adressSystem == 'relative') $index = $this -> relativePath.'.'.$index;

	switch (strtolower($type)){
	    case "text":
		$replace = '<input type="text" name="'.$name.'" value="'.$value.'" '.$attribut.' '.$this -> htmlAtt[$index].' />';
		break;
	    case "password":
		$replace = '<input type="password" name="'.$name.'" value="'.$value.'" '.$attribut.' '.$this -> htmlAtt[$index].' />';
		break;
	    case "textarea":
		$replace = '<textarea name="'.$name.'" '.$attribut.' '.$this -> htmlAtt[$index].' >'.$value.'</textarea>';
		break;
	    case "file":
		$replace = '<input type="file" name="'.$name.'" value="'.$value.'" '.$attribut.' '.$this -> htmlAtt[$index].' />';
		break;
	    case "image":
		$replace = '<input type="image" name="'.$name.'" '.$attribut.' '.$this -> htmlAtt[$index].' />';
		break;
	    default:
		$this -> ErrorTracker(3, 'This type is unknown for this formField manager.', 'MxFormField');
	    }

	$this -> formField[$index] = $replace;
	}

    function MxImage($index, $imag, $title = '', $attribut = '', $size = false){
	if ($this -> adressSystem == 'relative') $index = $this -> relativePath.'.'.$index;

	if (($ima = '<img src="'.$imag.'"') && @is_file($imag) && ! $size) {
	    $size = getimagesize($imag);
	    $ima .= ' '.$size[3];
	    }

	if ($title == 'no') $ima .= ' ';
	elseif ($title) $ima .= ' alt="'.$title.'" ';
	else $ima .= ' alt="no title - source : '.basename($imag).'" ';

	if ($attribut) $ima .= $attribut;
	$ima .= ' '.$this -> htmlAtt[$index].' />';

	$this -> image[$index] = $ima;
	}

    function MxText($index, $att){
	if ($this -> adressSystem == 'relative') $index = $this -> relativePath.'.'.$index;

	$this -> text[$index] = $att;
	}

    function MxAttribut($index, $att){
	if ($this -> adressSystem == 'relative') $index = $this -> relativePath.'.'.$index;

	//Gestion multi-attributs
	if (! chop($this -> attribut[$index])) $this -> attribut[$index] = $this -> attributKey[$index].'="'.$att.'"';
	else $this -> attribut[$this -> attribut[$index]] .= ' '.$this -> attributKey[$index].'="'.$att.'"';
	}

    function MxSelect($index, $name, $value, $arrayArg, $defaut = '', $multiple = '', $javascript = '') {
	if ($this -> adressSystem == 'relative') $index = $this -> relativePath.'.'.$index;
	$sel = '';

	if ($multiple && $multiple > 0) {
	    $attribut = 'size="'.$multiple.'" multiple="multiple" ';
	    $post = '[]';
	    }
	else {
	    $attribut = '';
	    $post = '';
	    }

	//Build of a select tag from an array
	if (is_array($arrayArg)){
	    $sel = "\n".'<select name="'.$name.$post.'"';
	    if ($attribut) $sel .= $attribut.' ';
	    if ($javascript) $sel .= $javascript;
	    $sel .= ' '.$this -> htmlAtt[$index].' '.">\n";

	    if (isset($defaut) && $defaut) $sel .= "\t".'<option value="#">'.$defaut.'</option>'."\n";

	    $debut = 0;
	    $fin = count($arrayArg);

	    reset($arrayArg);
	    while (list($cle, $Avalue) = each($arrayArg)){
		$test = 0;

		//Build of multiple choice select from a value array
		if (is_array($value) && $multiple > 0){
		    while (list($Vcle, $Vvalue) = each($value)){
			if ($cle == $Vcle && $Vcle) {
			    $sel .= "\t".'<option value="'.$cle.'" selected="selected">'.$Avalue.'</option>'."\n";
			    $test = 1;
			    break;
			    }
			else $sel .= "\t".'<option value="'.$cle.'">'.$Avalue.'</option>'."\n";
			}
		    }

		//Simple select
		else {
		    if ($value && $cle == $value) $sel .= "\t".'<option value="'.$cle.'" selected="selected">'.$Avalue.'</option>'."\n";
		    else $sel .= "\t".'<option value="'.$cle.'">'.$Avalue.'</option>'."\n";
		    }
		}
	    }
	else {
	    $this -> ErrorTracker(2, 'This function need an Array in fourth argument to build the select <b>'.$index.'</b>', 'MxSelect');
	    $sel = '<select name="'.$name.'">'."\n\t".'<option value="null">No record found</option>'."\n";
	    }

	$sel .= '</select>';

	$this -> select[$index] = $sel;
	}

    function MxUrl($index, $urlArg, $param = '', $noSid = false) {
	if ($this -> adressSystem == 'relative') $index = $this -> relativePath.'.'.$index;


	$ok = false;

	if ($this -> sessionParameter && ! $noSid) {
	    if ($this -> mXCacheDelay > 0) $urlArg .= '?<mx:session />';
	    else $urlArg .= '?'.$this -> sessionParameter;

	    $ok = true;
	    }

	if (! $noSid && is_string($param) && $param) {
	    $param = explode('&',$param);
	    for($i = 0; $i < count($param) && $param[$i]; $i++){
		$cle = explode('=', $param[$i]);
		if (! $this -> mXmodRewrite){
		    if($i == 0 && !$ok) $urlArg .= '?'.urlencode($cle[0]).'='.urlencode($cle[1]);
		    else $urlArg .= '&'.urlencode($cle[0]).'='.urlencode($cle[1]);
		    }
		else {
		    if($i == 0 && !$ok) $urlArg .= '/'.urlencode($cle[0]).'/'.urlencode($cle[1]);
		    else $urlArg .= '/'.urlencode($cle[0]).'/'.urlencode($cle[1]);
		    }
		}
	    }
	elseif (is_array($param)){
	    rewind($param);
	    while (list($cle, $valeur) = each($param)){
		if (! $this -> mXmodRewrite){
		    if (!$ok) {
			$urlArg .= '?'.urlencode($cle).'='.urlencode($valeur);
			$ok = true;
			}
		    else $urlArg .= '&'.urlencode($cle).'='.urlencode($valeur);
		    }
		else {
		    if (!$ok) {
			$urlArg .= '/'.urlencode($cle).'/'.urlencode($valeur);
			$ok = true;
			}
		    else $urlArg .= '/'.urlencode($cle).'/'.urlencode($valeur);
		    }
		}
	    }
	elseif ($param) $this -> ErrorTracker(3, 'The third argument must be a queryString or an array.', 'MxUrl');

	//Gestion multi-attributs
	if (! chop($this -> attribut[$index])) $this -> attribut[$index] = ' href="'.$urlArg.'"';
	else $this -> attribut[$this -> attribut[$index]] .= ' href="'.$urlArg.'"';
	}

    function MxHidden ($index, $param){
	if ($this -> adressSystem == 'relative') $index = $this -> relativePath.'.'.$index;
	$hidden = '';

	if ($this -> mXCacheDelay == 0 && $this -> sessionParameter) $param .= '&'.$this -> sessionParameter;

	if (is_string($param)) $param = explode('&',$param);
	else $this -> ErrorTracker(3,'The second argument must be a queryString.',  'MxHidden');

	if (! empty($param)){
	    for($i = 0; $i < count($param); $i++){
		if ($param[$i]) {
		    $cle = explode('=', $param[$i]);
		    $hidden .= '<input type="hidden" name="'.$cle[0].'" value="'.$cle[1].'" />'."\n";
		    }
		}
	    }

	if ($this -> mXCacheDelay > 0) $hidden .= '<mx:hiddenSession />';

	$this -> hidden[$index] = $hidden;
	}

    function MxCheckerField($index, $type, $name, $value, $checked = false, $attribut = ''){
	if ($this -> adressSystem == 'relative') $index = $this -> relativePath.'.'.$index;

	$type = strtolower($type);
	if ($type != "checkbox" && $type != "radio") $this -> ErrorTracker(2, 'This type is unknown for this CheckerField manager.', 'MxCheckerField');

	$replace = '<input type="'.$type.'" name="'.$name.'" value="'.$value.'"';
	if ( $checked ) $replace .= ' checked="checked"';
	if ($attribut) $replace .= ' '.$attribut;
	$replace .= ' '.$this -> htmlAtt[$index].' />';

	$this -> checker[$index] = $replace;
	}

    //MX tools -------------------------------------------------------------------------------------------------------------------

    //Retourne tout le contenu d'un bloc
    function GetMxBloc($index, $choice = ''){
	if ($this -> adressSystem == 'relative') $index = $this -> relativePath.'.'.$index;

	if ($this -> sheetBuilding[$index] && ! $choice) return $this -> sheetBuilding[$index];
	else  return $this -> templateContent[$index];
	}

    //Construction d'une queryString
    function GetQueryString($keyString){
	if (is_array($keyString)){
	    reset($keyString);

	    while (list($Akey, $value) = each($keyString)){
		if (empty($queryString)) $queryString = urlencode($Akey).'='.urlencode($value);
		else $queryString .= '&'.urlencode($Akey).'='.urlencode($value);
		}

	    return $queryString;
	    }
	else $this -> ErrorTracker(3, 'The argument for this function must be an associative array.', 'GetQueryString');
	}

    //Adressage simplifi�
    function WithMxPath($path = '', $origine = ''){

	if (! $origine) $origine = $this -> adressSystem;
	else {
	    switch($origine){
		case 'relative':
		    break;
		case 'absolute':
		    break;
		default:
		    $origine = 'relative';
		    break;
		}
	    }

	//Si on ne pr�cise pas de path on retourne au path origine
	if (empty($path)){
	    $this -> relativePath = $this -> absolutePath;

	    if ($origine == 'absolute') $this -> adressSystem = 'absolute';
	    elseif ($origine == 'relative') $this -> adressSystem = 'relative';
	    }

	//Sinon, en absolu on se situe dans ce path, en relatif on se situe par rapport au path relatif
	if ($path) {
	    if ($origine == 'relative') {

		//On redescend dans la hi�rarchie jusqu'au path mentionn�
		if (($test = explode('../', $path)) && count($test) > 1) {
		    $path = substr($path, strrpos($path, '/') + 1);
		    $this -> relativePath = substr($this -> relativePath, 0, strlen($this -> relativePath) - strlen(strstr($this -> relativePath, $path)) - 1);
		    if (! $this -> relativePath) $this -> ErrorTracker(3, 'This path (<b>'.$path.'</b>) does not exist, ModeliXe can\'t build relativePath.', 'WithMxPath');
		    }

		$this -> relativePath .= '.'.$path;

		$this -> adressSystem = 'relative';
		}
	    elseif ($origine == 'absolute') {
		$this -> relativePath = $path;
		$this -> adressSystem = 'absolute';
		}
	    }
	}

    //Informations de licence
    function AboutModeliXe($out = ''){
	$texte = "\nLicence et conditions d'utilisations-----------------------------------------------------------------------------\n";
	$texte .= 'ModeliXe '.$this -> mXVersion."\nModeliXe est distribu� sous licence LGPL, merci de laisser cette en-t�te, gage et garantie de cette licence.\n";
	$texte .= "ModeliXe est un moteur de template destin� � �tre utilis� par des applications �crites en PHP.\n";
	$texte .= " \n";
	$texte .= "Copyright(c) 26 Juin 2001 - ANDRE Thierry (aka Th�o)\n";
	$texte .= " \n";
	$texte .= "Pour tout renseignements mailez � modelixe@free.fr ou thierry.andre@freesbee.fr\n";
	$texte .= "------------------------------------------------------------------------------------------------------------------\n";

	if ($out) return $texte;
	else print('<pre>'.$texte.'</pre>');
	}

    //Num�ro de version
    function GetMxVersion(){
	return $this -> mXVersion;
	}

    //Rafraichissement
    function MxRefresh(){
	$this -> MxClearCache('this');
	}

    //Mesure de performances
    function GetExecutionTime(){
	    $time = explode(' ',microtime());
	    $fin = $time[1] + $time[0];
	    $this -> ExecutionTime = intval(10000 * ((double)$fin - (double)$this -> debut)) / 10000;

	    return($this -> ExecutionTime);
	    }

    //MX Parsing Engine------------------------------------------------------------------------------------------------------------

    function MxParsing($doc = '', $path = '', $father = ''){
	$countPath = Array();

	//Initialisation
	if (! $path) {
	    $original = true;
	    $path = $this -> absolutePath;
	    }
	else $original = false;

	$this -> father[$path] = $father;
	$this -> IsALoop[$path] = false;

	//Parsing des balises de bloc, extraction des sous blocs
	$ok = true;

	switch ($this -> flagSystem){
		case 'xml':
		    $blocRegexp = '/<mx:bloc(?:[ ]+ref="([^"]+)")?[ ]+id="([^"]+)"[ ]*>/S';
		    break;
		case 'classical':
		    $blocRegexp = '/{start(?:[ ]+ref="([^"]+)")?[ ]+id="([^"]+)"[ ]*}/S';
		    break;
		}

	if (preg_match_all($blocRegexp, $doc, $inclusion)){

	    for($i = 0; $ok; $i++){

		//Extraction des diff�rentes informations extraites par la regex
		$id = $inclusion[2][0];
		$ref = $inclusion[1][0];
		$pattern = $inclusion[0][0];

		//Calcul des limites du bloc trait�
		switch ($this -> flagSystem){
		    case 'xml':
			$regexp = '</mx:bloc id="'.$id.'">';
			$patternReg = '&lt;/mx:bloc id="'.$id.'"&gt;';
			break;
		    case 'classical':
			$regexp = '{end id="'.$id.'"}';
			$patternReg = '{end id="'.$id.'"}';
			break;
		    }

		$startOfIntrons = strpos($doc, $pattern) + strlen($pattern);
		$endOfIntrons = strpos($doc, $regexp);
		$length = $endOfIntrons - $startOfIntrons;

		if (! $endOfIntrons) $this -> ErrorTracker(4, 'The end of the "<b>'.$id.'</b>" bloc is not found, this bloc can\'t be generate. Verify that the end of bloc\'s flag exists and has a good form, like this pattern <b>'.$patternReg.'</b>.', 'MxParsing');

		//On teste si le bloc en cours poss�de une r�f�rence vers un autre template
		if (! $ref) $this -> templateContent[$path.'.'.$id] = substr($doc, $startOfIntrons, $length);
		else {
		    if ($this -> mXTemplatePath) $ref = $this -> mXTemplatePath.$ref;
		    $this -> templateContent[$path.'.'.$id] = $this -> GetMxFile($ref, $path.'.'.$id);
		    }

		//Cr�ation du pattern du bloc trait�
		$this -> xPattern['inclusion'][$path.'.'.$id] = '<mx:inclusion id="'.$id.'"/>';
		$this -> deleted[$path.'.'.$id] = false;
		$this -> replacement[$path.'.'.$id] = false;

		//Extraction du contenu du bloc pour reconstruire le bloc en cours
		$doc = substr($doc, 0, $startOfIntrons - strlen($pattern)).'<mx:inclusion id="'.$id.'"/>'.substr($doc, $endOfIntrons + strlen('</mx:bloc id="'.$id.'">'));
		$this -> templateContent[$path] = $doc;

		//Construction de la r�f�rence � ce bloc pour la r�cursivit�
		$countPath[$i] = $path.'.'.$id;

		//Incr�mentation du nbre de fils pour le bloc en cours
		if (! empty($this -> son[$path][0])) $compt = $this -> son[$path][0];
		else {
		    $compt = 0;
		    $this -> son[$path][0] = 0;
		    }

		//Construction de la r�f�rence au fils du bloc pars� pour le bloc en cours
		$this -> son[$path][++ $compt] = $path.'.'.$id;
		$this -> son[$path][0] ++;

		//Test de fin de boucle
		$ok = preg_match_all($blocRegexp, $doc, $inclusion);;
		}
	    }

	//Parsing des balises ModeliXe
	reset($this -> flagArray);
	while (list($Akey, $value) = each($this -> flagArray)){

	    switch ($this -> flagSystem){
		case 'xml':
		    $regexp = '/<mx:'.$value.'(?:[ ]+ref="(?:[^"]+)")?[ ]+id="([^"]+)"(([^>])*(?=\/>))\/>/S';
		    break;
		case 'classical':
		    $regexp = '/{'.$value.'(?:[ ]+ref="(?:[^"]+)")?[ ]+id="([^"]+)"(([^}])*(?=}))}/S';
		    break;
		}

	    if (preg_match_all($regexp, $doc, $flag)){
		 for ($i = 0; ; $i++){
		    if (empty ($flag[0][$i])) break;

		    //Construction du pattern et des valeurs par d�faut de ces balises
		    $this -> xPattern[$value][$path.'.'.$flag[1][$i]] = $flag[0][$i];
		    $ref = &$this -> $value;
		    $ref[$path.'.'.$flag[1][$i]] = '   ';
		    $this -> htmlAtt[$path.'.'.$flag[1][$i]] = $flag[2][$i];
		    }
		}
	    }

	//Parsing des attributs de ModeliXe
	switch ($this -> flagSystem){
		case 'xml':
		    $regexp = '/mXattribut="([^"]{3,})"/S';
		    break;
		case 'classical':
		    $regexp = '/{attribut[ ]+((?:[a-zA-Z-]+)[ ]+="(?:[^"]+)"(?:[ ]+))}/S';
		    break;
		}

	if (preg_match_all($regexp, $doc, $flag)){
	    for ($i = 0, $k = 0; ; $i++){

		if (empty($flag[0][$i])) break;

		$pattern = $flag[0][$i];
		$motif = $flag[1][$i];
		$k = 0;

		//Gestion de plusieurs couples de cl�-valeurs dans les attributs
		$tabVal = explode(';', $motif);
		for ($j = 0; $j < count($tabVal); $j++) {

		    $tabCle = explode(':', trim($tabVal[$j]));
		    $patternKey[++ $k] = trim($tabCle[0]);
		    $indexValue[$k] = trim($tabCle[1]);

		    //Gestion multi-attributs
		    if (count($tabVal) > 1) {
			$this -> attribut[$path.'.'.$indexValue[$k]] = $path.'.'.$indexValue[1].';';
			if ($k == 1) $this -> xPattern['attribut'][$path.'.'.$indexValue[1].';'] = $pattern;
			}
		    else {
			$this -> attribut[$path.'.'.$indexValue[$k]] = '  ';
			$this -> xPattern['attribut'][$path.'.'.$indexValue[$k]] = $pattern;
			}

		    if ($patternKey[$k] != 'url') $this -> attributKey[$path.'.'.$indexValue[$k]] = $patternKey[$k];
		    }
		}
	    }


	for ($i = 0; $i < count($countPath); $i++) $this -> MxParsing($this -> templateContent[$countPath[$i]], $countPath[$i], $path);
	}

    //MX Compression System ------------------------------------------------------------------------------------------------------------------

    //V�rifie si la compression est possible et son type
    function MxCheckCompress($file){
	if((! $this -> mXcompress) || (! extension_loaded("zlib")) || (headers_sent()) || (strlen($file) / 1000 < 8)) return false;
	global $HTTP_SERVER_VARS;

	if (strstr($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING'], 'x-gzip'))  return "x-gzip";
	if (strstr($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING'], 'gzip'))	return "gzip";

	return false;
	}

    //Compression des donnees destin�es au navigateur
    function MxSetCompress($filecontent){
	if (($encoding = $this -> MxCheckCompress($filecontent))){

	    header('Content-Encoding: '.$encoding);
	    $gzfilecontent =  "\x1f\x8b\x08\x00\x00\x00\x00\x00";
	    $size = strlen($filecontent);
	    $crc32 = crc32($filecontent);
	    $gzfilecontent .= gzcompress($filecontent, 9);
	    $gzfilecontent = substr($gzfilecontent, 0, strlen($gzfilecontent) - 4);
	    $gzfilecontent .= pack('V',$crc32);
	    $gzfilecontent .= pack('V',$size);

	    return $gzfilecontent;
	    }
	else return $filecontent;
	}


    //MX Cache system ------------------------------------------------------------------------------------------------------------------

    //Retourne une cl� unique pour les arguments en POST et GET diff�rents des param�tres de session
    function GetMD5UrlKey(){
	global $HTTP_POST_VARS, $HTTP_GET_VARS;

	$param = explode('&', $this -> sessionParameter);
	$chaine = 'GET=';

	//pr est un marqueur pour �viter de parcourir toutes les valeurs des param de session si ceux-ci ont d�ja �t� tous supprim�s
	$pr = 0;

	//Suppression des param�tres de session en GET
	while (list($cle, $val) = each($HTTP_GET_VARS)){
	    $ok = false;
	    $compt = count($param);
	    for ($i = 0; $i < $compt && ($pr != $compt); $i++){

		if (($cleU = explode('=', $param[$i])) && $cleU[0] == $cle) {
		    $ok = true;
		    $pr ++;
		    break;
		    }
		}

	    if (! $ok) $chaine .= $cle.'='.$val;
	    }

	//Suppression des param�tres de session en POST
	$chaine .= ' POST=';
	$pr = 0;

	while (list($cle, $val) = each($HTTP_POST_VARS)){
	    $ok = false;
	    $compt = count($param);
	    for ($i = 0; $i < $compt && ($pr != $compt); $i++){

		if (($cleU = explode('=', $param[$i])) && $cleU[0] == $cle) {
		    $ok = true;
		    $pr ++;
		    break;
		    }
		}

	    if (! $ok) $chaine .= $cle.'='.$val;
	    }

	return (md5($chaine));
	}

    //Vidage du cache
    function MxClearCache($fich = ''){

	if (! $open = @opendir($this -> mXCachePath)) $this -> ErrorTracker(3, 'Can\'t open cache directory (<b>'.$this -> mXCachePath.'</b>) to clear old files.', 'MxClearCache');
	else {
	    while ($fichier = @readdir($open)){

		if ($fichier != '.' && $fichier != '..' && is_file($this -> mXCachePath.$fichier)){
		    if (! $fich){
			if (($currentTime = filemtime($this -> mXCachePath.$fichier)) && time() - $currentTime > $this -> mXCacheDelay) {
			    if (! @unlink($this -> mXCachePath.$fichier)) $this -> ErrorTracker(3, 'Can\'t unlink this file "<b>'.$fichier.'</b>" in cache directory.', 'MxClearCache');
			    }
			}
		    else {
			//Supprime sp�cifiquement le fichier du template en cours
			$ana = explode('~', $fichier);
			if ($ana[1] == $this -> template) {
			    if (! @unlink($this -> mXCachePath.$fichier)) $this -> ErrorTracker(3, 'Can\'t unlink this file "<b>'.$fichier.'</b>" in cache directory.', 'MxClearCache');
			    }
			}
		    }
		}

	    @closedir($open);
	    }
	}

    //Initialisation du cache
    function MxSetCache($filecontent) {

	$this -> MxClearCache();

	if (! $cache = @fopen($this -> mXCachePath.$this -> mXUrlKey.'~'.$this -> template, 'w')) $this -> ErrorTracker(4, 'Can\'t open in writing the cache file on "<b>'.$this -> mXCachePath.'/'.$this -> template.'</b>" path.', 'MxSetCache');

	//Sauvegarde du contenu
	if ($this -> ErrorChecker()) {
	    if (! $write = @fputs($cache, $filecontent)) $this -> ErrorTracker(5, 'Can\'t wite the cache file on "<b>'.$this -> mXCachePath.'/'.$this -> template.'</b>" path.', 'MxSetCache');
	    @fclose($cache);
	    }
	}

    //Retourne le fichier de cache
    function MxGetCache() {
	$cache_file = $this -> mXCachePath.$this -> mXUrlKey.'~'.$this -> template;

	if (! $open = @fopen($cache_file, 'rb')) $this -> ErrorTracker(5, 'Can\'t open the cache file on "<b>'.$cache_file.'</b>" path.', 'MxGetCache');

	if (! $read = @fread($open, filesize($cache_file))) $this -> ErrorTracker(5, 'Can\'t read the cache file on "<b>'.$cache_file.'</b>" path.', 'MxGetCache');

	@fclose($open);

	//Parsing des param�tres de sessions
	$read = $this -> MxSessionParameterParsing($read);

	//Si on cherche � mesurer les performances de ModeliXe
	if ($this -> performanceTracer) {
	    $read = str_replace('<mx:performanceTracer />', $this -> GetExecutionTime().' [cache]', $read);
	    }

	//Si il y a une gestion de la compression, envoie des en-t�tes correspondantes
	$this -> ErrorChecker();
	print($this -> MxSetCompress($read));

	die();
	}

    //Teste si le fichier de cache existe et son �ch�ance
    function MxCheckCache() {
	$cache_file = $this -> mXCachePath.$this -> mXUrlKey.'~'.$this -> template;
	if (is_file($cache_file)){
	    if (($currentTime = filemtime($cache_file)) && (((time() - $currentTime) < $this -> mXCacheDelay && filemtime($this -> mXTemplatePath.$this -> template) < $currentTime))) return true;
	    }
	else return false;
	}

    //MX Template Fusion Engine --------------------------------------------------------------------------------------------------
    function MxSessionParameterParsing($content) {
	$hidden = '';

	if (($param = $this -> sessionParameter) && $param){
	    $content = str_replace('<mx:session />', $param, $content);

	    $param = explode('&', $this -> sessionParameter);
	    for($i = 0; $i < count($param); $i++){
		if ($param[$i]) {
		    $cle = explode('=', $param[$i]);
		    $hidden .= '<input type="hidden" name="'.$cle[0].'" value="'.$cle[1].'" />'."\n";
		    }
		}

	    $content = str_replace('<mx:hiddenSession />', $hidden, $content);
	    }

	return $content;
	}

    function MxReplace($path){

	if (! empty($this -> sheetBuilding[$path])) $cible = $this -> sheetBuilding[$path];
	else $cible = $this -> templateContent[$path];

	//Remplacement de l'ensemble des attributs ModeliXe par les valeurs qui ont �t� instanci�es ou leurs valeurs par d�faut
	reset($this -> attributArray);
	while (list($cle, $Fkey) = each($this -> attributArray)){
	    $Farray = &$this -> $Fkey;

	    if (is_array($Farray)){

		reset($Farray);
		while (list($Pkey, $value) = each($Farray)){

		    if ($path == substr($Pkey, 0, strrpos($Pkey, '.'))) {
			if (isset($this -> xPattern[$Fkey][$Pkey])){
			    $pattern = $this -> xPattern[$Fkey][$Pkey];
			    $cible = str_replace($pattern, $value, $cible);
			    unset($Farray[$Pkey]);
			    }
			}
		    }
		}
	    }

	//Remplacement de l'ensemble des balises ModeliXe par les valeurs qui ont �t� instanci�es ou leurs valeurs par d�faut
	reset($this -> flagArray);
	while (list($cle, $Fkey) = each($this -> flagArray)){
	    $Farray = &$this -> $Fkey;

	    if (is_array($Farray)){
		reset($Farray);

		while (list($Pkey, $value) = each($Farray)){
		    if ($path == substr($Pkey, 0, strrpos($Pkey, '.'))) {
			if (isset($this -> xPattern[$Fkey][$Pkey])){
			    $pattern = $this -> xPattern[$Fkey][$Pkey];
			    $cible = str_replace($pattern, $value, $cible);
			    unset($Farray[$Pkey]);
			    }
			}
		    }
		}
	    }

	 return $cible;
	 }


    function MxBlocBuilder($path = '', $fromLoop = ''){
	$ordre = array();
	$hierarchie = 1;

	if (! $path) $path = $this -> absolutePath;
	$chemin = $path;

	//Classement de tout les fils de path du plus proche au plus lointain
	$base = count(explode('.', $path));
	$k = 1;
	$l = 1;
	$j = 1;

	for (; ;){

	    //Si il existe un fils on le prend
	    if (! empty($this -> son[$chemin][$j])) $fils = $this -> son[$chemin][$j];
	    else $fils = '';

	    //Si il existe on consid�re le dernier enregistrement trouv� pr�c�dant celui-ci
	    if (! empty($ordre[$hierarchie])) $ancien = $ordre[$hierarchie][count($ordre[$hierarchie])];
	    else $ancien = false;

	    if ($fils == $ancien) break;

	    //Si il n'y a plus de fils, on passe au noeud suivant
	    if (empty($fils)) {
		$j = 1;

		if (! empty($ordre[$k][$l])) {
		    $chemin = $ordre[$k][$l];
		    $l ++;
		    }
		else {
		    $l = 1;
		    $k ++;

		    if (! empty($ordre[$k][$l])) $chemin = $ordre[$k][$l];
		    else break;
		    }
		}
	    else {
		$j ++;

		//Si le fils n'a pas �t� d�truit on le consid�re
		if ($this -> templateContent[$fils]) {

		    //hi�rarchie compte le nombre de blocs � partir du bloc de base
		    $hierarchie = count(explode('.', $fils)) - $base;

		    if (empty($ordre[$hierarchie])) $ordre[$hierarchie] = array();
		    $ordre[$hierarchie][count($ordre[$hierarchie]) + 1] = $fils;
		    }
		}
	    }

	//Insertion des fils les plus lointains dans les fils les plus proches jusq'au path
	for ($i = count($ordre); $i > 0; $i --){

	    for ($j = 1; $j <= count($ordre[$i]); $j++){

		$fils = $ordre[$i][$j];
		$pattern = $this -> xPattern['inclusion'][$fils];
		$pere = $this -> father[$ordre[$i][$j]];

		//Insertion du bloc fils dans le p�re
		if ($pere == $path && $this -> IsALoop[$path]) {

		    if ($this -> IsALoop[$fils]) {

			if ($this -> deleted[$fils]) {
			    $rem = ' ';
			    $this -> deleted[$fils] = false;
			    }
			else $rem = $this -> loop[$fils];

			$this -> loop[$pere] = str_replace($pattern, $rem, $this -> loop[$pere]);
			$this -> loop[$fils] = '';
			}
		    else {

			if ($this -> deleted[$fils]) {
			    $rem = ' ';
			    $this -> deleted[$fils] = false;
			    }
			else $rem = $this -> MxReplace($fils);

			$this -> loop[$pere] = str_replace($pattern, $rem, $this -> loop[$pere]);
			$this -> sheetBuilding[$fils] = '';
			}
		    }
		else {

		    if (! empty($this -> sheetBuilding[$pere])) $source = $this -> sheetBuilding[$pere];
		    else $source = $this -> templateContent[$pere];

		    if ($this -> IsALoop[$fils]) {

			if ($this -> deleted[$fils]) {
			    $rem = ' ';
			    $this -> deleted[$fils] = false;
			    }
			else $rem = $this -> loop[$fils];

			$this -> sheetBuilding[$pere] = str_replace($pattern, $rem, $source);
			$this -> loop[$fils] = '';
			}
		    else {

			if ($this -> deleted[$fils]) {
			    $rem = ' ';
			    $this -> deleted[$fils] = false;
			    }
			else $rem = $this -> MxReplace($fils);

			$this -> sheetBuilding[$pere] = str_replace($pattern, $rem, $source);
			$this -> sheetBuilding[$fils] = '';
			}
		    }
		}
	    }
	}

     function MxLoopBuilder($path = ''){
	if (! $path) $path = $this -> absolutePath;

	$father = $this -> father[$path];
	$pattern = $this -> xPattern['inclusion'][$path];

	//On saute les blocs d�truits
	if ($pattern){
	    $this -> IsALoop[$path] = true;
	    if (empty($this -> loop[$path])) $this -> loop[$path] = '';

	    if ($this -> replacement[$path]) {
		$this -> loop[$path] .= $this -> sheetBuilding[$path];
		$this -> replacement[$path] = false;
		}
	    $this -> sheetBuilding[$path] = '';

	    if (empty($this -> loop[$path])) $this -> loop[$path] = '';
	    $this -> loop[$path] .= $this -> MxReplace($path);
	    }

	//Insertion des fils de $path dans $path
	$this -> MxBlocBuilder($path, 'loop');
	}

    //Mx Output -------------------------------------------------------------------------------------------------------------------

    function MxWrite ($out = ''){
	if (! $this -> mXsetting) $this -> ErrorTracker(5, 'You d\'ont intialize ModeliXe with setModeliXe method, there is no data to write.', 'MxWrite');

	//Assemblage de l'ensemble des blocs fils
	$this -> MxBlocBuilder();

	if ($this -> mXsignature && @is_file($this -> mXTemplatePath.$this -> template)) $entete = '<!--[ModeliXe '.$this -> mXVersion.'] -- [TemplateFile : '.$this -> mXTemplatePath.$this -> template.'] -- [date '.date('j/m/Y H:i:s')."]-->\n";
	else $entete = '';

	if ($this -> ErrorChecker()) {
	    $filecontent = (($entete)? str_replace('<html>', '<html>'."\n".$entete, $this -> MxReplace($this -> absolutePath)) : $this -> MxReplace($this -> absolutePath));

	    //Remplacement des balises de param�tres
	    if ($this -> mXParameterFile) $filecontent = $this -> GetParameterParsing($filecontent);


	    //Mise en cache de la page g�n�r�e sans les param�tres de sessions
	    if ($this -> mXCacheDelay > 0) {

		$this -> MxSetCache($filecontent);

		//Parsing des param�tres de sessions
		$filecontent = $this -> MxSessionParameterParsing($filecontent);
		}

	    //Si on cherche � mesurer les performances de ModeliXe
	    if ($this -> performanceTracer) {
		$filecontent = str_replace('<mx:performanceTracer />', $this -> GetExecutionTime(), $filecontent);
		}

	    if ($out) return $filecontent;
	    else print($this -> MxSetCompress($filecontent));
	    }
	}
    }

error_reporting(0);
?>
