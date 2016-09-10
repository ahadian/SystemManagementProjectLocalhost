<?php
include("helper.php");
if(isset($_GET['act'])){
	if($_GET['act'] == "do_backup"){
		$backup = do_backup(decrypt($_GET['project_key']));
		echo "Backup success with name file ".$backup;
	}
}
?>