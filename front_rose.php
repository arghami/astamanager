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
echo "<div id=\"compo_rose\">Composizione Rose</div>";
echo "<div class=\"scroll\">
      <div style=\"position:relative\">";  


while (list($key, $value) = each($teams)){
	//prelevo tutte le informazioni per la squadra
	$data = $archivio->rosa($key);

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
	
		//if (strlen($data[$j][2])>=18) {
		//$Nome = substr($data[$j][2],0,18)."...";
		//} else {
		//$Nome = $data[$j][2];
		//}
		$Nome = tronca($data[$j][2],20);
	
		$listagioc .= substr($data[$j][1], 0,1). " - ".$Nome."<br/>";
		$listacred .= $data[$j][4]. "<br/>";
	}

	//parte la fase di stampa
	echo "<div class=\"stop\"></div><table class=\"rose\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
      <tr>
        <td colspan=\"2\" class=\"intest_rose\">$value</td>
      </tr>	
	  <tr>
        <td class=\"got\">$listagioc</td>
        <td class=\"costR\">$listacred</td>
      </tr></table>
	  <span class=\"spazio\"></span>";
}

echo " </div>";

			

?>
