var flagFermi;
var fermiMatrice;
var punts = Array();

//configurazione effetto
var speed = 4; //velocità globale: valori tipici 1-5
var stopTime = 5000; // tempo in millisecondi di stop

var Vertical = {

	init: function() {

		//ferma eventuali scroll precedenti
		for (var i=0; i<punts.length; i++){
			clearInterval(punts[i]);
		}

		punts = Array();

		//adda lo scroll a tutti gli elementi di classe scroll
		var scrolli = Core.getElementsByClass('scroll');

		flagFermi = Array();
		fermiMatrice = Array();
		for (var i=0; i<scrolli.length; i++){
			var div = scrolli[i].getElementsByTagName('div')[0];

			//calcola i punti di stop
			flagFermo=false;
			var stopdiv = Core.getChildsByClass(scrolli[i],'stop');
			fermiMatrice[i] = Array();
			for (var j=0; j<stopdiv.length; j++){
				//prendo la posizione del div
				fermiMatrice[i][j]=stopdiv[j].offsetTop;
			}

			div.style.top = /*scrolli[i].offsetHeight*/40+"px";

			Vertical.scrolla(scrolli[i], speed, i);
		}

	},

	scrolla: function(elemento, speed, x){
		var div = elemento.getElementsByTagName('div')[0];
		punts[x] = setInterval( function(){Vertical.sposta(div, x);} , 100/speed);
	},

	sposta: function(div, x) {
		var fermi = fermiMatrice[x];
		if (flagFermi[x]) {
			return;
		}

		//calcolo l'entità dello spostamento in base al fermo più vicino
		var minDist = 10000;
		var spost = 1;

		var actTop = parseInt(div.style.top);
		for (var i=0; i<fermi.length; i++){
			if (fermi[i]+actTop<minDist) {
				minDist = Math.abs(fermi[i]+actTop);
				spost = Math.max(1,Math.min(5,parseInt(Math.sqrt(minDist))));
			}
		}

		div.style.top = (actTop-spost)+"px";
		//se sto in corrispondenza di un fermo, devo avviare la gestione del fermo
		if (minDist==0) {
			flagFermi[x] = true;
			setTimeout( function(){flagFermi[x]=false;} , stopTime);
		}
		if (-actTop>=parseInt(div.offsetHeight)) {
			div.style.top = /*div.parentNode.offsetHeight*/40+"px";
		}
	}
}

Core.start(Vertical);