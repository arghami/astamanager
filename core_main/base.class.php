<?php

/**
 * Questa è la classe di base, che deve essere estesa da tutte le altre.
 * Comprende la gestione del DB (connessione, query e chiusura connessione).
 */
class Base{

	private $conn;

	/**
	 * Costruttore. Si occupa di inizializzare la connessione al database.
	 */
	function __construct(){
		$this->conn = $this->getConnessione();
	}

	/**
	* Metodo per la creazione della connessione. Chiamato dal costruttore.
	*/
	private function getConnessione(){
		if (!file_exists(dirname(__FILE__)."/parametri.php")) {
			return false;
		}
		include (dirname(__FILE__)."/parametri.php");
		$connessione = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

		if ($connessione==false) {
			return false;
		}
		
		return $connessione;
	}

		/**
	* Metodo per la creazione del database.
	*/
	public function createDB(){
		if (!file_exists(dirname(__FILE__)."/parametri.php")) {
			return false;
		}
		include (dirname(__FILE__)."/parametri.php");
		$connessione = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD);
		mysqli_query($connessione, "CREATE DATABASE IF NOT EXISTS ".$DB_NAME);
		$connessione = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

		if ($connessione==false) {
			return false;
		}
	}

	/**
	* Metodo per l'esecuzione di una query.
	*/
	function doQuery($queryString){
		if (!$this->checkConnessione()) {
			return false;
		}
		else {
			$res = mysqli_query($this->conn, $queryString);
			if ($res!==false) {
				return $res;
			}
			else {
				echo "Errore: ".mysqli_error($this->conn);
			}
		}
	}

	/**
	* Metodo per restituire l'ultimo id generato da una insert.
	*/
	protected function get_insert_id(){
		return mysqli_insert_id($this->conn);
	}

	/**
	* Metodo per restituire l'ultimo codice di errore sul database.
	*/
	protected function getError(){
		if (!$this->checkConnessione()) {
			return "Connessione inesistente";
		}
		return mysqli_errno($this->conn).": ".mysqli_error($this->conn);
	}

	/**
	* Metodo per una semplice gestione del log.
	*/
	protected function log($str, $owner){
			$logname = date("Ymd").".log";
			$dir = dirname(__FILE__)."/";
			@mkdir($dir."../logs");
			$f = fopen($dir."../logs/".$logname,"a+");
			fwrite($f, date("H:i")." [$owner] - $str\n");
			fclose($f);
	}

	/**
	* Metodo per il controllo dell'esistenza della connessione.
	*/
	protected function checkConnessione(){
		if ($this->conn) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	* Distruttore. Rilascia la connessione.
	*/
	function __destruct(){
		@mysqli_close($this->conn);
	}
}

?>