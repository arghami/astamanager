<?php

/**
 * Questa pagina php inizializza il database, crea le tabelle e carica sul db la lista dei giocatori.
 *
 * @version $Id$
 * @copyright 2009
 */

require_once("core_main/base.class.php");


$base = new Base();

	$truncate = "TRUNCATE TABLE parametri";
	$base->doQuery($truncate);

	$pars = array("budget", "portieri", "difensori", "centrocampisti", "attaccanti", "costozero", "primavera");
	foreach ($pars as $key){
		$value = $_GET[$key];
		$insert = "INSERT INTO parametri
				values ('$key', '$value')";
		$base->doQuery($insert);
	}

echo "Caricamento completato.";

?>