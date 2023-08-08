<?php

/**
 *Questa pagina mette un giocatore all'asta, o segnala quale giocatore è attualmente all'asta
 *
 * @version $Id$
 * @copyright 2009
 */

require_once("core_archivio/archivio.class.php");
require_once("funzioni.php");

$archivio = new Archivio();

//questo parametro mi dice cosa devo fare
$operation = $_GET['op'];

if ($operation=="insert") {
	//in questo caso devo inserire il giocatore in asta
	$archivio->mettiAllAsta($_GET['id_squadra'], $_GET['id_giocatore']);
	echo "Inserimento OK";
}
if ($operation=="get") {
	//in questo caso devo leggere il giocatore attualmente in asta
	$astaAttuale = $archivio->getAsta();
	//organizzo i risultati della ricerca in una tabella
	$nome = "attuale";
	$header = array('cod_giocatore','nome','ruolo','squadra', 'valore', 'chiamante');
	print_table($nome, $header, $astaAttuale);
}

?>