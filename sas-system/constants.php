<?php

/** sas - PHP Constant Variables
  *
  *   @version: 1.1
  *    @author: Hasan Sas <nepster_23@yahoo.com>
  * @copyright: 2013-2014 sas Project
  *   @package: sas_system
  *   @license: http://opensource.org/licenses/GPL-3.0 GPLv3
  *   @license: http://opensource.org/licenses/LGPL-3.0 LGPLv3
  */

define('system_dir','sas-system');
define('modules_dir','sas-content/modules');
define('blocks_dir','sas-content/blocks');
define('themes_dir','sas-content/themes');
define('upload_dir','sas-content/uploads');
define('tmp_dir','sas-content/uploads/tmp');

define('baseURL',@$uri.$config['baseURL']);
define('basePath',$config['basePath']);
define('systemURL',baseURL.system_dir.'/');
define('systemPath',basePath.system_dir.'/');
define('moduleURL',baseURL.modules_dir.'/');
define('modulePath',modules_dir.'/');
define('blockURL',baseURL.blocks_dir.'/');
define('blockPath',basePath.blocks_dir.'/');
define('themeURL',baseURL.themes_dir.'/');
define('themePath',basePath.themes_dir.'/');
define('uploadURL',baseURL.upload_dir.'/');
define('uploadPath',basePath.upload_dir.'/');
define('tmpURL',baseURL.tmp_dir.'/');
define('tmpPath',basePath.tmp_dir.'/');
define('ajaxURL',baseURL.'system/ajax/');
define('requestURI',$_SERVER['REQUEST_URI']);
?>
