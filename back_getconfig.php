<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2009
 */

require_once("core_archivio/archivio.class.php");

$archivio = new Archivio();
try {
	$pars = $archivio->getFinanze(0);
}
catch (Exception $e) {}
?>

		<table class='configuraA' border="0" cellspacing="0" cellpadding="0" summary="">
		<tr>
		<td colspan='9' ><img class="foto" src="theme/img/int.png"  /></td>
		</tr>
		<tr>
		<td ><input id="popola" name="popola" class="button_config" type="button" value="P O P O L A" /></td>
		<td colspan='8' class='titolo'>Configurazione asta</td>
		</tr>
		<tr>
		<td><input id="esporta" name="esporta" class="button_config" type="button" value="E S P O R T A" /></td>
		<td>Portieri</td><td><input id='portieri' class='num_config' type="text" value="<?php echo $pars['portieri']; ?>"/></td>
		<td>Difensori</td><td><input id='difensori' class='num_config' type="text" value="<?php echo $pars['difensori']; ?>"/></td>
		<td>Centrocampisti</td><td><input id='centrocampisti' class='num_config' type="text" value="<?php echo $pars['centrocampisti']; ?>"/></td>
		<td>Attaccanti</td><td><input id='attaccanti' class='num_config' type="text" value="<?php echo $pars['attaccanti']; ?>"/></td>
		</tr>
		<tr>
		<!-- <td><form class='aprifront' action='frontend.php' target='_blank'><button type="submit"  class="button_config">>> APRI FRONTEND <<</button></form></td>-->
		<td>
		<a href="frontend.php?Fend=f1" target="_blank" ><img  class="button_f1" alt="button-f1 (1K)" src="theme/img/button-f1.gif" height="20" width="70" /></a>
		<a href="frontend.php?Fend=f2" target="_blank" ><img  class="button_f2" alt="button-f1 (1K)" src="theme/img/button-f2.gif" height="20" width="70" /></a>
		</td>

		<td>N. gioc. acquistabili a 0</td><td><input id='costozero' class='num_config' type="text" value="<?php echo $pars['costozero']; ?>"/></td>
		<td>N. primavera acquistabili</td><td><input id='primavera' class='num_config' type="text" value="<?php echo $pars['primavera']; ?>"/></td>
		<td>Budget</td><td><input id='budget' class='num_config' type="text" value="<?php echo $pars['budget']; ?>"/></td>
		<td colspan="2" class="salva"><input id="salva_config" name="salva_config" class="button_config" type="button" value="Salva Configurazione" /></td>
		</tr>
		</table>


