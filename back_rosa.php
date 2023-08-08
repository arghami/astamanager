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

$data = $archivio->rosa($_GET['id_squadra']);
$pars = $archivio->getFinanze($_GET['id_squadra']);

//la rosa restituita dalla classe php mi dà solo i giocatori presenti. La devo "fillare"
$newData = array();
//fillo i portieri
copyRuolo ($data, $newData, 'Portiere', $pars["portieri"]);
copyRuolo ($data, $newData, 'Difensore', $pars["difensori"]);
copyRuolo ($data, $newData, 'Centrocampista', $pars["centrocampisti"]);
copyRuolo ($data, $newData, 'Attaccante', $pars["attaccanti"]);

$data = $newData;
//organizzo i risultati della ricerca in una tabella
$nome = "listagiocatori";
$header = array('R','Giocatore','Anni','$','G','P');

	echo "<input type=\"hidden\" id=\"id_team_sel\" value=\"{$_GET['id_squadra']}\"/>";
	echo "<table name=\"$nome\" class=\"squadra\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr class=\"intest\" >
          <th>R</th>
          <th>Giocatore</th>
          <th>Anni</th>
          <th>$</th>
          <th>G</th>
          <th>P</th>
          <th>X</th>
        </tr>";

	for ($j=0; $j<count($data); $j++){
		$class = $j%2?"trp":"trd";
		echo "<tr class=\"$class\">\n";
		$roleclass = "";
		switch (substr($data[$j][1], 0,1)){
			case 'P':
				$roleclass = "por";
				break;

			case 'D':
				$roleclass = "dif";
				break;

			case 'C':
				$roleclass = "cc";
				break;

			case 'A':
				$roleclass = "att";
				break;
		}
		for ($i=1; $i<=count($header); $i++){
			if ($i==1) {
				//tronco il ruolo a 1 solo carattere
				$data[$j][$i] = substr($data[$j][$i], 0,1);
			}
			echo "<td class=\"$roleclass\" nowrap=\"nowrap\">".$data[$j][$i]."</td>\n";
		}
		echo "<td class=\"del\" id=\"{$_GET['id_squadra']}_{$data[$j][0]}\">&nbsp;</td>";
		echo "</tr>\n";
	}
	echo "</table>\n";

	//----- prendo le informazioni sui crediti


?>
      <table class="economy" border="0" cellspacing="1" cellpadding="1">
        <tr class="intest" >
          <td colspan="2">RIEPILOGO ECONOMIA</td>
        </tr>
        <tr class="trd">
          <td>TOTALE SPESO</td>
          <td align="center"><strong><?php echo $pars["spesi"]; ?></strong></td>
        </tr>
        <tr class="trp">
          <td>TOTALE A DISPOSIZIONE</td>
          <td align="center"><strong><?php echo $pars["residui"]; ?></strong></td>
        </tr>
        <tr class="trd">
          <td>MAX BET</td>
          <td align="center"><strong><?php echo $pars["spendibili"]; ?></strong></td>
        </tr>
      </table>