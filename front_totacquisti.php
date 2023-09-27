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
$cronAcqu = $archivio->getCronAcquisti();
$cnt=1;

echo  "<table id=\"AcqTot\" class='tot_acq' border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		      <tr class=\"intest_acq\">
		        <td colspan=\"4\" >Giocatori Acquistati</td>
		      </tr>";
// controllo se sono stati fatti acquisti
if ($cronAcqu === null) {
    // Il valore restituito è nullo, non sono stati fatti acquisti
	echo  "</table>";
} else {
	for ($i=0; $i<count($cronAcqu); $i++){

	//coloro le righe alterne
			if ($cnt & 1) {
				$alterno = "dispari";
			} else {
				$alterno = "pari";
			}

			$AcqNome = tronca($cronAcqu[$i]['nome'],20);
			
	echo "<tr class=\"".$alterno."\"><td rowspan=\"2\" class=\"num\">".(count($cronAcqu)-$i).".</td>
	        <td class=\"nomeA\">{$AcqNome}</td>
					 <td rowspan=\"2\" class=\"cost\">{$cronAcqu[$i]['crediti']}</td>
	      </tr>
				<tr class=\"".$alterno."\">";
				if (strlen($cronAcqu[$i]['fantasquadra'])>=20) {
				echo "<td class=\"got\">".substr($cronAcqu[$i]['fantasquadra'],0,20)."...</td></tr>";
				} else {
				echo "<td class=\"got\">".$cronAcqu[$i]['fantasquadra']."</td></tr>";
				}
	$cnt++;
}
echo "</table>";
}
?>

