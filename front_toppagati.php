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
$top = $archivio->getTopPagati();

echo  "<table class=\"top3\" id=\"topacq\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" summary=\"\">
       <tr><td rowspan=\"4\" class=\"riassunto_intest\">I TOP</td>";
for ($i=0; $i<count($top); $i++){
  $num = $i + 1;
	echo "<td class=\"num\">{$num}.</td>
	      <td class=\"got\">".tronca($top[$i]['nome'],20)."</td>
					<td class=\"got\">(".tronca($top[$i]['fantasquadra'],15).")</td>
	        <td class=\"cost\">{$top[$i]['crediti']}</td>";
		 if ($i==count($top)){
	      echo "</tr>";
				}else{
				echo "</tr><tr>";
				}			 
}			 
echo "</table>";			 

?>