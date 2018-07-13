<?php if (!defined('basePath')) exit('No direct script access allowed');

$rs_migration = $this->db->getAll("select migration_file from ".$this->table_prefix."migrations");
$migrations = array();
foreach ($rs_migration as $key => $value) {
	$migrations[] = $value['migration_file'];
}

$migrate_status = '';
$migrate_error 	= '';
if ($handle = opendir(modulePath.'config/admin/tools/migrations/')){

	while (false !== ($file = readdir($handle))){

		if($file !=='.' and $file !=='..'){
            $xfile = explode('_',str_replace('.txt','',$file));
            $query = file_get_contents(modulePath.'config/admin/tools/migrations/'.$file);
			if(!in_array($xfile[1],$migrations)){
				$splice_query 	= explode(';',$query);
				$get_query 		= array_filter($splice_query, function($value) { return trim($value) != ''; });
				$querys 		= is_array($get_query)?$get_query:array($query);
				$error 			= false;
				foreach ($querys as $key => $value) {
					if(!$this->db->execute($value)){
						$error = true;
					}
				}

				if(!$error){
					$this->db->execute("insert into ".$this->table_prefix."migrations set migration_module='".$xfile[0]."', migration_file ='".$xfile[1]."'");
	                $migrate_status .= '<li class="success">Applying migration '.$xfile[0].' '.$xfile[1].' successfully</li>';
	            }
	            else{
	                $migrate_status .= '<li class="error">Applying migration '.$xfile[0].' '.$xfile[1].' error</li>';
					$migrate_error	.= '<pre>Migration '.$xfile[0].' '.$xfile[1].'</pre>';
	            }
			}
		}
	}
    $migrate_status = '<ul>'.$migrate_status.'</ul>';
	closedir($handle);
}

$response = array(

	'status' 		=> $migrate_status,
	'migrate_error' => $migrate_error,
);

echo json_encode($response);
