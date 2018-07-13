<?php if (!defined('basePath')) exit('No direct script access allowed');

/* Base URL */
$baseURL 		= str_replace('sas-system/install','',str_replace(str_replace('//','/',$_SERVER['DOCUMENT_ROOT'].'/'),'',str_replace('\\','/',dirname(__FILE__))));

/* Define URI */
$reqUri = explode('/',requestURI);
$getUri = '';

foreach($reqUri as $v){

	if(!empty($v)){
		$getUri .=  $v.'/';
	}
}
$getUri = substr($getUri,0,-1);
$getUri = str_replace(baseURL,'',$this->thisURI().$getUri);

/* htaccess file */
$htaccess = 'RewriteEngine on
RewriteCond $1 !^(index\.php|sas-system/install/|\/)
RewriteRule ^(.*)$ /'.$baseURL.'index.php?$1 [L]';

if(get_string_before($getUri,'?')=='system/ajax/'){

	include get_string_after($getUri,'?');
}
else{

	$hFile	= fopen(basePath.'.htaccess','w');
	fwrite($hFile,$htaccess);
	fclose($hFile);

	require_once('layout.php');
}
?>
