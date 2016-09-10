<?php

function encrypt($pure_string) {
    return strtr(base64_encode($pure_string), '+/=', '-_,');
}

function decrypt($encrypted_string) {
    return base64_decode(strtr($encrypted_string, '-_,', '+/='));
}
function curdate(){
	return date("d-m-Y");
}
function curtime(){
	return date("H;i");
}
function do_backup($name_project){
	
	$rootPath = realpath('../../'.$name_project);

	$zip = new ZipArchive();
	$backup_name = $name_project.'['.curdate().'] ['.curtime().'].zip';
	$zip->open('../backups/'.$backup_name, ZipArchive::CREATE | ZipArchive::OVERWRITE);

	$files = new RecursiveIteratorIterator(
	    new RecursiveDirectoryIterator($rootPath),
	    RecursiveIteratorIterator::LEAVES_ONLY
	);

	foreach ($files as $name => $file)
	{
	    
	    if (!$file->isDir())
	    {
	        
	        $filePath = $file->getRealPath();
	        $relativePath = substr($filePath, strlen($rootPath) + 1);

	        
	        $zip->addFile($filePath, $relativePath);
	    }
	}

	
	$zip->close();

	return $backup_name;
}
?>
