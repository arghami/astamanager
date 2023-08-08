var Backend = {
	init: function() {
		//listener sulla ricerca
		var ricercaform = document.getElementById('ricercaform');
		Core.addEventListener(ricercaform, 'submit', Backend.ricerca);

		//listener sui risultati della ricerca
		var listarisultati = document.getElementById('risultatiricerca').getElementsByTagName('tr');
		for (var i=0; i<listarisultati.length; i++){
			Core.addEventListener(listarisultati[i], 'mouseover', Backend.evidenziaRiga);
			Core.addEventListener(listarisultati[i], 'click', Backend.mettiAllAsta);
		}

		//listener sulle squadre (select)
		//var listasquadre = document.getElementById('listasquadreselect').getElementsByTagName('option');
		//for (var i=0; i<listasquadre.length; i++){
		//	Core.addEventListener(listasquadre[i], 'click', Backend.team);
		//}

		//listener sulle squadre (popup)
		var listasquadre = document.getElementById('listasquadre').getElementsByTagName('li');
		for (var i=0; i<listasquadre.length; i++){
			Core.addEventListener(listasquadre[i], 'click', Backend.team);
		}

		//listener apertura/chiusura div sovrapposto
		var openbutton = document.getElementById('openbutton');
		Core.addEventListener(openbutton, 'click', Backend.opendiv);

		//listener chiusura div sovrapposto
		var closediv = document.getElementById('closediv');
		Core.addEventListener(closediv, 'click', Backend.closediv);

		//listener sull'assegnazione
		var assegnaButton = document.getElementById('assegna');
		Core.addEventListener(assegnaButton, 'click', Backend.assegna);

		Backend.loadConfig();

		//carico la rosa della squadra 1
		Backend.team(1);
	},

	popola: function() {
		window.open("start.html","popup","location=1,status=1,scrollbars=1,width=600,height=400");
	},

	esporta: function() {
		window.open("esporta.php","popup","location=1,status=1,scrollbars=1,width=600,height=400");
	},

	opendiv: function(event) {
		var listasquadrediv = document.getElementById("listasquadrediv");
		if (listasquadrediv.style.display=="none") {
			if (listasquadrediv.style.top=="") {
				listasquadrediv.style.top=event.clientY + document.body.scrollTop  - document.body.clientTop+"px";
				listasquadrediv.style.left=event.clientX + document.body.scrollLeft - document.body.clientLeft+"px";
			}
			listasquadrediv.style.display="";
		}
		else {
			listasquadrediv.style.display="none";
		}
	},

	closediv: function() {
		var listasquadrediv = document.getElementById("listasquadrediv");
		listasquadrediv.style.display="none";
	},

	//questa funzione viene chiamata quando clicco sul tasto "salva configurazione"
	saveConfig: function(event) {
		var link = "back_saveconfig.php";
		link += "?portieri="+document.getElementById('portieri').value;
		link += "&difensori="+document.getElementById('difensori').value;
		link += "&centrocampisti="+document.getElementById('centrocampisti').value;
		link += "&attaccanti="+document.getElementById('attaccanti').value;
		link += "&costozero="+document.getElementById('costozero').value;
		link += "&budget="+document.getElementById('budget').value;
		link += "&primavera="+document.getElementById('primavera').value;
		var requester = AjaxRequester.getRequester();
		if (requester != null){

				// apre la connessione
			requester.open("GET", link+"&random="+Math.random(), true);
				// controlla lo stato
			requester.onreadystatechange = function()
			{
				if (requester.readyState == 4){
					if (requester.status == 200 || requester.status == 304){
							// prendo il risultato della chiamata Ajax e processo l'XML
						alert ("configurazione aggiornata");
						Backend.loadConfig();
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

	//questa funzione viene chiamata per popolare il box di configurazione
	loadConfig: function(event) {
		var requester = AjaxRequester.getRequester();
		if (requester != null){

				// apre la connessione
			requester.open("GET", "back_getconfig.php"+"?random="+Math.random(), true);
				// controlla lo stato
			requester.onreadystatechange = function()
			{
				if (requester.readyState == 4){
					if (requester.status == 200 || requester.status == 304){
							// prendo il risultato della chiamata Ajax e processo l'XML
						document.getElementById('prebeck').innerHTML = requester.responseText;
							//listener sulla configurazione
						var configButton = document.getElementById('salva_config');
						Core.addEventListener(configButton, 'click', Backend.saveConfig);

						//listener sul tasto popola
						var popolaButton = document.getElementById('popola');
						Core.addEventListener(popolaButton, 'click', Backend.popola);
						//listener sul tasto esporta
						var esportaButton = document.getElementById('esporta');
						Core.addEventListener(esportaButton, 'click', Backend.esporta);
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

	//questa funzione viene chiamata all'atto della submit
	ricerca: function(event) {
		Core.preventDefault(event);
		var giocatore = document.getElementById('giocatore').value;
		var ruolo = document.getElementById('ruolo_ricerca').options[document.getElementById('ruolo_ricerca').selectedIndex].value;
		var requester = AjaxRequester.getRequester();
		if (requester != null){

				// apre la connessione
			requester.open("GET", "back_ricerca.php?giocatore="+giocatore+"&ruolo="+ruolo+"&random="+Math.random(), true);
				// controlla lo stato
			requester.onreadystatechange = function()
			{
				if (requester.readyState == 4){
					if (requester.status == 200 || requester.status == 304){
							// prendo il risultato della chiamata Ajax e processo l'XML
						Backend.popolaRisultatiGiocatori(requester.responseText);
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

	//chiamata da "ricerca", si occupa di inserire l'HTML di risposta nel div della pagina
	popolaRisultatiGiocatori: function(tabella) {
		div = document.getElementById('risultatiricerca');
		div.innerHTML = tabella;

		//listener sui risultati della ricerca
		var listarisultati = document.getElementById('risultatiricerca').getElementsByTagName('tr');
		for (var i=1; i<listarisultati.length; i++){
			Core.addEventListener(listarisultati[i], 'mouseover', Backend.evidenziaRiga);
			Core.addEventListener(listarisultati[i], 'mouseout', Backend.deevidenziaRiga);
			Core.addEventListener(listarisultati[i], 'click', Backend.mettiAllAsta);
		}
	},

	//viene chiamata quando si clicca su un nome di team, restituisce la rosa
	team: function(ident) {
		var listasquadre = document.getElementById('listasquadre').getElementsByTagName('li');
		for (var i=0; i<listasquadre.length; i++){
			Core.removeClass(listasquadre[i], 'selected');
		}
		var idTeam = this.id;

		var nomeTeam = this.innerHTML;
		if (ident!=null && parseInt(ident)>0) {
			idTeam = ident;
			nomeTeam = document.getElementById(ident).innerHTML;
		}
		//allineo la select
		document.getElementById('listasquadreselect').selectedIndex=idTeam-1;

		Core.addClass(this, 'selected');
		var requester = AjaxRequester.getRequester();
		if (requester != null){

				// apre la connessione
			requester.open("GET", "back_rosa.php?id_squadra="+idTeam+"&random="+Math.random(), true);
				// controlla lo stato
			requester.onreadystatechange = function()
			{
				if (requester.readyState == 4){
					if (requester.status == 200 || requester.status == 304){
							// prendo il risultato della chiamata Ajax e processo l'XML
						Backend.popolaRisultatiRosa("<span class='rosa'>"+nomeTeam+"</span>"+requester.responseText);
								//listener sulla rimozione

						var dels = Core.getElementsByClass('del');
						for (var i=0; i<dels.length; i++){
							Core.addEventListener(dels[i], 'click', Backend.rimuovi);
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

	//chiamata da "team", si occupa di inserire l'HTML di risposta nel div della pagina
	popolaRisultatiRosa: function(tabella) {
		div = document.getElementById('riquadrosquadra');
		div.innerHTML = tabella;
	},

	//chiamata dall'onmouseover su una riga di risultato di ricerca
	evidenziaRiga: function() {
		Core.addClass(this, 'risalto');
	},

	//chiamata dall'onmouseout su una riga di risultato di ricerca
	deevidenziaRiga: function() {
		Core.removeClass(this, 'risalto');
	},

	//chiamata dal click sul pulsante di messa all'asta
	mettiAllAsta: function() {
		var idGiocatore = this.id;
		var riga = this;
		var idSquadra = 0;
		var requester = AjaxRequester.getRequester();
		if (requester != null){

				// apre la connessione
			requester.open("GET", "back_chiamata.php?op=insert&id_giocatore="+idGiocatore+"&id_squadra="+idSquadra+"&random="+Math.random(), true);
				// controlla lo stato
			requester.onreadystatechange = function()
			{
				if (requester.readyState == 4){
					if (requester.status == 200 || requester.status == 304){
							// prendo il risultato della chiamata Ajax e processo l'XML
						Backend.popolaMettiAllAsta(requester.responseText, riga);
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

	//chiamata da "mettiAllAsta", si occupa di inserire l'HTML di risposta nel div della pagina
	popolaMettiAllAsta: function(par, riga) {
		if (par=="Inserimento OK") {
			div = document.getElementById('giocatoreAllAsta');
			div.innerHTML = "";

			var table = "<table class=\"listagiocatori\">";

			var row = "<tr class=\"G2A\" id=\""+riga.id+"\">";
			var tdFigli = riga.getElementsByTagName("td");
			for (i=0; i<tdFigli.length; i++){
				row += "<td class=\"G2A\">"+tdFigli[i].innerHTML+"</td>";
			}
			row += "</tr>";

			table += row + "</table>";

			div.innerHTML = table;

			//var divRis = document.getElementById('risultatiricerca');
			//divRis.innerHTML = "";
		}
	},

	//chiamata dal click sul pulsante di assegnazione, assegna un giocatore alla sua squadra
	assegna: function() {
		var giocAllAsta = document.getElementById('giocatoreAllAsta').getElementsByTagName('tr');
		if (giocAllAsta.length==0) {
			alert("Nessun giocatore all'asta");
			return;
		}

		idGiocatore = giocAllAsta[0].id;
		idSquadra = document.getElementById("id_team_sel").value;;
		var crediti = document.getElementById('crediti').value;
		var anni_contratto = document.getElementById('anni_contratto').value;
		var prestito = document.getElementById('flag_prestito').checked?1:0;
		var primavera = document.getElementById('flag_primavera').checked?1:0;
		var ruolo = document.getElementById('ruolo').options[document.getElementById('ruolo').selectedIndex].value;

		var requester = AjaxRequester.getRequester();
		if (requester != null){

				// apre la connessione
			requester.open("GET", "back_associa.php?op=assegna&id_squadra="+idSquadra+"&id_giocatore="+idGiocatore+"&crediti="+crediti+"&anni_contratto="+anni_contratto+"&prestito="+prestito+"&primavera="+primavera+"&ruolo="+ruolo+"&random="+Math.random(), true);
				// controlla lo stato
			requester.onreadystatechange = function()
			{
				if (requester.readyState == 4){
					if (requester.status == 200 || requester.status == 304){
							// prendo il risultato della chiamata Ajax e processo l'XML

						if (requester.responseText.substring(0,4)=="ERR:") {
							alert(requester.responseText.substring(4));
						}
						else {
							div = document.getElementById('giocatoreAllAsta');
							div.innerHTML = "";

							var divRis = document.getElementById('risultatiricerca');
							divRis.innerHTML = "";
							Backend.team(idSquadra);

							// reimposto i campi di acquisto
							document.getElementById('crediti').value=1;
							document.getElementById('anni_contratto').value=3;
							document.getElementById('flag_prestito').checked=false;
							document.getElementById('flag_primavera').checked=false;
							document.getElementById('ruolo').selectedIndex=0;
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

	//chiamata dal click sul pulsante di rimozione, rimuove un giocatore dalla sua squadra
	rimuovi: function() {
		var idSquadra = this.id.split("_")[0];
		var idGiocatore = this.id.split("_")[1];
		var requester = AjaxRequester.getRequester();
		if (requester != null){

				// apre la connessione
			requester.open("GET", "back_associa.php?op=rimuovi&id_squadra="+idSquadra+"&id_giocatore="+idGiocatore+"&random="+Math.random(), true);
				// controlla lo stato
			requester.onreadystatechange = function()
			{
				if (requester.readyState == 4){
					if (requester.status == 200 || requester.status == 304){
							// prendo il risultato della chiamata Ajax e processo l'XML
						Backend.team(idSquadra);
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

Core.start(Backend);