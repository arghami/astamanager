<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, user-scalable=no">
<title>Archivio</title>
<link href="theme/css/arc.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
<form>
<input name="filter" type="text" value="<?php if (isset($_GET['filter'])) echo $_GET['filter']; ?>" style="width: 20em; height: 2em; font-size: 2em"> <input style="width: 8em; height: 2em; font-size: 2em" type="submit" value="cerca">
</form>
<?php

require_once("core_archivio/archivio.class.php");
require_once("funzioni.php");

$archivio = new Archivio();
$teams = $archivio->getActArchivio();

//$file = file("asta.csv");


echo "<span class=\"rosabox\" style=\"width:95%\">
	<table class=\"squadra\" id=\"sq\" style=\"width:100%;font-size:2em\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
//scorro per ogni nome squadra di serie A
while (list($nomeTeam, $lista) = each($teams)){
	for ($i=0; $i<count($lista); $i++){

    $skip = true;
    if (!isset($_GET['filter']) || $_GET['filter']==''){
      $skip = false;
    }
    else {
      if (stripos($nomeTeam, $_GET['filter']) !== false){
        $skip = false;
      }
      if (stripos($lista[$i][0], $_GET['filter']) !== false){
        $skip = false;
      }
    }
    if ($skip){
      continue;
    }
		$roleclass = "";
		switch (substr($lista[$i][1],0,1)){
			case 'P':
				$roleclass = "por";
				break;

			case 'D':
				$roleclass = "dif";
				break;

			case 'C':
				$roleclass = "cc";
				break;

			case 'A':
				$roleclass = "att";
				break;
		}

		//se il giocatore è stato comprato, gli aggiungo la classe barrato
		$barrato = "";
		if ($lista[$i][2]!="") {
			$barrato = "barrato";
		}
		$class = $i%2?"trp":"trd";
		echo "<tr class=\"$class\">".
		"<td class=\"$roleclass $barrato\">".$nomeTeam."</td>".
		"<td class=\"$roleclass $barrato\">".substr($lista[$i][1],0,1)."</td>".
		"<td class=\"$roleclass $barrato\">".$lista[$i][0]."</td>".
		"<td class=\"$roleclass\">".$lista[$i][2]."</td>".
		"<td class=\"$roleclass\">".$lista[$i][4]."</td>".
		" </tr/>";
	}
}

	echo "</table></span>";
?>
</div>
</body>