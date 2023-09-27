<?php

/**
 *Questa pagina preleva il giocatore attualmente all'asta
 *
 * @version $Id$
 * @copyright 2009
 */

require_once("core_archivio/archivio.class.php");
require_once("funzioni.php");

$archivio = new Archivio();

//in questo caso devo leggere il giocatore attualmente in asta
$lastAcquisto = $archivio->getLastAcquisto();


// controllo se è già stato acquistato un giocatore
if ($lastAcquisto === null) {
    // Il valore restituito è nullo, non è stato acquistato alcun giocatore
	echo "<table class=\"lastA\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" summary=\"\">
		  <tr>
				<td  rowspan=\"3\" class=\"fotoS\">&nbsp;</td>
				<td colspan=\"4\" class=\"intest_ultimo\">Ultimo acquisto</td>
		  </tr>
				<tr>
		  <td rowspan=\"2\" class=\"ruolo\">&nbsp;</td>
		  <td class=\"nome\">Ancora nessun acquisto</td>
		  <td class=\"nome\">&nbsp;</td>
		  <td rowspan=\"2\" class=\"cred\">&nbsp;</td>
		  </tr>
				<tr>
				<td colspan=\"2\" class=\"fteam\">&nbsp;</td>
		  </tr>
		  </table>";
} else {
	
	//verifico che la foto sia nella dira
	$directory = 'theme/photos/';
	$wtlf = strval($lastAcquisto['cod_giocatore']);
	$ext = '.jpg';
		 if( ! file_exists( $directory . $wtlf . $ext) )
		 {
		 $photo = 'misterx.jpg';
		 } else {
		 $photo = $lastAcquisto['cod_giocatore'].$ext;
		 }

		 
	echo "<table class=\"lastA\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" summary=\"\">
		  <tr>
				<td  rowspan=\"3\" class=\"fotoS\"><img class=\"small\" src=\"theme/photos/{$photo}\" /></td>
				<td colspan=\"4\" class=\"intest_ultimo\">Ultimo acquisto</td>
		  </tr>
				<tr>
		  <td rowspan=\"2\" class=\"ruolo\">".substr($lastAcquisto['ruolo'],0,1)."</td>
		  <td class=\"nome\">{$lastAcquisto['nome']}</td>
		  <td class=\"nome\">".strtoupper(substr($lastAcquisto['squadra'],0,3))."</td>
		  <td rowspan=\"2\" class=\"cred\">{$lastAcquisto['crediti']} cr</td>
		  </tr>
				<tr>
				<td colspan=\"2\" class=\"fteam\">{$lastAcquisto['fantasquadra']}</td>
		  </tr>
		  </table>";
}
?>
