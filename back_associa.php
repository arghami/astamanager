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

if ($operation=="assegna") {

	//effettuo i controlli del caso

	//1: la squadra non deve essere piena in quel ruolo
	$data = $archivio->rosa($_GET['id_squadra']);
	$pars = $archivio->getFinanze($_GET['id_squadra']);

	//ruolo del giocatore
	$ruolo = $_GET['ruolo'];
	if ($ruolo=="") {
		$ruolo = $archivio->getRuolo($_GET['id_giocatore']);
	}
	//prelevo lo stato attuale del ruolo di quella squadra
	$rr = getParzialeRuolo ($data, $ruolo, $pars[strtolower(substr($ruolo, 0, -1))."i"]);
	if ($rr[1]>0 && $rr[0]==$rr[1]){
		die ("ERR: Ruolo completo");
	}

	//2: controllo che i crediti non eccedano il maxbet
	if ($_GET['crediti']>$pars['spendibili']){
		die ("ERR: Crediti non sufficienti");
	}

	//se ho superato i controlli, posso assegnare il giocatore al team
	$archivio->assegnaGiocatore($_GET['id_squadra'],$_GET['id_giocatore'],$_GET['crediti'],$_GET['anni_contratto'],$_GET['primavera'],$_GET['prestito'],$_GET['ruolo'] );
	echo "Inserimento OK";
}
if ($operation=="rimuovi") {
	//in questo caso devo togliere il giocatore dal team
	$archivio->rimuoveGiocatore($_GET['id_squadra'],$_GET['id_giocatore']);
	echo "Rimozione OK";
}

?>