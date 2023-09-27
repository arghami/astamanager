<?php

require_once (dirname(__FILE__)."/../core_main/base.class.php");

/**
 * Questa classe si occupa della gestione dell'archivio memorizzato nel db.
 */
class Archivio extends Base{

	/**
	 * Costruttore. Richiama il costruttore di Base.
	 */
	function __construct(){
		parent::__construct();
	}

	/**
	 * Ricerca un giocatore nel database
	 */
	function cercaGiocatore($stringaRicerca, $libero, $ruolo){
		$stringa = strtolower($stringaRicerca);
		$stringa = "%".str_replace(" ","%" ,$stringa )."%";

		$queryRicerca = "SELECT * FROM giocatori
						WHERE LOWER(nome) like '$stringa'
						AND libero = 1";

		if ($ruolo!="") {
			$queryRicerca .= " AND ruolo='$ruolo'";
		}
		//ordina la ricerca in ordine alfabetico crescente del nome giocatore
		$queryRicerca .= " ORDER BY nome ASC";
		
		$risultati = parent::doQuery($queryRicerca);

		//organizzo i risultati della ricerca in un array bidimensionale

		$data = array();

		//contatore
		$i=0;
		while($row = mysqli_fetch_array($risultati)){
			$data[$i][] = $row['cod_giocatore'];
			$data[$i][] = $row['ruolo'];
			$data[$i][] = $row['nome'];
			$data[$i][] = $row['squadra'];
			$data[$i][] = $row['valore'];
			$i++;
		}

		return $data;
	}

	/**
	 * Estrae il ruolo di un giocatore
	 */
	function getRuolo($codGiocatore){

		$queryRicerca = "SELECT ruolo FROM giocatori
						WHERE cod_giocatore = $codGiocatore";

		$risultati = parent::doQuery($queryRicerca);

		while($row = mysqli_fetch_array($risultati)){
			$role = $row['ruolo'];
		}

		return $role;
	}

	/**
	 * Inserisce in notifica la messa all'asta di un giocatore
	 */
	function mettiAllAsta($idSquadra, $idGiocatore){

		$queryInsert = "INSERT INTO `log`(id_squadra,cod_giocatore,descrizione)
						VALUES ($idSquadra, $idGiocatore, 'Chiamata')";

		parent::doQuery($queryInsert);
	}

	/**
	 * Imposta il fondo cassa
	 */
	function setFondoCassa($idSquadra, $crediti){

		$queryInsert = "UPDATE squadre
						SET fondo_cassa=$crediti
						WHERE id_squadra = $idSquadra";

		parent::doQuery($queryInsert);
	}

	/**
	 * Vede chi è l'ultimo giocatore chiamato all'asta
	 */
	function getAsta(){

		$query = "SELECT g.cod_giocatore, g.nome, g.ruolo, g.squadra, g.valore
						FROM `log` l, giocatori g
						WHERE l.descrizione = 'Chiamata'
						AND l.cod_giocatore = g.cod_giocatore
						ORDER BY l.orario DESC
						LIMIT 1";

		$res = parent::doQuery($query);
		while($row = mysqli_fetch_array($res)){
			$data = $row;
		}

		return $data;
	}


	/**
	 * Vede l'ultimo giocatore acquistato
	 */
	function getLastAcquisto(){

		$query = "SELECT g.cod_giocatore, g.nome, g.ruolo, g.squadra, g.valore, s.nome fantasquadra, l.crediti
						FROM `log` l, giocatori g, squadre s
						WHERE l.descrizione = 'Acquisto'
						AND l.cod_giocatore = g.cod_giocatore
						AND l.id_squadra = s.id_squadra
						AND (l.id_squadra, l.cod_giocatore) IN (SELECT id_squadra, cod_giocatore FROM giocatori_squadra)
						ORDER BY l.orario DESC, l.id_operazione DESC
						LIMIT 1";

		$res = parent::doQuery($query);
		while($row = mysqli_fetch_array($res)){
			$data = $row;
		}

		return $data;
	}

	/**
	 * Elenca tutti i giocatori acquistati in ordine cronologico inverso
	 */
	function getCronAcquisti(){

		$query = "SELECT g.cod_giocatore, g.nome, g.ruolo, g.squadra, g.valore, s.nome fantasquadra, l.crediti
						FROM `log` l, giocatori g, squadre s
						WHERE l.descrizione = 'Acquisto'
						AND l.cod_giocatore = g.cod_giocatore
						AND l.id_squadra = s.id_squadra
						AND (l.id_squadra, l.cod_giocatore) IN (SELECT id_squadra, cod_giocatore FROM giocatori_squadra)
						ORDER BY l.orario DESC, l.id_operazione DESC";

		$res = parent::doQuery($query);
		$data = array();
		while($row = mysqli_fetch_array($res)){
			$data[] = $row;
		}

		return $data;
	}

	/**
	 * Vede l'ultimo giocatore acquistato
	 */
	function getTopPagati(){

		$query = "SELECT g.nome, g.ruolo, s.nome fantasquadra, gs.crediti
						FROM giocatori g, squadre s, giocatori_squadra gs
						WHERE gs.cod_giocatore = g.cod_giocatore
						AND gs.id_squadra = s.id_squadra
						ORDER BY gs.crediti DESC
						LIMIT 3";
						/**cambia il limit per cambiare il num. di giocatori mostrati*/

		$res = parent::doQuery($query);
		$data = array();
		while($row = mysqli_fetch_array($res)){
			$data[] = $row;
		}

		return $data;
	}

	/**
	 * Assegna un giocatore alla fantasquadra
	 */
	function assegnaGiocatore($idSquadra, $idGiocatore, $crediti, $anniContratto, $primavera, $prestito, $ruolo=""){

		if (($ruolo!="")) {
			//altero il ruolo stesso all'interno dell'archivio
			$queryUpdate = "UPDATE giocatori
						SET ruolo='$ruolo'
						WHERE cod_giocatore = $idGiocatore";
			parent::doQuery($queryUpdate);
		}

		$queryInsert = "INSERT INTO giocatori_squadra(id_squadra,cod_giocatore,crediti,anni_contratto,primavera,prestito )
						VALUES ($idSquadra, $idGiocatore, $crediti, $anniContratto, $primavera, $prestito)";
		parent::doQuery($queryInsert);


		$queryInsert = "INSERT INTO `log`(id_squadra,cod_giocatore,descrizione,crediti,anni_contratto,primavera,prestito )
						VALUES ($idSquadra, $idGiocatore, 'Acquisto', $crediti, $anniContratto, $primavera, $prestito)";
		parent::doQuery($queryInsert);

		$query = "UPDATE giocatori
					SET libero=0
					WHERE cod_giocatore=$idGiocatore";
		parent::doQuery($query);
	}

	/**
	 * Assegna un giocatore alla fantasquadra
	 */
	function getCodByNomeESquadra($nome, $squadra){
		$nome = addslashes($nome);
		$squadra = addslashes($squadra);
		$query = "SELECT cod_giocatore
					FROM giocatori
					WHERE nome = '$nome'
					AND squadra='$squadra'
					LIMIT 1";
		$res = parent::doQuery($query);

		$data = "";
		while($row = mysqli_fetch_array($res)){
			$data = $row[0];
		}

		return $data;
	}

	/**
	 * Rimuove un giocatore alla fantasquadra
	 */
	function rimuoveGiocatore($idSquadra, $idGiocatore){

		$queryRemove = "DELETE FROM giocatori_squadra
						WHERE id_squadra=$idSquadra
						AND cod_giocatore=$idGiocatore";
		parent::doQuery($queryRemove);

		$queryEdit = "UPDATE giocatori
						SET libero=1
						WHERE cod_giocatore=$idGiocatore";
		parent::doQuery($queryEdit);


		$queryInsert = "INSERT INTO `log`(id_squadra,cod_giocatore,descrizione)
						VALUES ($idSquadra, $idGiocatore, 'Annulla Acquisto')";
		parent::doQuery($queryInsert);
	}

	/**
	 * Esporta il tutto in formato FCM compatibile
	 */
	function esporta(){

		$teams = "SELECT id_squadra, nome FROM squadre";
		$res = parent::doQuery($teams);

		$idTeams = array();
		while($row = mysqli_fetch_array($res)){
			$idTeams[] = $row;
		}

		$output = array();
		foreach($idTeams as $sq){
			$giocs = "SELECT g.ruolo, g.nome, gs.crediti, gs.anni_contratto
						FROM giocatori_squadra gs, giocatori g
						WHERE id_squadra = {$sq[0]}
						AND gs.cod_giocatore = g.cod_giocatore";
			$res = parent::doQuery($giocs);
			$teamDescr = "";
			while($row = mysqli_fetch_array($res)){
				$teamDescr .= $row[0]."\t".$row[1]."\t".$row[2]."\t".$row[3]."\r\n";
			}
			$output[$sq[1]] = $teamDescr;
		}

		//esporto la tabella log
		$logs = "SELECT l.id_operazione,
				DATE_FORMAT(l.orario,'%d %b, %T'),
				l.descrizione, g.nome, g.squadra, s.nome, l.crediti
				FROM giocatori g,
				log l left outer join squadre s
				on l.id_squadra = s.id_squadra
				WHERE l.cod_giocatore = g.cod_giocatore
				ORDER BY id_operazione";
		$res = parent::doQuery($logs);
		$line = "";
		while($row = mysqli_fetch_array($res)){
			$line .= $row[0].".\t".$row[1]."\t".$row[2]."\t".$row[3]."(".$row[4].")"."\t".$row[5]."\t".$row[6]."
";
		}
		$output["asta"] = $line;

		return $output;
	}


	/**
	 * Restituisce la rosa di una fantasquadra
	 */
	function rosa($idSquadra){

		$query = "SELECT g.cod_giocatore, g.ruolo, g.nome,
						gs.anni_contratto, gs.crediti, gs.primavera, gs.prestito
						FROM giocatori_squadra gs, giocatori g
						WHERE gs.id_squadra = $idSquadra
						AND gs.cod_giocatore = g.cod_giocatore
						ORDER BY g.ruolo ASC, g.nome";

		$res = parent::doQuery($query);
		$data = array();
		while($row = mysqli_fetch_array($res)){
			$data[] = $row;
		}
		return $data;
	}

	/**
	 * Restituisce la lista delle squadre
	 */
	function getListaSquadre(){

		$query = "SELECT * FROM squadre";

		$res = parent::doQuery($query);
		$data = array();
		while($row = mysqli_fetch_array($res)){
			$data[] = $row;
		}
		return $data;
	}


	/**
	 * Restituisce lo stato della fantasquadra, sottoforma di array.
	 * In dettaglio (i parametri col cancelletto sono relativi alla lega:
	 * - crediti spesi
	 * - crediti residui
	 * # budget iniziale
	 * - massimo spendibile per un giocatore
	 * - portieri acquistati
	 * - difensori acquistati
	 * - centrocampisti acquistati
	 * - attaccanti acquistati
	 * # portieri totali
	 * # difensori totali
	 * # centrocampisti totali
	 * # attaccanti totali
	 */
	function getFinanze($id_squadra){

		//prelevo l'eventuale fondo cassa
		$query = "SELECT fondo_cassa FROM squadre WHERE id_squadra=$id_squadra";
		$res = parent::doQuery($query);

		$fondo_cassa = 0;
		while($row = mysqli_fetch_array($res)){
			$fondo_cassa += $row[0];
		}

		//prelevo i parametri che mi servono
		$query = "SELECT * FROM parametri";
		$res = parent::doQuery($query);

		$budget=0;
		$parametri = array();
		while($row = mysqli_fetch_array($res)){
			$parametri[$row[0]] = $row[1];
			if ($row[0]=='budget') {
				$budget = $row[1];
			}
		}
		$budget += $fondo_cassa;

		//prelevo il numero di giocatori a credito zero presenti
		$query2 = "SELECT COUNT(*) tot FROM giocatori_squadra
					WHERE id_squadra=$id_squadra
					AND crediti=0";

		$cred0 = 0;
		$res2 = parent::doQuery($query2);
		while($row = mysqli_fetch_array($res2)){
			if ($row[0]!=null) {
				$cred0 = $row[0];
			}
		}

		//prelevo il numero di giocatori acquistati in totale
		$query2 = "SELECT COUNT(*) tot FROM giocatori_squadra
					WHERE id_squadra=$id_squadra";

		$totAcq = 0;
		$res2 = parent::doQuery($query2);
		while($row = mysqli_fetch_array($res2)){
			if ($row[0]!=null) {
				$totAcq = $row[0];
			}
		}



		//prelevo i crediti spesi, scartando i giocatori a costo zero
		$query1 = "SELECT SUM(crediti) FROM giocatori_squadra
					WHERE id_squadra=$id_squadra
					AND crediti>0";

		$res = parent::doQuery($query1);

		//ora mi calcolo la situazione crediti
		$crediti = array("spesi"=>0, "spendibili"=>0, "residui"=>$budget);

		//prelevo il numero totale di giocatori da acquistare
		$totRosa = $parametri["portieri"] + $parametri["difensori"] + $parametri["centrocampisti"] + $parametri["attaccanti"];

		//Calcolo il massimo spendibile per un solo giocatore. La formula è:
		// MAXBET = BUDGET - (N°GIOC_DA_ACQUISTARE -1) + (PARZEROACQUISTABILI - PARZEROACQUISTATI)
		$crediti["spendibili"] = $budget-($totRosa-$totAcq-1) + ($parametri["costozero"] - $cred0);

		while($row = mysqli_fetch_array($res)){
			if ($row[0]!=null) {
				//spesi e residui
				$crediti["spesi"] = $row[0];
				$crediti["residui"] = $budget-$row[0];

				//Aggiorno il massimo spendibile per un solo giocatore. La formula è:
				// MAXBET = BUDGETRESIDUO - (N°GIOC_DA_ACQUISTARE -1) + (PARZEROACQUISTABILI - PARZEROACQUISTATI)
				$crediti["spendibili"] = $crediti["residui"]-($totRosa-$totAcq-1) + ($parametri["costozero"] - $cred0);
			}
		}

		//se totRosa è 0 (rose libere), maxbet coincide con il budget residuo
		if ($totRosa==0) {
			$crediti["spendibili"] = $crediti["residui"];
		}

		return array_merge($parametri, $crediti);
	}

	/**
	* Preleva l'id dell'ultima operazione loggata
	*/
	function getLastIdOp(){
		$query = "SELECT max(id_operazione)
						FROM `log` l";

		$res = parent::doQuery($query);
		$data=0;
		while($row = mysqli_fetch_array($res)){
			$data = $row[0];
		}

		return $data;
	}

	/**
	* Preleva l'elenco dei giocatori, segnalando quelli che sono stati venduti e a quanto.
	*/
	function getActArchivio(){
		$query = "SELECT DISTINCT squadra from giocatori
					ORDER BY 1";

		$res = parent::doQuery($query);
		$nomiteam=0;
		while($row = mysqli_fetch_array($res)){
			$teams[] = $row[0];
		}

		$query = "SELECT g.nome, g.ruolo, g.squadra, gs.crediti, g.cod_giocatore, s.nome from
					giocatori g left outer join giocatori_squadra gs
					on g.cod_giocatore = gs.cod_giocatore
					left outer join squadre s
					on gs.id_squadra = s.id_squadra
					ORDER BY 3, 2 DESC, 1";

		$res = parent::doQuery($query);
		$teams=array();
		while($row = mysqli_fetch_array($res)){
			$teams[$row[2]][] = array($row[0],$row[1], $row[3], $row[4], $row[5]);
		}

		return $teams;
	}

	/**
	 * Distruttore. Richiama il distruttore di Base.
	 */
	function __destruct(){
		parent::__destruct();
	}
}

?>
