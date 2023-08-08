<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BackEnd AstaManager v 1.2</title>
<script src="theme/js/ajax.js"></script>
<script src="theme/js/core.js"></script>
<script src="theme/js/backend.js"></script>
<script src="theme/js/movediv.js"></script>
<script src="theme/js/tools.js"></script>
<link href="theme/css/backend.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="listasquadrediv" style="display:none">
	<?php include('back_lista_squadre_popup.php') ?>
</div>
<div id="container">



	<div id="prebeck">

	<!-- Spazio per il preback -->

	</div>

  <div id="left">

  <table class="sx" border="0" cellspacing="5" cellpadding="0" summary="">
		 <!-- ricerca -->
		 <tr>
		  <td rowspan="2" class='ordine'>1.</td>
		  <td class='titolo' colspan="7">Ricerca Giocatore</td>
		  <td class='titolo' colspan="1">Ruolo</td>
		 </tr>
		 <tr>
		 <form id="ricercaform">
		 <td class='tdricerca' colspan="7"> <input id="giocatore" name="giocatore" type="text" class="search" onfocus="delDefaultValue('giocatore')" onblur="checkEmptyValue('giocatore')" /></td>
		 <td class='tdruolo' colspan="1"><select id="ruolo_ricerca" class='num_config' name="ruolo_ricerca">
		  		<option value="">Tutti</option>
		  		<option value="Portiere">P</option>
		  		<option value="Difensore">D</option>
		  		<option value="Centrocampista">C</option>
		  		<option value="Attaccante">A</option>
		  	</select></td>
		 </form>
		 </tr>
		 <!-- giocatore selezionato -->
		 <tr>
		 <td rowspan="2" class='ordine'>2.</td>
		  <td colspan="8" class='titolo'>Risultati possibili</td>
		 </tr>
		 <tr>
		  <td colspan="8"><div id="risultatiricerca">In questo box appariranno i Giocatori corrispondenti alla ricerca</div></td>
		 </tr>
		 <!-- giocatore all'asta -->
		 <tr>
		  <td rowspan="2" class='ordine'>3.</td>
		  <td class='titolo' colspan="7">Giocatore All'Asta</td>
		  <td class='titolo' colspan="1">Costo</td>
		</tr>
		<tr>
		  <td class='G_asta' colspan="7"><div id="giocatoreAllAsta"></div></td>
		  <td class='tcosto' colspan="1"><input id="crediti" class='costo' name="costo" type="text" value="1" maxlength="4" /></td>
		 </tr>
		  <!-- dettagli contratto -->
		<tr>
		<td rowspan="2" class='ordine'>4.</td>
		  <td  colspan="8" class='titolo'>Dettagli Contratto <input id="attiva_Det" type="checkbox" onclick="abilita()" /></td>
		 </tr>
			<tr>
		  <td class='detT'>Anni di Contratto</td>
          <td class='det'><input id="anni_contratto" class='num_config' name="contratto" type="text" value="3" maxlength="4" disabled="true"/></td>
          <td class='detT'>Prestito </td>
          <td class='det'><input id="flag_prestito" class='num_config' name="prestito" type="checkbox" disabled='true'/></td>
          <td class='detT'>Ruolo</td>
          <td class='det'>
		  	<select id="ruolo" class='num_config' name="ruolo"  disabled='true'>
		  		<option value="">inv.</option>
		  		<option value="Portiere">P</option>
		  		<option value="Difensore">D</option>
		  		<option value="Centrocampista">C</option>
		  		<option value="Attaccante">A</option>
		  	</select>
		  </td>
          <td class='detT'>Primavera </td>
          <td class='det'><input id="flag_primavera" class='num_config' name="flag_primavera" type="checkbox"  disabled='true'/></td>
		</tr>



		 <!-- Seleziona e assegna -->
		<tr>
		<td rowspan="2" class='ordine'>5.</td>
		  <td  colspan="5" class='titolo'>Seleziona la squadra <img class='popupico' id="openbutton" src="theme/img/popup_ico.gif"></td>
		  <td  colspan="3" class='titolo'>Assegna</td>
		  </tr>
		  <tr>
		  <td  colspan="5"><?php include('back_lista_squadre.php') ?></td>
		  <td  colspan="3" class='aggiungi'><input id="assegna" name="addtoteam" class="button4" type="button" value="Aggiungi alla Rosa" /></td>
		  </tr>
		</table>



  </div>
    <div id="center"><!--<img src="theme/img/divider.png" alt="Divider" style="float:left;margin-top:5px" />--></div>
 <div id="divisore">&nbsp;</div>
 <div id="right">
    <div id="riquadrosquadra">
    <span class='rosa'>Rosa Fantasquadra #</span>
    <table class='squadra' "cellspacing="0" cellpadding="0">


        <tr class="intest" >
          <td>R</td>
          <td>Giocatore</td>
          <td>Anni</td>
          <td>$</td>
          <td class="del">X</td>
        </tr>
        <tr class="trd">
          <td class="por">P</td>
          <td class="por">&nbsp;</td>
          <td class="por">&nbsp;</td>
          <td class="por">&nbsp;</td>
          <td class="del">X</td>
        </tr>
        <tr class="trp">
          <td class="por">P</td>
          <td class="por">&nbsp;</td>
          <td class="por">&nbsp;</td>
          <td class="por">&nbsp;</td>
          <td class="del">X</td>
        </tr>
        <tr class="trd">
          <td class="por">P</td>
          <td class="por">&nbsp;</td>
          <td class="por">&nbsp;</td>
          <td class="por">&nbsp;</td>
          <td class="del">X</td>
        </tr>
        <tr class="trp">
          <td class="dif">D</td>
          <td class="dif">&nbsp;</td>
          <td class="dif">&nbsp;</td>
          <td class="dif">&nbsp;</td>
          <td class="del">X</td>
        </tr>
        <tr class="trd">
          <td class="dif">D</td>
          <td class="dif">&nbsp;</td>
          <td class="dif">&nbsp;</td>
          <td class="dif">&nbsp;</td>
          <td class="del">X</td>
        </tr>
        <tr class="trp">
          <td class="dif">D</td>
          <td class="dif">&nbsp;</td>
          <td class="dif">&nbsp;</td>
          <td class="dif">&nbsp;</td>
          <td class="del">X</td>
        </tr>
        <tr class="trd">
          <td class="dif">D</td>
          <td class="dif">&nbsp;</td>
          <td class="dif">&nbsp;</td>
          <td class="dif">&nbsp;</td>
          <td class="del">X</td>
        </tr>
        <tr class="trp">
          <td class="dif">D</td>
          <td class="dif">&nbsp;</td>
          <td class="dif">&nbsp;</td>
          <td class="dif">&nbsp;</td>
          <td class="del">X</td>
        </tr>
        <tr class="trd">
          <td class="dif">D</td>
          <td class="dif">&nbsp;</td>
          <td class="dif">&nbsp;</td>
          <td class="dif">&nbsp;</td>
          <td class="del">X</td>
        </tr>
        <tr class="trp">
          <td class="dif">D</td>
          <td class="dif">&nbsp;</td>
          <td class="dif">&nbsp;</td>
          <td class="dif">&nbsp;</td>
          <td class="del">X</td>
        </tr>
        <tr class="trd">
          <td class="dif">D</td>
          <td class="dif">&nbsp;</td>
          <td class="dif">&nbsp;</td>
          <td class="dif">&nbsp;</td>
          <td class="del">X</td>
        </tr>
        <tr class="trp">
          <td class="cc">C</td>
          <td class="cc">&nbsp;</td>
          <td class="cc">&nbsp;</td>
          <td class="cc">&nbsp;</td>
          <td class="del">X</td>
        </tr>
        <tr class="trd">
          <td class="cc">C</td>
          <td class="cc">&nbsp;</td>
          <td class="cc">&nbsp;</td>
          <td class="cc">&nbsp;</td>
          <td class="del">X</td>
        </tr>
        <tr class="trp">
          <td class="cc">C</td>
          <td class="cc">&nbsp;</td>
          <td class="cc">&nbsp;</td>
          <td class="cc">&nbsp;</td>
          <td class="del">X</td>
        </tr>
        <tr class="trd">
          <td class="cc">C</td>
          <td class="cc">&nbsp;</td>
          <td class="cc">&nbsp;</td>
          <td class="cc">&nbsp;</td>
          <td class="del">X</td>
        </tr>
        <tr class="trp">
          <td class="cc">C</td>
          <td class="cc">&nbsp;</td>
          <td class="cc">&nbsp;</td>
          <td class="cc">&nbsp;</td>
          <td class="del">X</td>
        </tr>
        <tr class="trd">
          <td class="cc">C</td>
          <td class="cc">&nbsp;</td>
          <td class="cc">&nbsp;</td>
          <td class="cc">&nbsp;</td>
          <td class="del">X</td>
        </tr>
        <tr class="trp">
          <td class="cc">C</td>
          <td class="cc">&nbsp;</td>
          <td class="cc">&nbsp;</td>
          <td class="cc">&nbsp;</td>
          <td class="del">X</td>
        </tr>
        <tr class="trd">
          <td class="cc">C</td>
          <td class="cc">&nbsp;</td>
          <td class="cc">&nbsp;</td>
          <td class="cc">&nbsp;</td>
          <td class="del">X</td>
        </tr>
        <tr class="trp">
          <td class="att">A</td>
          <td class="att">&nbsp;</td>
          <td class="att">&nbsp;</td>
          <td class="att">&nbsp;</td>
          <td class="del">X</td>
        </tr>
        <tr class="trd">
          <td class="att">A</td>
          <td class="att">&nbsp;</td>
          <td class="att">&nbsp;</td>
          <td class="att">&nbsp;</td>
          <td class="del">X</td>
        </tr>
        <tr class="trp">
          <td class="att">A</td>
          <td class="att">&nbsp;</td>
          <td class="att">&nbsp;</td>
          <td class="att">&nbsp;</td>
          <td class="del">X</td>
        </tr>
        <tr class="trd">
          <td class="att">A</td>
          <td class="att">&nbsp;</td>
          <td class="att">&nbsp;</td>
          <td class="att">&nbsp;</td>
          <td class="del">X</td>
        </tr>
        <tr class="trp">
          <td class="att">A</td>
          <td class="att">&nbsp;</td>
          <td class="att">&nbsp;</td>
          <td class="att">&nbsp;</td>
          <td class="del">X</td>
        </tr>
        <tr class="trd">
          <td class="att">A</td>
          <td class="att">&nbsp;</td>
          <td class="att">&nbsp;</td>
          <td class="att">&nbsp;</td>
          <td class="del">X</td>
        </tr>
      </table>
      <table class=" economy" border="0" cellspacing="0" cellpadding="0">
        <tr class="intest" >
          <td colspan="2">RIEPILOGO ECONOMIA</td>
        </tr>
        <tr class="trd">
          <td>TOTALE SPESO</td>
          <td align="center"><strong>&nbsp;</strong></td>
        </tr>
        <tr class="trp">
          <td>TOTALE A DISPOSIZIONE</td>
          <td align="center"><strong>&nbsp;</strong></td>
        </tr>
      </table>
    </div>
  </div>
  <div id="footer"> &copy; 2009 - arghami, piri, puffin </div>
</div>
</body>
</html>
