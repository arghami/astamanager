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

$data = @$archivio->getListaSquadre();

//genero una lista con tutte le squadre
echo "<span id=\"Testadiv\"><img class=\"pan\" src=\"theme/img/pan.gif\">Seleziona la squadra</span>";
echo "<span id=\"closediv\"><img class=\"close\" src=\"theme/img/close_icon.png\"></span>";
echo "<div class=\"CsQ\">";
echo "<ul id=\"listasquadre\">";
for ($j=0; $j<count($data); $j++){
	echo "<li id=\"{$data[$j]["id_squadra"]}\" class=\"label\">{$data[$j]["nome"]}</li>\n";
	echo $li;
}
echo "</ul>";
echo "</div>";
?>