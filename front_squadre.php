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

$data = $archivio->getListaSquadre();

//genero una lista con tutte le squadre
$teams = array();
for ($j=0; $j<count($data); $j++){
	$teams[$data[$j]["id_squadra"]] = $data[$j]["nome"];
}

//stampo l'apertura di tabella
?>
    <table id="riassunto" border="0" cellspacing="0" cellpadding="0">
      <tr class="riassunto_intest">
        <td rowspan="2" class='intest_team'>FANTASQUADRA</td>
        <td rowspan="2">$</td>
        <td rowspan="2">Max Bet</td>
        <td colspan="4">Composizione ROSA</td>
        <!-- <td rowspan="2">GIOCATORI Acquistati</td>
        <td rowspan="2">COSTO</td> -->
      </tr>
      <tr class="riassunto_intest">
        <td>P</td>
        <td>D</td>
        <td>C</td>
        <td>A</td>
      </tr>
<?php

while (list($key, $value) = each($teams)){
	//prelevo tutte le informazioni per la squadra
	$data = $archivio->rosa($key);
	$pars = $archivio->getFinanze($key);

	$pp = getParzialeRuolo ($data, 'Portiere', $pars["portieri"]);
	$dd = getParzialeRuolo ($data, 'Difensore', $pars["difensori"]);
	$cc = getParzialeRuolo ($data, 'Centrocampista', $pars["centrocampisti"]);
	$aa = getParzialeRuolo ($data, 'Attaccante', $pars["attaccanti"]);

	//comincio a vedere se devo rendere la riga full
	$trclass = "";
	if ($pp[1]+$dd[1]+$cc[1]+$aa[1]>0 &&
		$pp[0]==$pp[1] &&
		$dd[0]==$dd[1] &&
		$cc[0]==$cc[1] &&
		$aa[0]==$aa[1] ) {
		$trclass = " class=\"full\"";
	}

	//o se devo rendere full qualche cella
	$pfull = "";
	if ($pp[1]>0 && $pp[0]==$pp[1]){
		$pfull = " full";
	}
	$dfull = "";
	if ($dd[1]>0 && $dd[0]==$dd[1]){
		$dfull = " full";
	}
	$cfull = "";
	if ($cc[1]>0 && $cc[0]==$cc[1]){
		$cfull = " full";
	}
	$afull = "";
	if ($aa[1]>0 && $aa[0]==$aa[1]){
		$afull = " full";
	}

	if ($pp[1]+$dd[1]+$cc[1]+$aa[1]==0) {
		$pp[1]=$dd[1]=$cc[1]=$aa[1] = "&#8734";
	}

	//preparo la lista dei giocatori e quella dei crediti
	$listagioc = "";
	$listacred = "";

	//questo blocco mi serve solo per ordinare i giocatori per ruolo
	$newData = array();
	copyRuolo ($data, $newData, 'Portiere', 0);
	copyRuolo ($data, $newData, 'Difensore', 0);
	copyRuolo ($data, $newData, 'Centrocampista', 0);
	copyRuolo ($data, $newData, 'Attaccante', 0);
	$data = $newData;

	//ora preparo il contenuto
	for ($j=0; $j<count($data); $j++){
		$listagioc .= substr($data[$j][1], 0,1). " - ".$data[$j][2]. "<br/>";
		$listacred .= $data[$j][4]. "<br/>";
	}

	//parte la fase di stampa
	echo "<tr $trclass>
        <td class=\"team\">$value</td>
        <td class=\"resources\">&nbsp;{$pars['residui']}&nbsp;</td>
        <td class=\"maxsingle\">&nbsp;{$pars['spendibili']}&nbsp;</td>
		<td class=\"numplayers $pfull\">&nbsp;$pp[0]/$pp[1]&nbsp;</td>
		<td class=\"numplayers $dfull\">&nbsp;$dd[0]/$dd[1]&nbsp;</td>
		<td class=\"numplayers $cfull\">&nbsp;$cc[0]/$cc[1]&nbsp;</td>
		<td class=\"numplayers $afull\">&nbsp;$aa[0]/$aa[1]&nbsp;</td>
		</tr>";
        //<td class=\"got\"><div class=\"scroll\"><div style=\"position:relative\">$listagioc</div></div></td>
        //<td class=\"cost\"><div class=\"scroll\"><div style=\"position:relative\">$listacred</div></div></td>

}

    
?>
  
    </table>
	
