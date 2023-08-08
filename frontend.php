<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AstaManager v 1.2</title>
<script src="theme/js/ajax.js"></script>
<script src="theme/js/core.js"></script>
<script type="text/javascript"> 
Fend = "<?php echo $_GET['Fend']; ?>"; 
if (Fend == "f2") {
//alert(Fend);
document.write("<script src='theme/js/frontend_F2.js' type='text/javascript'></scr" + "ipt>")
document.write("<link href='theme/css/frontend_F2.css' rel='stylesheet' type='text/css' />");
} else  if (Fend == "f1") {
//alert(Fend);
document.write("<script src='theme/js/frontend_F1.js' type='text/javascript'></scr" + "ipt>")
document.write("<link href='theme/css/frontend_F1.css' rel='stylesheet' type='text/css' />");
}
</script>
<script src="theme/js/vertical.js"></script>
</head>
<body>
<!--Apertura Contenitore-->
<div id="container">

<script type="text/javascript"> 
if (Fend == "f2") {
document.write("<div id='left'></div>")
} 
</script>

 <!-- chiudo left -->

	
  <!--Apertura Riepilogo Giocatori-->
<div id='center'> <!-- apro center -->

  	<div id="now">
  		<h3 class="intest">Attualmente all'asta</h3>
  		<div class="datiplayer larg1">
			<span class="nome">&nbsp;</span>
			<span class="ruolo">&nbsp;</span>
		</div>
		<img class="foto" />
    </div>
	
<script type="text/javascript"> 
if (Fend == "f2") {
document.write("<div id=\"frecceDx\"></div> ")
} 
</script>

	
	<div id="prec"><!-- Inserisco l'ultimo acquisto --></div> 


<!--<script type="text/javascript"> 
if (Fend == "f2") {
document.write(" <div id=\"costosi\"></div>")
} 
</script>-->
	
 <div id="costosi"></div>
		
  <!--Apertura Riepilogo Movimenti-->
  <div id="riepilogo"></div>
   <span class="loghi"/><img alt="int (18K)" src="theme/img/int.png" height="40" width="294" /></span>
	

   
 </div> <!-- chiudo center -->
 
 
<div id='right'> <!-- apro right -->
	<div id="acquistiTot"></div> 
</div> <!-- chiudo dx -->	

<script type="text/javascript"> 
if (Fend == "f1") {
document.write("<div id='left'></div>")
} 
</script>


  <!--Credits-->
  <div id="footer"> &copy; 2009 - arghami, piri, puffin </div>
  
   
 <!--Chiusura Contenitore-->
</div>

</body>
</html>
