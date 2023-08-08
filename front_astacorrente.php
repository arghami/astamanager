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
$astaAttuale = $archivio->getAsta();

//verifico che la foto sia nella dira
$directory = 'theme/photos/';
$wtlf = strval($astaAttuale['cod_giocatore']);
$ext = '.jpg';
     if( ! file_exists( $directory . $wtlf . $ext) )
     {
	 $photo = 'misterx.jpg';
     } else {
	 $photo = $astaAttuale['cod_giocatore'].$ext;
	 }
	 
	 

echo  "<table class=\"ora\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" summary=\"\">
 <tr>
  <td colspan=\"2\" class=\"intest_Now\">ATTUALMENTE ALL'ASTA</td>
  <td rowspan=\"3\" class=\"fotoG\"><img class=\"foto\" src=\"theme/photos/{$photo}\" /></td>
 </tr>
 <tr>
  <td class=\"nome_Now\">".tronca($astaAttuale['nome'],20)."</td>
  <td class=\"ruoloO\">{$astaAttuale['ruolo']}</td>
 </tr>
 <tr>
  <td colspan=\"2\" class=\"squa_Now\">{$astaAttuale['squadra']}</td>
 </tr>
</table>";

?>