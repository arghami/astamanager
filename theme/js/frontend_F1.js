var lastOp = 0;

var Frontend = {
	init: function() {
		Frontend.checkUpdate();
		setInterval(function(){Frontend.checkUpdate()},1000);

		/*setInterval("Frontend.getGiocatoreAllAsta()",1000);
		setInterval("Frontend.getUltimoAcquisto()",1000);
		setInterval("Frontend.getTopPagati()",1000);
		setInterval("Frontend.getTeams()",1000);*/

	},

	//controlla se è necessario effettuare un refresh della parte delle rose
	checkUpdate: function(){
		var requester = AjaxRequester.getRequester();
		if (requester != null){

				// apre la connessione
			requester.open("GET", "front_lastop.php"+"?random="+Math.random(), true);
				// controlla lo stato
			requester.onreadystatechange = function()
			{
				if (requester.readyState == 4){
					if (requester.status == 200 || requester.status == 304){
						if (parseInt(requester.responseText)>lastOp) {
							lastOp = parseInt(requester.responseText);
							Frontend.getGiocatoreAllAsta();
							Frontend.getUltimoAcquisto();
							Frontend.getTopPagati();
							Frontend.getCronAcquisti();
							Frontend.getTeams();
							Frontend.getSquadre();
						}
					}else{
						alert ("Errore - (" + requester.status + ")");
					}
				}
			}
			requester.send(null);

		}else{
			alert("Impossibile istanziare Ajax Request");
		}
	},

	getGiocatoreAllAsta: function(){
		var div = document.getElementById('now');
		var requester = AjaxRequester.getRequester();
		if (requester != null){

				// apre la connessione
			requester.open("GET", "front_astacorrente.php"+"?random="+Math.random(), true);
				// controlla lo stato
			requester.onreadystatechange = function()
			{
				if (requester.readyState == 4){
					if (requester.status == 200 || requester.status == 304){
						div.innerHTML = requester.responseText;
					}else{
						alert ("Errore - (" + requester.status + ")");
					}
				}
			}
			requester.send(null);

		}else{
			alert("Impossibile istanziare Ajax Request");
		}
	},

	getUltimoAcquisto: function(){
		var div = document.getElementById('prec');
		var requester = AjaxRequester.getRequester();
		if (requester != null){

				// apre la connessione
			requester.open("GET", "front_ultimoacquisto.php"+"?random="+Math.random(), true);
				// controlla lo stato
			requester.onreadystatechange = function()
			{
				if (requester.readyState == 4){
					if (requester.status == 200 || requester.status == 304){
						div.innerHTML = requester.responseText;
					}else{
						alert ("Errore - (" + requester.status + ")");
					}
				}
			}
			requester.send(null);

		}else{
			alert("Impossibile istanziare Ajax Request");
		}
	},

	getTopPagati: function(){
		var div = document.getElementById('costosi');
		var requester = AjaxRequester.getRequester();
		if (requester != null){

				// apre la connessione
			requester.open("GET", "front_toppagati.php"+"?random="+Math.random(), true);
				// controlla lo stato
			requester.onreadystatechange = function()
			{
				if (requester.readyState == 4){
					if (requester.status == 200 || requester.status == 304){
						div.innerHTML = requester.responseText;
					}else{
						alert ("Errore - (" + requester.status + ")");
					}
				}
			}
			requester.send(null);

		}else{
			alert("Impossibile istanziare Ajax Request");
		}
	},
	
	//Aggiunta PUFFIN
		getCronAcquisti: function(){
		var div = document.getElementById('acquistiTot');
		var requester = AjaxRequester.getRequester();
		if (requester != null){

				// apre la connessione
			requester.open("GET", "front_totacquisti.php"+"?random="+Math.random(), true);
				// controlla lo stato
			requester.onreadystatechange = function()
			{
				if (requester.readyState == 4){
					if (requester.status == 200 || requester.status == 304){
						div.innerHTML = requester.responseText;
					}else{
						alert ("Errore - (" + requester.status + ")");
					}
				}
			}
			requester.send(null);

		}else{
			alert("Impossibile istanziare Ajax Request");
		}
	},
	
	
	getSquadre: function(){
		var div = document.getElementById('left');
		var requester = AjaxRequester.getRequester();
		if (requester != null){

				// apre la connessione
			requester.open("GET", "front_rose.php"+"?random="+Math.random(), true);
				// controlla lo stato
			requester.onreadystatechange = function()
			{
				if (requester.readyState == 4){
					if (requester.status == 200 || requester.status == 304){
						div.innerHTML = requester.responseText;
						Vertical.init();
						
						//$(function() {
						//$(".newsticker-jcarousellite").jCarouselLite({
						//vertical: true,
						//hoverPause:true,
						//visible: 1,
						//auto:3500,
						//speed:1800
						//});
						//});
					
					}else{
						alert ("Errore - (" + requester.status + ")");
					}
				}
			}
			requester.send(null);

		}else{
			alert("Impossibile istanziare Ajax Request");
		}
	},
	//fine aggiunta PUFFIN
	
	
	getTeams: function(){
		var div = document.getElementById('riepilogo');
		var requester = AjaxRequester.getRequester();
		if (requester != null){

				// apre la connessione
			requester.open("GET", "front_squadre.php"+"?random="+Math.random(), true);
				// controlla lo stato
			requester.onreadystatechange = function()
			{
				if (requester.readyState == 4){
					if (requester.status == 200 || requester.status == 304){
						div.innerHTML = requester.responseText;
						Vertical.init();
						
						//alert(document.getElementById('center').offsetHeight );
						var sx = document.getElementById('left');
						var ce = document.getElementById('center');
						var dx = document.getElementById('right');

						sx.style.height = (0.7*ce.offsetHeight) + "px";
						dx.style.height = (0.3*ce.offsetHeight)  + "px";

					//var SquA = document.getElementById('newsticker-demo');
					//SquA.style.height = (0.95*sx.offsetHeight) + "px";
					//alert(SquA.offsetHeight);
						
						//var co = document.getElementById('container');
						
						//co.style.position = "absolute";
						//co.style.top = "50%";
						//co.style.left = "50%";
						//co.style.marginLeft = "-" + (co.offsetWidth/2) + "px";
						//co.style.marginTop = "-" + (co.offsetHeight/2) + "px";
						//co.style.marginLeft = "-" + (co.offsetWidth/2) + "px";
						
						//co.style.marginRight = "0px";
						//co.style.marginBottom = "0px";
						//width: 800px;
						//height: 582px;
						//position:absolute;top:50%;left:50%;
						//margin:-291px 0 0 -400px;
						
						
						
					}else{
						alert ("Errore - (" + requester.status + ")");
					}
				}
			}
			requester.send(null);

		}else{
			alert("Impossibile istanziare Ajax Request");
		}
	}
}

Core.start(Frontend);
