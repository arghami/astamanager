<?php

/**
 * Questa pagina php inizializza il database, crea le tabelle e carica sul db la lista dei giocatori.
 *
 * @version $Id$
 * @copyright 2009
 */

require_once("core_main/base.class.php");
require_once("core_archivio/archivio.class.php");


$base = new Base();
$base->createDB();

//dopo aver creato il db, devo "rinfrescare" la classe, perchè adesso si collegherà anche al db giusto, mentre prima non lo faceva
$base = new Base();

/*
Creazione delle tabelle
*/

//prima le cancello tutte
$dropTable = "DROP TABLE IF EXISTS log";
$base->doQuery($dropTable);
$dropTable = "DROP TABLE IF EXISTS giocatori_squadra";
$base->doQuery($dropTable);
$dropTable = "DROP TABLE IF EXISTS giocatori";
$base->doQuery($dropTable);
$dropTable = "DROP TABLE IF EXISTS squadre";
$base->doQuery($dropTable);
$dropTable = "DROP TABLE IF EXISTS parametri";
$base->doQuery($dropTable);

//tabella dei giocatori
$tableGiocatori = "CREATE TABLE IF NOT EXISTS giocatori (
cod_giocatore INT NOT NULL ,
valore MEDIUMINT NOT NULL ,
ruolo VARCHAR( 30 ) NOT NULL ,
squadra VARCHAR( 30 ) NOT NULL ,
nome VARCHAR( 80 ) NOT NULL ,
libero BOOL NOT NULL DEFAULT 1,
PRIMARY KEY ( cod_giocatore )
)";

$base->doQuery($tableGiocatori);


//tabella delle squadre
$tableSquadre = "CREATE TABLE IF NOT EXISTS squadre (
id_squadra INT NOT NULL AUTO_INCREMENT,
fondo_cassa INT,
nome VARCHAR ( 100 ) NOT NULL,
nomeabb VARCHAR (10),
allen VARCHAR (100),
PRIMARY KEY ( id_squadra )
)";
$base->doQuery($tableSquadre);


//tabella associazione squadra-giocatori
$tableGiocInTeam = "CREATE TABLE IF NOT EXISTS giocatori_squadra (
id_associazione INT NOT NULL AUTO_INCREMENT,
id_squadra INT NOT NULL,
cod_giocatore INT NOT NULL,
crediti INT NOT NULL,
anni_contratto INT NOT NULL,
primavera BOOL NOT NULL DEFAULT 0,
prestito BOOL NOT NULL DEFAULT 0,
PRIMARY KEY ( id_associazione ),
FOREIGN KEY (id_squadra) REFERENCES squadre(id_squadra),
FOREIGN KEY (cod_giocatore) REFERENCES giocatori(cod_giocatore)
)";
$base->doQuery($tableGiocInTeam);


//tabella storico svolgimento asta
$tableLog = "CREATE TABLE IF NOT EXISTS log (
id_operazione INT NOT NULL AUTO_INCREMENT,
id_squadra INT NULL,
cod_giocatore INT NOT NULL,
descrizione VARCHAR (500),
crediti INT,
anni_contratto INT,
primavera BOOL,
prestito BOOL,
orario TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY ( id_operazione ),
FOREIGN KEY (cod_giocatore) REFERENCES giocatori(cod_giocatore)
)";
$base->doQuery($tableLog);


//tabella parametri
$tableParametri = "CREATE TABLE IF NOT EXISTS parametri (
name VARCHAR (50) NOT NULL,
value VARCHAR (50) NOT NULL,
PRIMARY KEY ( name ))";
$base->doQuery($tableParametri);

$base->doQuery("INSERT INTO parametri(name, value) values ('attaccanti',0), ('budget', 0), ('centrocampisti', 0), ('costozero', 0), ('difensori', 0), ('portieri', 0), ('primavera', 0)");


/*
Finita la fase di creazione delle tabelle, passo al caricamento iniziale dell'archivio
*/
$archivio = $_FILES["file_archivio"]["tmp_name"];

if ($archivio==null) {
	echo ("Nessun file archivio specificato.");
}
else {


	$file = file( $archivio);
	for ($i=0; $i<count($file); $i++){
		$row = addslashes($file[$i]);
		$row = str_replace(array("\n","\r"),array("",""), $row);
		if (count(explode("\t",$row))==6) {
			list (,$cod_giocatore, $valore, $ruolo, $squadra, $nome) = explode("\t",$row);
			//le righe in cui il secondo campo è vuoto o è "Cod" non sono valide
			if ($cod_giocatore!="" && $cod_giocatore!="Cod") {
				//gestione dei giocatori con codice zero: genero un codice progressivo a 8 cifre
				//spero che in FCM non mettano mai codici giocatori a 8 cifre ;)
				if ($cod_giocatore==0) {
					$cod_giocatore = 11111111+$i;
				}

				$insert = "INSERT INTO giocatori VALUES ($cod_giocatore, $valore, '$ruolo', '$squadra', '$nome', 1)";
				$base->doQuery($insert);
			}
		}
	}
}

//a questo punto, popolo i dati di lega
$rose = $_FILES["file_rose"]["tmp_name"];

if ($rose==null) {
	echo ("Nessun file di rose specificato.");
}
else {

	//reimposto tutti i giocatori a libero=1
	$free = "UPDATE giocatori SET libero=1 WHERE 1";
	$base->doQuery($free);

	$file = file($rose);
	$idteam = 0;
	$arch = new Archivio();
	for ($i=0; $i<count($file); $i++){
		$file[$i] = mb_convert_encoding($file[$i], "UTF-8", "ISO-8859-1");
		$cols = explode("\t",$file[$i]);
		if ($cols[0]=="" && $cols[1]=="" && $cols[2]!="") {
			//in questo caso ho un nome team
			$idteam++;
			$nometeam = addslashes($cols[2]);
			$nomesmall = addslashes(substr($cols[2], 0, 5));

			//il nome del presidente sta scritto nella riga successiva
			$colsSuc = explode("\t",$file[++$i]);
			$nomeallen = str_replace("Presidente ", "", addslashes($colsSuc[1]));

			$insert = "INSERT INTO squadre (nome, nomeabb, allen)
					values ('$nometeam', '$nomesmall', '$nomeallen')";
			$base->doQuery($insert);

			//da qui in poi devo scorrere le righe successive per caricare i giocatori
			while ($cols[1]!="Ruolo"){
				//vado avanti finquando non trovo la riga che contiene "Ruolo"
				$cols = explode("\t",addslashes($file[++$i]));
			}

			//arrivato alla riga dei ruoli, devo quindi leggermi tutti i giocatori di quella squadra
			//e assegnarli al team giusto
			while ($cols[1]!=""){
				$cols = explode("\t",$file[++$i]);
				if ($cols[1]=="") {
					break;
				}
				$cod = $arch->getCodByNomeESquadra($cols[2],$cols[3]);
				$arch->assegnaGiocatore($idteam, $cod, intval($cols[5]), intval($cols[4]), 0, 0);
			}

			//fatto questo, devo andare a scorrermi il bilancio per trovare una voce "fondo cassa"
			$cols = explode("\t",$file[++$i]);
			while ($cols[1]!=""){
				$cols = explode("\t",$file[++$i]);
				if ($cols[1]=="") {
					break;
				}
				else if (trim(strtolower($cols[1]))=="fondo cassa") {
					$arch->setFondoCassa($idteam, $cols[5]);
				}
			}
		}
	}
}

echo "Caricamento completato. Puoi chiudere questa finestra.";

echo "<script>window.opener.location.href = \"index.php\"</script>";
?>
