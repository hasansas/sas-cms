<?php

/** sas - Load Class
  *
  *   @version: 1.1
  *    @author: Hasan Sas <nepster_23@yahoo.com>
  * @copyright: 2013-2014 sas Project
  *   @package: sas_system
  *   @license: http://opensource.org/licenses/GPL-3.0 GPLv3
  *   @license: http://opensource.org/licenses/LGPL-3.0 LGPLv3
  */

//ob_start();
//ob_start('ob_gzhandler');
ob_start();
session_name(isset($config['sessionName'])?$config['sessionName']:'sassession');
session_start();

require(systemPath.'databases/adodb/adodb.inc.php');
require(systemPath.'site.php');
require(systemPath.'auth.php');
require(systemPath.'user.php');
require(systemPath.'system.php');
require(systemPath.'functions.php');
require(systemPath.'form.php');
require(systemPath.'form/tree/tree.php');
require(systemPath.'post.php');
require(systemPath.'plugins/recaptcha/recaptchalib.php');
require(systemPath.'stats.php');
require(systemPath.'plugins/analytics/class.visitorTracking.php');
require(systemPath.'plugins/mobile.detect.php');
//require(systemPath.'plugins/counter.php');
?>
