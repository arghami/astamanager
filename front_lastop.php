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

echo $archivio->getLastIdOp();

?>