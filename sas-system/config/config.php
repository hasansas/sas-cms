<?php

/** CNI - Configuration File
  *
  *   @version: 1.1
  *    @author: Hasan Sas <nepster_23@yahoo.com>
  * @copyright: 2013-2014 CNI Project
  *   @package: cni_system
  *   @license: http://opensource.org/licenses/GPL-3.0 GPLv3
  *   @license: http://opensource.org/licenses/LGPL-3.0 LGPLv3
  */

$base_url 				= str_replace('sas-system/config','',str_replace(str_replace('//','/',$_SERVER['DOCUMENT_ROOT'].'/'),'',str_replace('\\','/',dirname(__FILE__))));
$config['baseURL']		= $base_url;
$config['basePath']		= str_replace('//','/',$_SERVER['DOCUMENT_ROOT'].'/'.$base_url);
?>
