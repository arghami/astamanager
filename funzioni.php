<?php

/**
 *Funzioni varie
 *
 * @version $Id$
 * @copyright 2009
 */


/**
* Funzione che stampa una tabella
*/
function print_table($nome, $header, $data){
	echo "<table name=\"$nome\" class=\"$nome\"><tr>";
	for ($i=0; $i<count($header); $i++){
		echo "<th id=\"c$i\">$header[$i]</th>";
	}
	echo "</tr>";

	for ($j=0; $j<count($data); $j++){
		echo "<tr>\n";
		for ($i=0; $i<count($header); $i++){
			echo "<td>".$data[$j][$i]."</td>\n";
		}
		echo "</tr>\n";
	}
	echo "</table>\n";
}

function copyRuolo($data, &$newData, $ruolo, $maxRuolo){
	$numGiocInRuolo = 0;
	for ($i=0; $i<count($data); $i++){
		if ($data[$i][1]==$ruolo) {
			$newData[]=$data[$i];
			$numGiocInRuolo++;
		}
	}
	while ($numGiocInRuolo<$maxRuolo) {
		$newData[]=array("",$ruolo,"","","","","");
		$numGiocInRuolo++;
	}
}

function getParzialeRuolo($data, $ruolo, $maxRuolo){
	$numGiocInRuolo = 0;
	for ($i=0; $i<count($data); $i++){
		if ($data[$i][1]==$ruolo) {
			$newData[]=$data[$i];
			$numGiocInRuolo++;
		}
	}
	return array($numGiocInRuolo,$maxRuolo);
}

function tronca($data, $maxLen){
	$output = trim($data);
	if (strlen($output)>$maxLen+4) {
		$output = substr($output,0,$maxLen);
		$output .= "...";
	}
	return $output;
}
?>