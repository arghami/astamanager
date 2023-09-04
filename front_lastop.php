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

$lastIdOp = $archivio->getLastIdOp();

// se lastIdOp ha valore nullo vuol dire che ho popolato ora il DB e non ho chiamato nessuno all'asta 
if ($lastIdOp !== null) {
	//non ha valore nullo e pertanto prendo l'ultima operazione dalla tabella log
    echo $lastIdOp;
} else {
	//ha valore nullo e pertanto restituisco il valore convenzionale zero 
    echo "0";
}

?>
