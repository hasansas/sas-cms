<?php if (!defined('basePath')) exit('No direct script access allowed');

$error 	   = true;
$module    = '';
$new_file  = '';
$errorMsg  = '';

if(empty($_POST['module'])){
	$errorMsg = 'Module can not be empty';
}
elseif(empty($_POST['query'])){
	$errorMsg = 'Query can not be empty';
}
else{

    $module     = $_POST['module'];
    $file       = date("Ymdhis");
    $new_file   = $_POST['module'].'_'.$file;
    if($migration = fopen(modulePath.'config/admin/tools/migrations/'.$new_file.'.txt', "w")){

        $query = $_POST['query'];

        fwrite($migration, $query);
        fclose($migration);

        $error 	   = false;
        $errorMsg  = 'Migration '.$module.' '.$file.' created.';

        //
        // if($this->db->execute($query)){
        //
        //     fwrite($migration, $query);
        //     fclose($migration);
        //
        //     $error 	   = false;
        // 	$errorMsg  = 'Migration '.$new_file.' created.';
        // }
        // else{
        //     $errorMsg = 'Unable to create migration! Please check your query.';
        //     unlink(modulePath.'config/admin/tools/migrations/'.$new_file.'.txt');
        // }
    }
    else{
        $errorMsg = 'Unable to open file!';
    }
}

$resStatus = !$error?'Success!':'Error!';
$resClass  = !$error?'success':'danger';
$message   = '
    <div class="alert alert-'.$resClass.'">
        <button data-dismiss="alert" class="close" type="button">&times;</button>
        <strong>'.$resStatus.' </strong>'.$errorMsg.'
        <br>
    </div>
';

$response = array(

	'error'		=> $error,
	'module'	=> $module,
	'file'		=> $file,
	'message'	=> $message
);

echo json_encode($response);
