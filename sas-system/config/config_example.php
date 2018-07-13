<?php

/** sas - Configuration File
  *
  *   @version: 1.0
  *    @author: Hasan Sas <nepster_23@yahoo.com>
  * @copyright: 2013-2014 sas Project
  *   @package: sas_system
  *   @license: http://opensource.org/licenses/GPL-3.0 GPLv3
  *   @license: http://opensource.org/licenses/LGPL-3.0 LGPLv3
  */

$config['debug']	     = true;

/* Base URL */
$base_url 				 = 'xdev/app/';

/* Demo */
$config['demo']			 = false;

/* Database Driver */
$config['db_diver']		 = 'mysqli';

/* Database Setting */
$config['db_host']	 	 = 'localhost';
$config['db_user'] 		 = 'root';
$config['db_password'] 	 = '';
$config['db_name'] 		 = 'sas_basic';

/* prefix */
$config['tablePrefix']	 = 'sas_';
$config['adminName']	 = 'sas-admin';
$config['permalink']	 = '.html';

/* email */
$config['useMailer']	 = true;
$config['emailHost']	 = 'email_host';
$config['emailUser'] 	 = 'email_user';
$config['emailPassword'] = 'email_password';
$config['emailSecure']   = 'tls';
$config['emailPort']     = 587;

/* Base URL/Path */
$config['baseURL']		 = $base_url;
$config['basePath']		 = str_replace('//','/',$_SERVER['DOCUMENT_ROOT'].'/'.$base_url);

/* Session */
$config['sessionName']	 = 'sassession';

/* Copyright */
$config['copyright']	 = 'Designed & Developed by <a href="#" target="_blank">Sas</a>';

/* API */
$config['googleKey']	 = 'AIzaSyCn8EFLEdv8yxSd7H5TxrbKjcbN50cgqqA';
$config['youtubeKey']	 = 'AIzaSyCP4VPZCZv2corqe_qB0I3k3C0za81jzMk';
?>
