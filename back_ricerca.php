<?php

/**
 *Questa pagina effettua una ricerca nell'archivio dei giocatori, in base al parametro passato
 *
 * @version $Id$
 * @copyright 2009
 */

require_once("core_archivio/archivio.class.php");
require_once("funzioni.php");

$archivio = new Archivio();

//il nome del giocatore mi viene inviato via GET

$data = $archivio->cercaGiocatore($_GET['giocatore'], 1, $_GET['ruolo']);

//organizzo i risultati della ricerca in una tabella
$nome = "listagiocatori";
$header = array('R', 'Nome', 'Squadra','FM');
$cnt=1;


	echo "<table name=\"$nome\" class=\"$nome\" cellpadding=\"0\" cellspacing=\"0\"><tr>";
	for ($i=0; $i<count($header); $i++){
		echo "<th class='titolo' id=\"c$i\">$header[$i]</th>";
	}
	echo "</tr>";

	for ($j=0; $j<count($data); $j++){
			//coloro le righe alterne
			if ($cnt & 1) {
				$alterno = "dispari";
			} else {
				$alterno = "pari";
			}
	     echo "<tr class=\"".$alterno."\" id=\"{$data[$j][0]}\">\n";
		//echo "<tr class=\"label\" id=\"{$data[$j][0]}\">\n";
		for ($i=1; $i<=count($header); $i++){
			if ($i==1) {
				//tronco il ruolo a 1 solo carattere
				$data[$j][$i] = substr($data[$j][$i], 0,1);
			}
			echo "<td class=\"col".strval($i)."\" nowrap=\"nowrap\">".$data[$j][$i]."</td>\n";
					}
		echo "</tr>\n";
		$cnt++;
	}
	echo "</table>\n";

?>