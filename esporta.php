<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2009
 */

//header('Content-type: application/zip');
header('Content-Disposition: attachment; filename="export.zip"');

require_once("core_archivio/archivio.class.php");
include("pclzip.lib.php");


$archivio = new Archivio();
$files = $archivio->esporta();

//creo i file delle singole squadre
$filelist = array();
while (list($nomefile, $contenuto) = each($files)){
	$filelist[] = $nomefile.".txt";
	$f = fopen( $nomefile.".txt", 'w+');
	fwrite($f, $contenuto);
	fclose($f);
}

//ora creo lo zip
@unlink("export.zip");
$filename = "export.zip";
$archive = new PclZip($filename);
//Qui vanno aggiunti i files da comprimere
$listOfFilesToCompress=implode(",", $filelist);
//Ora li aggiungo all'archivio
$v_list = $archive->add($listOfFilesToCompress);
if ($v_list == 0) {
	die("Error : ".$archive->errorInfo(true));
}

//rimuovo tutti i file temporanei che ho creato
foreach ($filelist as $nomefile){
	@unlink($nomefile);
}

//e se lo voglio far scaricare

readfile($filename);
@unlink("export.zip");

?>