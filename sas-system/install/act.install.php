<?php if (!defined('basePath')) exit('No direct script access allowed');

error_reporting(E_ALL ^ E_WARNING);

/* Base URL */
$masterName		= 'SAS Basic';
$baseURL		= str_replace('sas-system/install','',str_replace(str_replace('//','/',$_SERVER['DOCUMENT_ROOT'].'/'),'',str_replace('\\','/',dirname(__FILE__))));
$response		= array();
$error			= true;
$errorInstall 	= false;
$errorAlert		= '';
$adminName		= '';

if(!$db = NewADOConnection(@$_POST['driver'])){
	$errorAlert = 'Could not connect using '.$_POST['driver'].' driver';
	$response = array(

		'error' 		=> $error,
		'errorAlert' 	=> $errorAlert,
		'adminName' 	=> $adminName
	);
	echo json_encode($response);
	exit;
}

if($_POST['steps']==1){

	//create databse
	if($_POST['driver']=='mysql'){
		$errorAlert	= 'mysql extension is deprecated since PHP 5.5.0, consider using mysqli';
	}
	elseif(empty($_POST['db_host'])){
		$errorAlert	= 'Database Host can not be empty.';
	}
	elseif(empty($_POST['db_name'])){
		$errorAlert	= 'Database Name can not be empty.';
	}
	elseif(empty($_POST['db_user'])){
		$errorAlert	= 'Database User can not be empty.';
	}
	elseif(empty($_POST['table_prefix'])){
		$errorAlert	= 'Table prefix can not be empty.';
	}
	elseif(!preg_match('/^[a-zA-Z_]+$/',$_POST['table_prefix'])){
		$errorAlert = 'Only letters and underscore are allowed in table prefix.';
	}
	elseif(!$db->Connect($_POST['db_host'],$_POST['db_user'],$_POST['db_password'],$_POST['db_name'])){
		$errorAlert	= 'Could not connect to databse server.';
	}
	else{
		$error = false;
	}
	$response = array(

		'error' 		=> $error,
		'errorAlert' 	=> $errorAlert
	);
}
elseif($_POST['steps']==2){

	if(empty($_POST['admin_name'])){
		$errorAlert = 'Admin name required';
	}
	elseif(!preg_match('/^[a-zA-Z_-]+$/',$_POST['admin_name'])){
		$errorAlert = 'Only letters dashes and underscore are allowed in admin name.';
	}
	elseif(empty($_POST['sassession'])){
		$errorAlert = 'Session name required';
	}
	elseif(!preg_match('/^[a-zA-Z]+$/',$_POST['sassession'])){
		$errorAlert = 'Only letters are allowed in session name.';
	}
	else{
		$error = false;
	}
	$response = array(

		'error' 		=> $error,
		'errorAlert' 	=> $errorAlert
	);
}
elseif($_POST['steps']==3){

	if(empty($_POST['name'])){
		$errorAlert = 'Name required';
	}
	elseif(!preg_match('/^[a-zA-Z\s]+$/',$_POST['name'])){
		$errorAlert = 'Only letters and spaces are allowed in name.';
	}
	elseif(empty($_POST['username'])){
		$errorAlert = 'Username required';
	}
	elseif(!preg_match('/^[a-zA-Z0-9_]+$/',$_POST['username'])){
		$errorAlert = 'Only alphanumeric and underscore are allowed in username.';
	}
	elseif(empty($_POST['password'])){
		$errorAlert = 'Password required';
	}
	elseif(empty($_POST['repassword'])){
		$errorAlert = 'Retype password';
	}
	elseif($_POST['password']!=$_POST['repassword']){
		$errorAlert = 'Password not match';
	}
	else{
		$error = false;
	}
	$response = array(

		'error' 		=> $error,
		'errorAlert' 	=> $errorAlert
	);
}
elseif($_POST['steps']==4){

	if(empty($_POST['site_title'])){
		$errorAlert = 'Site title required';
	}
	elseif(!preg_match('/^[a-zA-Z0-9\s]+$/',$_POST['site_title'])){
		$errorAlert = 'Only alphanumeric and spaces are allowed in name.';
	}
	else{
		$error 			= false;
	}
	$response = array(

		'error' 		=> $error,
		'errorAlert' 	=> $errorAlert
	);
}
elseif($_POST['steps']=='install'){

	if (!$db->Connect($_POST['db_host'],$_POST['db_user'],$_POST['db_password'],$_POST['db_name'])){
		$errorAlert	= 'Could not connect to databse server.';
	}
	else{

		$dbDriver 		= $_POST['driver'];
		$dbHost 		= $_POST['db_host'];
		$dbUser 		= $_POST['db_user'];
		$dbPassword 	= $_POST['db_password'];
		$dbName 		= $_POST['db_name'];
		$tablePrefix 	= $_POST['table_prefix'];
		$adminName 		= $_POST['admin_name'];
		$permalink 		= $_POST['permalink'];
		$sessionsas 	= $_POST['sassession'];
		$site_title 	= !empty($_POST['site_title'])?$_POST['site_title']:$masterName;
		$site_tagline 	= !empty($_POST['site_tagline'])?$_POST['site_tagline']:'';
		$site_description 	= !empty($_POST['site_description'])?$_POST['site_description']:'';

		/*------------------------------------------*/
		/*	    Banner
		/*------------------------------------------*/
		$tbl_banner = "CREATE TABLE IF NOT EXISTS `".$tablePrefix."banner` (
		  `banner_id` int(10) UNSIGNED NOT NULL,
		  `banner_title` varchar(100) COLLATE latin1_general_ci NOT NULL,
		  `banner_link` varchar(255) COLLATE latin1_general_ci NOT NULL,
		  `banner_image` varchar(100) COLLATE latin1_general_ci NOT NULL,
		  `banner_order` tinyint(3) UNSIGNED NOT NULL,
		  `banner_position` enum('top','left','bottom','right') COLLATE latin1_general_ci NOT NULL,
		  `publish` tinyint(1) UNSIGNED NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;";
		$db->execute($tbl_banner);

		/*------------------------------------------*/
		/*	    Block
		/*------------------------------------------*/
		$tbl_block = "CREATE TABLE IF NOT EXISTS `".$tablePrefix."blocks` (
		  `block_id` int(10) UNSIGNED NOT NULL,
		  `block_theme` varchar(25) COLLATE latin1_general_ci NOT NULL,
		  `block_name` varchar(50) COLLATE latin1_general_ci NOT NULL,
		  `block_title` varchar(50) COLLATE latin1_general_ci NOT NULL,
		  `block_title_in` varchar(50) COLLATE latin1_general_ci NOT NULL,
		  `block_title_en` varchar(50) COLLATE latin1_general_ci NOT NULL,
		  `block_title_show` tinyint(1) UNSIGNED NOT NULL,
		  `block_position` varchar(10) COLLATE latin1_general_ci NOT NULL,
		  `block_order` tinyint(3) UNSIGNED NOT NULL,
		  `block_page` enum('home','hidehome','all') COLLATE latin1_general_ci NOT NULL,
		  `block_params` text COLLATE latin1_general_ci NOT NULL,
		  `active` tinyint(1) UNSIGNED NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;";
		$db->execute($tbl_block);

		/* Insert Block */
		$tbl_insert_block = "INSERT INTO `".$tablePrefix."blocks` (`block_id`, `block_theme`, `block_name`, `block_title`, `block_title_in`, `block_title_en`, `block_title_show`, `block_position`, `block_order`, `block_page`, `block_params`, `active`) VALUES
		(1, '".$tablePrefix."basic', 'slider', 'Slider', '', '', 1, 'top', 1, 'home', '', 1),
		(2, '".$tablePrefix."basic', 'breadcrumb', 'breadcrumb', '', '', 1, 'top', 2, 'hidehome', '', 1);";
		$db->execute($tbl_insert_block);

		/*------------------------------------------*/
		/*	    Category
		/*------------------------------------------*/
		$tbl_category = "CREATE TABLE IF NOT EXISTS `".$tablePrefix."category` (
		  `category_id` tinyint(3) UNSIGNED NOT NULL,
		  `parent_id` tinyint(4) UNSIGNED NOT NULL,
		  `category_name` varchar(50) NOT NULL,
		  `category_tagline` varchar(255) NOT NULL,
		  `category_description` varchar(255) NOT NULL,
		  `category_type` enum('main','post','events','gallery') NOT NULL,
		  `category_image` varchar(50) NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
		$db->execute($tbl_category);

		/*------------------------------------------*/
		/*	    Comments
		/*------------------------------------------*/
		$tbl_comments = "CREATE TABLE IF NOT EXISTS `".$tablePrefix."comments` (
		  `comment_id` int(11) NOT NULL,
		  `comment_post` int(11) NOT NULL,
		  `comment_parent` int(11) NOT NULL,
		  `comment_from` varchar(20) NOT NULL,
		  `comment_email` varchar(50) NOT NULL,
		  `comment_content` mediumtext NOT NULL,
		  `comment_date` datetime NOT NULL,
		  `comment_type` enum('post') NOT NULL,
		  `publish` tinyint(1) NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
		$db->execute($tbl_comments);


		/*------------------------------------------*/
		/*	    Config
		/*------------------------------------------*/
		$tbl_config = "CREATE TABLE IF NOT EXISTS `".$tablePrefix."config` (
		  `id` int(1) NOT NULL,
		  `site_theme` varchar(100) NOT NULL,
		  `site_title` varchar(255) NOT NULL,
		  `site_tagline` varchar(255) NOT NULL,
		  `site_description` varchar(255) NOT NULL,
		  `site_description_en` varchar(255) NOT NULL,
		  `site_description_in` varchar(255) NOT NULL,
		  `site_description_cz` varchar(255) NOT NULL,
		  `site_description_BRZ` varchar(255) NOT NULL,
		  `site_description_jpn` varchar(255) NOT NULL,
		  `site_keyword` text NOT NULL,
		  `site_keyword_en` text NOT NULL,
		  `site_keyword_in` text NOT NULL,
		  `site_keyword_cz` text NOT NULL,
		  `site_keyword_BRZ` text NOT NULL,
		  `site_keyword_jpn` text NOT NULL,
		  `site_welcome` text NOT NULL,
		  `company_name` varchar(255) NOT NULL,
		  `company_address` text NOT NULL,
		  `company_phone` varchar(255) NOT NULL,
		  `company_mobile` varchar(255) NOT NULL,
		  `company_fax` varchar(255) NOT NULL,
		  `company_logo` varchar(255) NOT NULL,
		  `site_footer` text NOT NULL,
		  `socila_media` mediumtext NOT NULL,
		  `email_account` varchar(255) NOT NULL,
		  `alternate_email` varchar(255) NOT NULL,
		  `lang` mediumtext NOT NULL,
		  `favicon` varchar(50) NOT NULL,
		  `menu_position` mediumtext NOT NULL,
		  `menu_public` tinytext NOT NULL,
		  `menu_admin` tinytext NOT NULL,
		  `watermark` varchar(50) NOT NULL,
		  `thumbnail` varchar(255) NOT NULL,
		  `default_img` varchar(50) NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;";
		$db->execute($tbl_config);

		/* Insert Config */
		$tbl_insert_config = "INSERT INTO `".$tablePrefix."config` (`id`, `site_theme`, `site_title`, `site_tagline`, `site_description`, `site_description_en`, `site_description_in`, `site_description_cz`, `site_description_BRZ`, `site_description_jpn`, `site_keyword`, `site_keyword_en`, `site_keyword_in`, `site_keyword_cz`, `site_keyword_BRZ`, `site_keyword_jpn`, `site_welcome`, `company_name`, `company_address`, `company_phone`, `company_mobile`, `company_fax`, `company_logo`, `site_footer`, `socila_media`, `email_account`, `alternate_email`, `lang`, `favicon`, `menu_position`, `menu_public`, `menu_admin`, `watermark`, `thumbnail`, `default_img`) VALUES
		(1, '".$tablePrefix."basic', '".$site_title."', '".$site_title."', '".$site_description."', 'Lorem ipsum', 'Lorem ipsum dolor sitamet', '', '', '', '', 'Dolor sitamet', '', '', '', '', '<div class=\"post\">\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc  id mi nulla, nec accumsan justo. In id arcu ac lorem ultrices  ullamcorper id sit amet arcu. Aliquam pretium arcu sit amet magna  sodales lacinia. Proin mattis odio ut diam feugiat aliquet. Duis  bibendum tincidunt risus aliquet tristique.</p>\r\n<p>Donec nulla sem, commodo quis lobortis et, ullamcorper ac enim.  Nullam congue mauris a sapien tempus feugiat. Phasellus sed libero  felis, a imperdiet dolor. Sed elementum turpis id eros tempor  consectetur.</p>\r\n<p>Nulla facilisi. Quisque sit amet ligula eget nunc congue  commodo. Donec odio velit, dapibus nec laoreet at, tristique nec dui.  Etiam ultrices porttitor ligula, non eleifend tortor tincidunt in.  Aliquam non dui augue, quis hendrerit massa.</p>\r\n</div>', 'SAS', 'uykhh9up9j', '678987', '9876543', '', '20180321083310.png', '&amp;Acirc;&amp;copy; Copyright SituSEHAT All Rights Reserved. ', 'a:10:{s:8:\"facebook\";s:36:\"http://facebook.com/ptbentangpustaka\";s:7:\"twitter\";s:33:\"http://twitter.com/bentangpustaka\";s:11:\"google_plus\";s:15:\"plus.google.com\";s:9:\"instagram\";s:36:\"https://instagram.com/bentangpustaka\";s:7:\"youtube\";s:56:\"https://www.youtube.com/channel/UChbY2PFpesk0jD8pJe2w7FA\";s:8:\"linkedin\";s:43:\"https://www.linkedin.com/in/bentangpustaka/\";s:9:\"pinterest\";s:0:\"\";s:6:\"flickr\";s:0:\"\";s:8:\"dribbble\";s:0:\"\";s:5:\"skype\";s:0:\"\";}', 'info@domain.com', 'support@domain.com', 'a:4:{s:7:\"ismulti\";i:0;s:12:\"default_lang\";a:2:{s:5:\"admin\";s:2:\"in\";s:6:\"public\";s:2:\"en\";}s:4:\"lang\";a:2:{s:2:\"en\";s:7:\"English\";s:2:\"in\";s:9:\"indonesia\";}s:4:\"icon\";a:2:{s:2:\"en\";s:32:\"flag-united-kingdomgreat-britain\";s:2:\"in\";s:14:\"flag-indonesia\";}}', '20180321083314.png', 'a:2:{s:5:\"admin\";a:5:{s:3:\"top\";s:3:\"Top\";s:6:\"bottom\";s:6:\"Bottom\";s:7:\"content\";s:7:\"Content\";s:7:\"setting\";s:7:\"Setting\";s:5:\"store\";s:5:\"Store\";}s:6:\"public\";a:7:{s:3:\"top\";s:3:\"Top\";s:4:\"left\";s:4:\"Left\";s:6:\"bottom\";s:6:\"Bottom\";s:5:\"right\";s:5:\"Right\";s:4:\"main\";s:4:\"Main\";s:8:\"category\";s:8:\"Category\";s:4:\"user\";s:4:\"User\";}} ', 'a:4:{s:3:\"top\";s:3:\"top\";s:4:\"left\";s:4:\"left\";s:6:\"bottom\";s:6:\"bottom\";s:5:\"right\";s:5:\"right\";}', 'left', 'small_90014kantordalam.jpg', 'a:4:{s:4:\"mini\";s:3:\"100\";s:5:\"small\";s:3:\"300\";s:6:\"medium\";s:3:\"400\";s:5:\"large\";s:3:\"600\";}', '20180210021530.jpg');";
		$db->execute($tbl_insert_config);

		/*------------------------------------------*/
		/*	    Contact
		/*------------------------------------------*/
		$tbl_contact = "CREATE TABLE IF NOT EXISTS `".$tablePrefix."contact` (
		  `contact_id` int(11) NOT NULL,
		  `contact_name` varchar(255) NOT NULL DEFAULT '',
		  `contact_email` varchar(255) NOT NULL DEFAULT '',
		  `contact_phone` varchar(255) NOT NULL DEFAULT '',
		  `contact_company` varchar(255) NOT NULL DEFAULT '',
		  `contact_address` varchar(255) NOT NULL DEFAULT '',
		  `contact_city` varchar(255) NOT NULL DEFAULT '',
		  `contact_province` varchar(255) NOT NULL,
		  `contact_country` varchar(255) NOT NULL DEFAULT '',
		  `contact_zip` varchar(255) NOT NULL DEFAULT '',
		  `contact_handphone` varchar(255) NOT NULL DEFAULT '',
		  `contact_fax` varchar(255) NOT NULL DEFAULT '',
		  `contact_message` text NOT NULL,
		  `contact_message_en` text NOT NULL,
		  `contact_message_in` text NOT NULL,
		  `contact_photo` varchar(255) NOT NULL,
		  `contact_position` varchar(20) NOT NULL,
		  `contact_reply_msg` varchar(255) DEFAULT NULL,
		  `contact_reply` tinyint(1) UNSIGNED DEFAULT '0',
		  `contact_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		  `contact_type` enum('contact','guestbook','testimonial') NOT NULL,
		  `approve` tinyint(1) NOT NULL,
		  `isread` int(1) NOT NULL,
		  `contact_ip` char(20) NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;";
		$db->execute($tbl_contact);

		/*------------------------------------------*/
		/*	    Email template
		/*------------------------------------------*/
		$tbl_email_template = "CREATE TABLE IF NOT EXISTS `".$tablePrefix."email_template` (
		  `email_id` int(11) NOT NULL,
		  `email_name` varchar(255) NOT NULL,
		  `email_subject` varchar(255) NOT NULL DEFAULT '',
		  `email_cc` varchar(100) NOT NULL,
		  `email_bcc` varchar(100) NOT NULL,
		  `email_content` text NOT NULL,
		  `email_from` varchar(255) NOT NULL DEFAULT '',
		  `email_from_name` varchar(255) NOT NULL DEFAULT '',
		  `email_description` varchar(255) NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;";
		$db->execute($tbl_email_template);

		/* Insert email template */
		$tbl_insert_email_template = "INSERT INTO `".$tablePrefix."email_template` (`email_id`, `email_name`, `email_subject`, `email_cc`, `email_bcc`, `email_content`, `email_from`, `email_from_name`, `email_description`) VALUES
		(1, 'contact', '[no-reply] - Domain name', '', '', '&amp;lt;p&amp;gt;Terima kasih telah menghubungi kami. Data Anda telah kami masukkan ke dalam database.&amp;lt;br /&amp;gt;\r\nKami akan membalas pertanyaan atau informasi yang dibutuhkan di website ini.Kami akan memberitahukan Anda melalui email.&amp;lt;br /&amp;gt;\r\n&amp;lt;br /&amp;gt;\r\nBerikut adalah data Anda :&amp;lt;br /&amp;gt;\r\n&amp;lt;br /&amp;gt;\r\nNama : {add_contact_name}&amp;lt;br /&amp;gt;\r\nEmail : {add_contact_email}&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;lt;br /&amp;gt;\r\nPesan:&amp;lt;br /&amp;gt;\r\n{add_contact_message}&amp;lt;br /&amp;gt;\r\n&amp;lt;br /&amp;gt;\r\nTerimakasih&amp;lt;/p&amp;gt;\r\n', 'email@domain.com', 'SAS Basic', 'Email Otomatis pada saat Pengunjung Mengisi Form Kontak Kami'),
		(2, 're-contact', '[no-reply] - Re : Contact Us', '', '', '&amp;lt;p&amp;gt;Yth {add_contact_name},&amp;lt;br /&amp;gt;\r\n&amp;amp;nbsp;&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;lt;br /&amp;gt;\r\nBerikut adalah jawaban atas pesan/pertanyaan anda&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;amp;nbsp;&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Pesan anda:&amp;lt;br /&amp;gt;\r\n&amp;lt;br /&amp;gt;\r\n{add_contact_message}&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;amp;nbsp;&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;Jawaban:&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;{add_contact_reply_msg}&amp;lt;/p&amp;gt;\r\n\r\n&amp;lt;p&amp;gt;&amp;lt;br /&amp;gt;\r\n&amp;lt;br /&amp;gt;\r\nTerimakasih&amp;lt;/p&amp;gt;\r\n', 'email@domain.com', 'SAS Basic', 'Email otomatis pada saat admin membalas pesan Kontak Kami');";
		$db->execute($tbl_insert_email_template);

		/*------------------------------------------*/
		/*	    faq
		/*------------------------------------------*/
		$tbl_faq = "CREATE TABLE IF NOT EXISTS `".$tablePrefix."faq` (
		  `faq_id` int(11) NOT NULL,
		  `question` varchar(255) NOT NULL,
		  `answer` text NOT NULL,
		  `faq_order` int(11) NOT NULL,
		  `publish` tinyint(1) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$db->execute($tbl_faq);

		/*------------------------------------------*/
		/*	    events
		/*------------------------------------------*/
		$tbl_events = "CREATE TABLE IF NOT EXISTS `".$tablePrefix."events` (
		  `event_id` int(11) NOT NULL,
		  `event_title` varchar(255) NOT NULL,
		  `event_description` mediumtext NOT NULL,
		  `event_content` text NOT NULL,
		  `event_tag` tinytext NOT NULL,
		  `start_date` datetime NOT NULL,
		  `end_date` datetime NOT NULL,
		  `place` varchar(150) NOT NULL,
		  `address` varchar(255) NOT NULL,
		  `image` varchar(100) NOT NULL,
		  `status` tinyint(1) NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
		$db->execute($tbl_events);

		/*------------------------------------------*/
		/*	    Menu
		/*------------------------------------------*/
		$tbl_menu = "CREATE TABLE IF NOT EXISTS `".$tablePrefix."menu` (
		  `menu_id` int(10) UNSIGNED NOT NULL,
		  `parent_id` int(10) UNSIGNED NOT NULL,
		  `page_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
		  `admin_menu` tinyint(1) UNSIGNED NOT NULL,
		  `position` mediumtext NOT NULL,
		  `icon` varchar(50) NOT NULL,
		  `custom_links` tinyint(1) UNSIGNED NOT NULL,
		  `custom_title` varchar(20) NOT NULL,
		  `custom_url` varchar(100) NOT NULL,
		  `target` varchar(7) NOT NULL,
		  `menu_order` tinyint(3) UNSIGNED NOT NULL,
		  `publish` tinyint(1) UNSIGNED NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;";
		$db->execute($tbl_menu);

		/* Insert Menu */
		$tbl_insert_menu = "INSERT INTO `".$tablePrefix."menu` (`menu_id`, `parent_id`, `page_id`, `admin_menu`, `position`, `icon`, `custom_links`, `custom_title`, `custom_url`, `target`, `menu_order`, `publish`) VALUES
		(2, 12, 3, 1, 'left', 'fa fa-circle-o ', 0, '', '', '', 0, 1),
		(3, 0, 4, 1, 'left', 'fa fa-paper-plane-o', 0, '', '', '', 8, 1),
		(7, 6, 8, 1, 'left', 'fa fa-circle-o ', 0, '', '', '', 4, 1),
		(8, 6, 10, 1, 'left', 'fa fa-circle-o ', 0, '', '', '', 0, 1),
		(9, 0, 11, 1, 'left', 'fa fa-pencil-square-o', 0, '', '', '', 5, 1),
		(10, 9, 16, 1, 'left', 'fa fa-circle-o ', 0, '', '', '', 0, 1),
		(11, 9, 14, 1, 'left', 'fa fa-circle-o ', 0, '', '', '', 1, 1),
		(6, 0, 7, 1, 'left', 'fa fa-cogs', 0, '', '', '', 10, 1),
		(12, 0, 17, 1, 'left', 'fa fa-paint-brush', 0, '', '', '', 7, 1),
		(13, 0, 19, 1, 'left', 'fa fa-user', 0, '', '', '', 9, 1),
		(14, 13, 20, 1, 'left', 'fa fa-circle-o ', 0, '', '', '', 0, 1),
		(15, 13, 21, 1, 'left', 'fa fa-circle-o ', 0, '', '', '', 1, 1),
		(17, 0, 1, 0, 'left', 'fa fa-caret-right', 0, '', '', '', 0, 1),
		(16, 12, 32, 1, 'left', 'fa fa-circle-o ', 0, '', '', '', 1, 1),
		(18, 0, 50, 1, 'left', 'fa fa-wrench', 0, '', '', '', 11, 1),
		(19, 6, 49, 1, 'left', 'fa fa-circle-o ', 0, '', '', '', 3, 1),
		(20, 0, 1, 1, 'top', 'fa fa-desktop', 0, '', '', '', 0, 1),
		(21, 0, 1, 1, 'left', 'fa fa-desktop', 0, '', '', '', 0, 1),
		(22, 12, 53, 1, 'left', 'fa fa-circle-o ', 0, '', '', '', 3, 1),
		(23, 12, 52, 1, 'left', 'fa fa-circle-o ', 0, '', '', '', 2, 1),
		(36, 0, 1, 0, 'top', 'fa fa-desktop ', 0, '', '', '', 0, 1),
		(57, 0, 110, 1, 'left', 'fa fa-bar-chart ', 0, '', '', '', 4, 1),
		(122, 12, 207, 1, 'left', 'fa fa-circle-o', 0, '', '', '', 4, 1),
		(123, 0, 210, 1, 'left', 'fa fa-calendar ', 0, '', '', '', 1, 1),
		(82, 6, 151, 1, 'left', 'fa fa-circle-o', 0, '', '', '', 2, 1),
		(80, 0, 81, 0, 'footer_right', 'fa fa-circle-o', 0, '', '', '', 0, 1),
		(79, 0, 1, 0, 'footer_left', 'fa fa-circle-o', 0, '', '', '', 0, 1),
		(81, 0, 148, 1, 'left', 'fa fa-comment-o ', 0, '', '', '', 6, 1),
		(83, 0, 149, 1, 'left', 'fa fa-envelope-o ', 0, '', '', '', 2, 1),
		(84, 0, 149, 0, 'top', 'fa fa-circle-o', 0, '', '', '', 3, 1),
		(85, 6, 156, 1, 'left', 'fa fa-circle-o', 0, '', '', '', 1, 1),
		(91, 100, 181, 0, 'top', 'fa fa-circle-o', 0, '', '', '', 0, 1),
		(93, 0, 81, 0, 'top', 'fa fa-circle-o', 0, '', '', '', 1, 1),
		(112, 0, 199, 1, 'left', 'fa fa-question ', 0, '', '', '', 3, 1),
		(111, 0, 199, 0, 'top', 'fa fa-circle-o', 0, '', '', '', 2, 1),
		(118, 0, 1, 0, 'footer', 'fa fa-circle-o', 0, '', '', '', 0, 1),
		(119, 0, 199, 0, 'footer', 'fa fa-circle-o', 0, '', '', '', 2, 1),
		(120, 0, 149, 0, 'footer', 'fa fa-circle-o', 0, '', '', '', 4, 1);";
		$db->execute($tbl_insert_menu);

		/*------------------------------------------*/
		/*	    migrations
		/*------------------------------------------*/
		$tbl_migrations = "CREATE TABLE IF NOT EXISTS `".$tablePrefix."migrations` (
		  `migration_id` int(11) NOT NULL,
		  `migration_module` varchar(50) NOT NULL,
		  `migration_file` varchar(50) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$db->execute($tbl_migrations);

		/*------------------------------------------*/
		/*	    Modules
		/*------------------------------------------*/
		$tbl_modules = "CREATE TABLE IF NOT EXISTS `".$tablePrefix."modules` (
		  `module_id` tinyint(3) UNSIGNED NOT NULL,
		  `module_name` varchar(30) NOT NULL,
		  `status` tinyint(1) NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;";
		$db->execute($tbl_modules);

		/* Insert Modules */
		$tbl_insert_modules = "INSERT INTO `".$tablePrefix."modules` (`module_id`, `module_name`, `status`) VALUES
		(1, 'home', 1),
		(2, 'config', 1),
		(4, 'lang', 0),
		(3, 'posts', 1),
		(5, 'slider', 1),
		(18, 'statistik', 1),
		(40, 'events', 1),
		(22, 'contactus', 1),
		(23, 'emailmanager', 1),
		(27, 'search', 1),
		(39, 'banner', 1),
		(38, 'faq', 1);";
		$db->execute($tbl_insert_modules);


		/*------------------------------------------*/
		/*	    Pages
		/*------------------------------------------*/
		$tbl_pages = "CREATE TABLE IF NOT EXISTS `".$tablePrefix."pages` (
		  `page_id` int(10) UNSIGNED NOT NULL,
		  `parent_id` int(10) UNSIGNED NOT NULL,
		  `module_id` int(10) UNSIGNED NOT NULL,
		  `content_id` int(10) UNSIGNED NOT NULL,
		  `category_id` tinyint(3) UNSIGNED NOT NULL,
		  `page_name` varchar(255) NOT NULL,
		  `page_tagline` varchar(255) NOT NULL,
		  `page_switch` varchar(50) NOT NULL,
		  `page_url` varchar(255) NOT NULL,
		  `admin_only` tinyint(1) NOT NULL,
		  `publish` tinyint(1) UNSIGNED NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
		$db->execute($tbl_pages);

		/* Insert Pages */
		$tbl_insert_pages = "INSERT INTO `".$tablePrefix."pages` (`page_id`, `parent_id`, `module_id`, `content_id`, `category_id`, `page_name`, `page_tagline`, `page_switch`, `page_url`, `admin_only`, `publish`) VALUES
		(1, 0, 1, 0, 0, 'home', '', '', 'home', 0, 1),
		(2, 4, 2, 0, 0, 'add new page', '', 'page_add', 'add-new-page', 1, 0),
		(3, 17, 2, 0, 0, 'menu management', '', 'menu', 'menu-management', 1, 1),
		(5, 4, 2, 0, 0, 'Manage Pages', '', 'page', 'manage-pages', 1, 0),
		(6, 3, 2, 0, 0, 'edit menu', '', 'menu_edit', 'edit-menu', 1, 0),
		(8, 7, 2, 0, 0, 'Modules', '', 'modules', 'modules', 1, 1),
		(9, 4, 2, 0, 0, 'Edit Page', '', 'page_edit', 'edit-page', 1, 0),
		(10, 7, 2, 0, 0, 'site config', '', 'site_config', 'site-config', 1, 1),
		(11, 0, 3, 0, 0, 'Posts', '', 'main', 'post', 1, 1),
		(12, 16, 3, 0, 0, 'Add New Post', '', 'post_add', 'add-new-post', 0, 0),
		(13, 16, 3, 0, 0, 'Edit Post', '', 'post_edit', 'edit-post', 0, 0),
		(14, 11, 3, 0, 0, 'Post Category', '', 'category', 'post-category', 1, 1),
		(15, 14, 3, 0, 0, 'edit_category', '', 'category_edit', 'edit-category', 1, 0),
		(16, 11, 3, 0, 0, 'Manage Post', '', 'main', 'manage-post', 1, 1),
		(7, 0, 2, 0, 0, 'Configuration', '', 'config', 'configuration', 1, 1),
		(17, 0, 2, 0, 0, 'Appearence', '', 'appearence', 'appearence', 1, 1),
		(18, 14, 3, 0, 0, 'Add Category', '', 'category_add', 'add-category', 1, 0),
		(4, 0, 2, 0, 0, 'Pages', '', 'page', 'pages', 1, 1),
		(19, 7, 2, 0, 0, 'User', '', 'user', 'user', 1, 1),
		(20, 19, 2, 0, 0, 'Manage User', '', 'user', 'manage-user', 1, 1),
		(21, 19, 2, 0, 0, 'User Group', '', 'group', 'user-group', 1, 1),
		(22, 20, 2, 0, 0, 'Add User', '', 'user_add', 'add-user', 1, 0),
		(23, 20, 2, 0, 0, 'Edit User', '', 'user_edit', 'edit-user', 1, 0),
		(24, 21, 2, 0, 0, 'permission', '', 'group_permission', 'permission', 1, 0),
		(25, 0, 2, 0, 0, 'My Account', '', 'user_account', 'my-account', 1, 0),
		(26, 0, 2, 0, 0, 'my profile', '', 'user_profile', 'my-profile', 1, 0),
		(32, 17, 2, 0, 0, 'Widget', '', 'widget_main', 'widget', 1, 1),
		(33, 32, 2, 0, 0, 'Add Widget', '', 'widget_add', 'add-widget', 1, 0),
		(34, 32, 2, 0, 0, 'Edit Widget', '', 'widget_edit', 'edit-widget', 1, 0),
		(47, 11, 3, 0, 0, 'read', '', 'read', 'read', 0, 0),
		(49, 7, 2, 0, 0, 'Language', '', 'lang_main', 'language', 1, 1),
		(50, 0, 2, 0, 0, 'Dev Tools', '', 'tools', 'dev-tools', 1, 1),
		(52, 17, 2, 0, 0, 'templates', '', 'templates', 'templates', 1, 1),
		(53, 17, 5, 0, 0, 'Slider', '', 'slider_main', 'slider', 1, 1),
		(54, 53, 5, 0, 0, 'Add Slider', '', 'slider_add', 'add-slider', 1, 0),
		(55, 53, 5, 0, 0, 'Edit Slider', '', 'slider_edit', 'edit-slider', 1, 0),
		(71, 69, 9, 0, 0, 'edit album', '', 'album_edit', 'edit-album', 0, 0),
		(81, 0, 2, 1, 0, 'About us', 'Cillum ut poulet tikka', '_page', 'about-us', 0, 1),
		(95, 69, 9, 0, 0, 'Add album', '', 'album_add', 'add-album', 0, 0),
		(103, 0, 27, 0, 0, 'Search', 'Search for content', 'search_main', 'search', 0, 0),
		(110, 0, 18, 0, 0, 'Statistics', '', 'statistics_main', 'statistics', 1, 1),
		(209, 207, 39, 0, 0, 'Edit Banner', '', 'banner_edit', 'edit-banner', 0, 0),
		(208, 207, 39, 0, 0, 'Add banner', '', 'banner_add', 'add-banner', 0, 0),
		(207, 0, 39, 0, 0, 'Banner', '', 'banner_main', 'banner', 0, 1),
		(150, 149, 22, 0, 0, 'reply contact', '', 'contact_edit', 'reply-contact', 1, 0),
		(149, 0, 22, 0, 0, 'contact Us', '', 'contact_main', 'contact-us', 0, 1),
		(148, 0, 3, 0, 0, 'Comments', '', 'comments', 'comments', 1, 1),
		(151, 149, 22, 0, 0, 'contact Setting', '', 'contact_setting', 'contact-setting', 1, 1),
		(158, 156, 23, 0, 0, 'edit email template', '', 'email_edit', 'edit-email-template', 1, 0),
		(157, 156, 23, 0, 0, 'add email template', '', 'email_add', 'add-email-template', 1, 0),
		(156, 0, 23, 0, 0, 'Email Manager', '', 'email_main', 'email-manager', 1, 1),
		(181, 0, 3, 0, 11, 'Blog', '', '', 'blog', 0, 1),
		(182, 181, 3, 0, 0, 'add new Blog', '', 'post_add', 'add-new-blog', 0, 0),
		(183, 181, 3, 0, 0, 'edit Blog', '', 'post_edit', 'edit-blog', 0, 0),
		(212, 210, 40, 0, 0, 'Edit event', '', 'event_edit', 'edit-event', 0, 0),
		(210, 0, 40, 0, 0, 'Events', '', 'event_main', 'events', 0, 1),
		(211, 210, 40, 0, 0, 'Add event', '', 'event_add', 'add-event', 0, 0),
		(199, 0, 38, 0, 0, 'FAQ', '', 'faq_view', 'faq', 0, 1),
		(200, 199, 38, 0, 0, 'add FAQ', '', 'faq_add', 'add-faq', 0, 0),
		(201, 199, 38, 0, 0, 'Edit FAQ', '', 'faq_edit', 'edit-faq', 0, 0);";
		$db->execute($tbl_insert_pages);

		/* Pages Content */
		$tbl_pages_content = "CREATE TABLE IF NOT EXISTS `".$tablePrefix."pages_content` (
		  `content_id` int(11) NOT NULL,
		  `content_title` varchar(255) COLLATE latin1_general_ci NOT NULL,
		  `content_tagline` varchar(255) COLLATE latin1_general_ci NOT NULL,
		  `content_description` tinytext COLLATE latin1_general_ci NOT NULL,
		  `content_text` text COLLATE latin1_general_ci NOT NULL,
		  `content_tag` tinytext COLLATE latin1_general_ci NOT NULL,
		  `content_image` varchar(255) COLLATE latin1_general_ci NOT NULL,
		  `content_author` varchar(100) COLLATE latin1_general_ci NOT NULL,
		  `content_rating` tinyint(5) NOT NULL,
		  `created_date` datetime NOT NULL,
		  `updated_date` datetime NOT NULL,
		  `publish` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
		) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;";
		$db->execute($tbl_pages_content);

		/* Insert Pages Content */
		$tbl_pages_content = "INSERT INTO `".$tablePrefix."pages_content` (`content_id`, `content_title`, `content_tagline`, `content_description`, `content_text`, `content_tag`, `content_image`, `content_author`, `content_rating`, `created_date`, `updated_date`, `publish`) VALUES
		(1, 'About us', 'Cillum ut poulet tikka', '', '&amp;lt;p&amp;gt;about&amp;lt;/p&amp;gt;\r\n', '', '20150824021407.jpg', '', 0, '2015-08-11 07:30:26', '2018-02-17 07:06:29', 1);";
		$db->execute($tbl_pages_content);


		/*------------------------------------------*/
		/*	    Params
		/*------------------------------------------*/
		$tbl_params = "CREATE TABLE `sas_params` (
		  `params_id` int(1) NOT NULL,
		  `content` mediumtext NOT NULL,
		  `contact` mediumtext NOT NULL,
		  `guestbook` mediumtext NOT NULL,
		  `testimonial` mediumtext NOT NULL,
		  `running_text` varchar(255) NOT NULL,
		  `langtable` text NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;";
		$db->execute($tbl_params);

		/* Insert Params */
		$tbl_insert_params = "INSERT INTO `".$tablePrefix."params` (`params_id`, `content`, `contact`, `guestbook`, `testimonial`, `running_text`, `langtable`) VALUES
		(1, 'a:12:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";i:3;s:1:\"4\";i:4;s:1:\"5\";i:5;s:1:\"8\";i:6;s:1:\"9\";i:7;s:2:\"10\";i:8;s:2:\"12\";i:9;s:2:\"13\";i:10;s:2:\"16\";i:11;s:2:\"17\";}', 'a:3:{s:7:\"content\";s:60:\"IDQ0NSBNb3VudCBFZGVuIFJvYWQsIE1vdW50IEVkZW4sIEF1Y2tsYW5kLg==\";s:7:\"setting\";a:4:{i:0;s:30:\"(-36.88221,174.76198399999998)\";i:1;s:12:\"contact_name\";i:2;s:13:\"contact_email\";i:3;s:0:\"\";}s:11:\"geolocation\";s:28:\"-36.88221,174.76198399999998\";}', 'a:2:{s:7:\"content\";s:0:\"\";s:7:\"setting\";a:3:{i:0;s:12:\"contact_name\";i:1;s:13:\"contact_email\";i:2;s:0:\"\";}}', 'a:2:{s:7:\"content\";s:0:\"\";s:7:\"setting\";a:2:{i:0;s:12:\"contact_name\";i:1;s:13:\"contact_email\";}}', 'lorem ipsum dolor sit amet', 'a:1:{s:9:\"".$tablePrefix."posts\";a:2:{i:0;a:2:{i:0;a:2:{i:0;a:2:{i:0;a:2:{i:0;a:2:{i:0;a:2:{i:0;a:2:{i:0;a:2:{i:0;a:2:{i:0;a:2:{i:0;a:1:{i:0;s:13:\"post_title_en\";}i:1;s:13:\"post_title_in\";}i:1;s:13:\"post_title_cz\";}i:1;s:15:\"post_content_en\";}i:1;s:15:\"post_content_in\";}i:1;s:15:\"post_content_cz\";}i:1;s:19:\"post_description_en\";}i:1;s:19:\"post_description_in\";}i:1;s:19:\"post_description_cz\";}i:1;s:11:\"post_tag_en\";}i:1;s:11:\"post_tag_in\";}i:1;s:11:\"post_tag_cz\";}}');";
		$db->execute($tbl_insert_params);


		/*------------------------------------------*/
		/*	    Posts
		/*------------------------------------------*/
		$tbl_posts = "CREATE TABLE IF NOT EXISTS `".$tablePrefix."posts` (
		  `post_id` int(11) UNSIGNED NOT NULL,
		  `post_section` tinyint(3) NOT NULL,
		  `post_category` tinytext COLLATE latin1_general_ci NOT NULL,
		  `post_category_parent` int(11) NOT NULL,
		  `post_category_main_parent` int(11) NOT NULL,
		  `post_title` varchar(255) COLLATE latin1_general_ci NOT NULL,
		  `post_title_in` varchar(255) COLLATE latin1_general_ci NOT NULL,
		  `post_title_en` varchar(255) COLLATE latin1_general_ci NOT NULL,
		  `post_tagline` varchar(255) COLLATE latin1_general_ci NOT NULL,
		  `post_tagline_in` varchar(255) COLLATE latin1_general_ci NOT NULL,
		  `post_tagline_en` varchar(255) COLLATE latin1_general_ci NOT NULL,
		  `post_description` mediumtext COLLATE latin1_general_ci NOT NULL,
		  `post_description_in` mediumtext COLLATE latin1_general_ci NOT NULL,
		  `post_description_en` mediumtext COLLATE latin1_general_ci NOT NULL,
		  `post_content` text COLLATE latin1_general_ci NOT NULL,
		  `post_content_in` text COLLATE latin1_general_ci NOT NULL,
		  `post_content_en` text COLLATE latin1_general_ci NOT NULL,
		  `post_tag` tinytext COLLATE latin1_general_ci NOT NULL,
		  `post_tag_in` tinytext COLLATE latin1_general_ci NOT NULL,
		  `post_tag_en` tinytext COLLATE latin1_general_ci NOT NULL,
		  `post_image` varchar(255) COLLATE latin1_general_ci NOT NULL,
		  `posts_author` varchar(100) COLLATE latin1_general_ci NOT NULL,
		  `posts_author_id` int(11) NOT NULL,
		  `post_hits` int(10) UNSIGNED NOT NULL,
		  `post_rating` tinyint(5) UNSIGNED NOT NULL,
		  `post_type` enum('post','project') COLLATE latin1_general_ci NOT NULL,
		  `created_date` datetime NOT NULL,
		  `published_date` datetime NOT NULL,
		  `published_by` int(11) NOT NULL,
		  `edited_date` datetime NOT NULL,
		  `edited_by` int(11) NOT NULL,
		  `is_edited` tinyint(1) NOT NULL,
		  `headline` tinyint(1) NOT NULL,
		  `headline_order` int(11) NOT NULL,
		  `publish` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
		) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;";
		$db->execute($tbl_posts);


		/*------------------------------------------*/
		/*	    Slider
		/*------------------------------------------*/
		$tbl_slider = "CREATE TABLE IF NOT EXISTS `".$tablePrefix."slider` (
		  `slider_id` int(3) UNSIGNED NOT NULL,
		  `title` varchar(100) COLLATE latin1_general_ci NOT NULL,
		  `tagline` varchar(100) COLLATE latin1_general_ci NOT NULL,
		  `description` varchar(255) COLLATE latin1_general_ci NOT NULL,
		  `image` varchar(100) COLLATE latin1_general_ci NOT NULL,
		  `btn_caption` varchar(10) COLLATE latin1_general_ci NOT NULL,
		  `url` varchar(255) COLLATE latin1_general_ci NOT NULL,
		  `slider_order` tinyint(3) NOT NULL,
		  `publish` tinyint(1) UNSIGNED NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;";
		$db->execute($tbl_slider);

		/* Insert Slider */
		$tbl_insert_slider= "INSERT INTO `".$tablePrefix."slider` (`slider_id`, `title`, `tagline`, `description`, `image`, `btn_caption`, `url`, `slider_order`, `publish`) VALUES
(1, 'Sed volutpat cursus augue', 'On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and de', 'On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee.', '20180321111543.jpg', '', '', 2, 1),
(3, 'Mauris viverra ante', ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ac turpis nec ante scelerisque ', 'Mauris orci nisi, suscipit non mauris nec, euismod volutpat sapien. Nulla placerat dui in semper consectetur. Proin commodo magna sit amet augue volutpat, sed euismod urna blandit. Nam vestibulum, felis nec accumsan auctor', '20180321111531.jpg', '', '', 1, 1);";
		$db->execute($tbl_insert_slider);


		/*------------------------------------------*/
		/*	    User
		/*------------------------------------------*/
		$tbl_user = "CREATE TABLE IF NOT EXISTS `".$tablePrefix."user` (
		  `id` tinyint(3) NOT NULL AUTO_INCREMENT,
		  `group_id` tinyint(3) NOT NULL,
		  `name` varchar(100) COLLATE latin1_general_ci NOT NULL,
		  `username` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
		  `pass` varchar(255) COLLATE latin1_general_ci NOT NULL,
		  `email` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
		  `image` varchar(50) COLLATE latin1_general_ci NOT NULL,
		  `active` int(1) NOT NULL,
		  `authsession` varchar(50) COLLATE latin1_general_ci NOT NULL,
		  `lastlogin` datetime NOT NULL,
		  `lastloginfrom` char(20) COLLATE latin1_general_ci NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=6 ;";
		$db->execute($tbl_user);

		/* Insert User */
		$tbl_insert_user = "INSERT INTO `".$tablePrefix."user` (`id`, `group_id`, `name`, `username`, `pass`, `email`, `image`, `active`, `authsession`, `lastlogin`, `lastloginfrom`) VALUES
(1, 1, '".$_POST['name']."', '".$_POST['username']."', '".md5(base64_encode($_POST['password']))."', '', '20150128022331.jpg', 1, '', '', '');";
		$db->execute($tbl_insert_user);

		/* User Group */
		$tbl_user_group = "CREATE TABLE IF NOT EXISTS `".$tablePrefix."user_group` (
		  `group_id` int(11) NOT NULL,
		  `name` varchar(100) COLLATE latin1_general_ci NOT NULL,
		  `access` longtext COLLATE latin1_general_ci NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ROW_FORMAT=DYNAMIC;";
		$db->execute($tbl_user_group);

		/* Insert User Group */
		$tbl_insert_user_group= "INSERT INTO `".$tablePrefix."user_group` (`group_id`, `name`, `access`) VALUES
		(1, 'developer', 'a:61:{i:0;s:2:\"81\";i:1;s:2:\"17\";i:2;s:1:\"3\";i:3;s:1:\"6\";i:4;s:2:\"53\";i:5;s:2:\"54\";i:6;s:2:\"55\";i:7;s:2:\"52\";i:8;s:2:\"32\";i:9;s:2:\"33\";i:10;s:2:\"34\";i:11;s:3:\"207\";i:12;s:3:\"208\";i:13;s:3:\"209\";i:14;s:3:\"181\";i:15;s:3:\"182\";i:16;s:3:\"183\";i:17;s:3:\"148\";i:18;s:1:\"7\";i:19;s:2:\"49\";i:20;s:1:\"8\";i:21;s:2:\"10\";i:22;s:2:\"19\";i:23;s:2:\"20\";i:24;s:2:\"22\";i:25;s:2:\"23\";i:26;s:2:\"21\";i:27;s:2:\"24\";i:28;s:3:\"149\";i:29;s:3:\"151\";i:30;s:3:\"150\";i:31;s:3:\"156\";i:32;s:3:\"157\";i:33;s:3:\"158\";i:34;s:3:\"210\";i:35;s:3:\"211\";i:36;s:3:\"212\";i:37;s:3:\"199\";i:38;s:3:\"200\";i:39;s:3:\"201\";i:40;s:1:\"1\";i:41;s:2:\"25\";i:42;s:2:\"26\";i:43;s:1:\"4\";i:44;s:1:\"2\";i:45;s:1:\"9\";i:46;s:1:\"5\";i:47;s:2:\"11\";i:48;s:2:\"16\";i:49;s:2:\"12\";i:50;s:2:\"13\";i:51;s:2:\"14\";i:52;s:2:\"18\";i:53;s:2:\"15\";i:54;s:2:\"47\";i:55;s:3:\"103\";i:56;s:3:\"110\";i:57;s:2:\"50\";i:58;i:213;i:59;i:214;i:60;i:215;}'),
		(2, 'Super Admin', 'a:46:{i:0;s:2:\"17\";i:1;s:1:\"3\";i:2;s:1:\"6\";i:3;s:2:\"53\";i:4;s:2:\"54\";i:5;s:2:\"55\";i:6;s:2:\"52\";i:7;s:2:\"32\";i:8;s:2:\"33\";i:9;s:2:\"34\";i:10;s:3:\"166\";i:11;s:3:\"167\";i:12;s:3:\"168\";i:13;s:1:\"7\";i:14;s:2:\"10\";i:15;s:2:\"19\";i:16;s:2:\"20\";i:17;s:2:\"22\";i:18;s:2:\"23\";i:19;s:2:\"21\";i:20;s:2:\"24\";i:21;s:1:\"1\";i:22;s:2:\"25\";i:23;s:2:\"26\";i:24;s:3:\"133\";i:25;s:3:\"134\";i:26;s:3:\"140\";i:27;s:3:\"139\";i:28;s:3:\"138\";i:29;s:3:\"137\";i:30;s:3:\"136\";i:31;s:3:\"135\";i:32;s:1:\"4\";i:33;s:1:\"2\";i:34;s:1:\"9\";i:35;s:1:\"5\";i:36;s:2:\"47\";i:37;s:3:\"103\";i:38;s:3:\"120\";i:39;s:3:\"121\";i:40;s:3:\"122\";i:41;s:2:\"81\";i:42;s:3:\"141\";i:43;s:3:\"142\";i:44;s:3:\"143\";i:45;s:3:\"144\";}'),
		(3, 'Admin', 'a:19:{i:0;s:3:\"129\";i:1;s:3:\"130\";i:2;s:3:\"131\";i:3;s:3:\"111\";i:4;s:3:\"112\";i:5;s:3:\"113\";i:6;s:3:\"123\";i:7;s:3:\"124\";i:8;s:3:\"125\";i:9;s:1:\"1\";i:10;s:2:\"25\";i:11;s:2:\"26\";i:12;s:3:\"141\";i:13;s:3:\"142\";i:14;s:3:\"143\";i:15;s:3:\"144\";i:16;s:3:\"126\";i:17;s:3:\"127\";i:18;s:3:\"128\";}');";
		$db->execute($tbl_insert_user_group);

		/* User Log */
		$tbl_user_log = "CREATE TABLE IF NOT EXISTS `".$tablePrefix."user_log` (
		  `log_id` int(10) UNSIGNED NOT NULL,
		  `log_date` datetime NOT NULL,
		  `user_id` tinyint(3) UNSIGNED NOT NULL,
		  `query` text NOT NULL,
		  `activity` tinytext NOT NULL,
		  `aceess_page` varchar(255) NOT NULL,
		  `accessip` char(20) NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
		$db->execute($tbl_user_log);

		/*------------------------------------------*/
		/*	    Visitor
		/*------------------------------------------*/
		$tbl_visitor = "CREATE TABLE IF NOT EXISTS `".$tablePrefix."visitors` (
		  `id` int(11) NOT NULL,
		  `visitor_ip` varchar(256) NOT NULL,
		  `visitor_city` varchar(64) NOT NULL,
		  `visitor_state` varchar(64) NOT NULL,
		  `visitor_country` varchar(64) NOT NULL,
		  `visitor_flag` varchar(256) NOT NULL,
		  `visitor_browser` varchar(64) NOT NULL,
		  `visitor_OS` varchar(64) NOT NULL,
		  `visitor_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  `visitor_day` tinyint(2) NOT NULL,
		  `visitor_month` tinyint(2) NOT NULL,
		  `visitor_year` int(4) NOT NULL,
		  `visitor_hour` tinyint(2) NOT NULL DEFAULT '0',
		  `visitor_minute` tinyint(2) NOT NULL DEFAULT '0',
		  `visitor_seconds` tinyint(2) NOT NULL DEFAULT '0',
		  `visitor_referer` varchar(256) DEFAULT NULL,
		  `visitor_page` varchar(256) DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$db->execute($tbl_visitor);

		/*------------------------------------------*/
		/*	    Indexes
		/*------------------------------------------*/
		$query = "ALTER TABLE `".$tablePrefix."banner` ADD PRIMARY KEY (`banner_id`);";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."blocks`  ADD PRIMARY KEY (`block_id`);";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."category`  ADD PRIMARY KEY (`category_id`);";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."comments`
		  ADD PRIMARY KEY (`comment_id`);";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."config`
		  ADD PRIMARY KEY (`id`);";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."contact`
		  ADD PRIMARY KEY (`contact_id`);";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."email_template`
		  ADD PRIMARY KEY (`email_id`),
		  ADD UNIQUE KEY `email_name` (`email_name`);";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."events`
		  ADD PRIMARY KEY (`event_id`);";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."faq`
		  ADD PRIMARY KEY (`faq_id`);";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."menu`
		  ADD PRIMARY KEY (`menu_id`);";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."migrations`
		  ADD PRIMARY KEY (`migration_id`);";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."modules`
		  ADD PRIMARY KEY (`module_id`);";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."pages`
		  ADD PRIMARY KEY (`page_id`);";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."pages_content`
		  ADD PRIMARY KEY (`content_id`);";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."posts`
		  ADD PRIMARY KEY (`post_id`);";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."slider`
		  ADD PRIMARY KEY (`slider_id`);";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."user`
		  ADD PRIMARY KEY (`id`);";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."user_group`
		  ADD PRIMARY KEY (`group_id`);";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."user_log`
		  ADD PRIMARY KEY (`log_id`);";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."visitors`
		  ADD PRIMARY KEY (`id`);";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."banner`
		  MODIFY `banner_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."blocks`
		  MODIFY `block_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."category`
		  MODIFY `category_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."comments`
		  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."config`
		  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."contact`
		  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."email_template`
		  MODIFY `email_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."events`
		  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT;";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."faq`
		  MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."menu`
		  MODIFY `menu_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."migrations`
		  MODIFY `migration_id` int(11) NOT NULL AUTO_INCREMENT;";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."modules`
		  MODIFY `module_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."pages`
		  MODIFY `page_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=218;";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."pages_content`
		  MODIFY `content_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."posts`
		  MODIFY `post_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."slider`
		  MODIFY `slider_id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."user`
		  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."user_group`
		  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."user_log`
		  MODIFY `log_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;";
		$db->execute($query);

		$query = "ALTER TABLE `".$tablePrefix."visitors`
		  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1716;";
		$db->execute($query);
	}

	/* Update config & htaccess*/
	require_once 'htaccessfile.php';
	require_once 'configfile.php';

	if($errorInstall){

		$errorAlert = '

			<div class="alert alert-danger alert-dismissible" role="alert">
				<strong>Error!</strong> Oops.. Something went wrong while installing '.$masterName.'.
			</div>
		';
	}
	else{

		$error		= false;
		$errorAlert = '

			<div class="alert alert-success alert-dismissible" role="alert">
				<p><strong>Success!</strong> Installation complete.</p>
				<p><small>Remove installation folder /sas-system/install</small></p>
			</div>
		';
	}

	$response = array(

		'error' 		=> $error,
		'errorAlert' 	=> $errorAlert,
		'adminName' 	=> $adminName
	);
}

echo json_encode($response);
?>
