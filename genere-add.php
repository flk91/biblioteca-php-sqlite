<?php

require_once("connessione.php");
require_once("funzioni.php");

$dati_validi = true;
$esito = false;
$errore = "";

if(isset($_POST) && count($_POST) > 0) {

	$genere = [
		'idg' => $_POST['idg'],
		'genere' => $_POST['genere']
	];

	if(empty($genere['idg'])) {
		$dati_validi = false;
		$errore .= "ID genere obbligatorio<br />";
	}

	if(empty($genere['genere'])) {
		$dati_validi = false;
		$errore .= "Nome genere obbligatorio<br />";
	}

	if(genere_esiste($genere['idg'])) {
		$dati_validi = false;
		$errore .= "Identificativo genere già presente in anagrafica<br />";
	}
	
	if($dati_validi) {
		$str_query = "INSERT INTO generi (idg, genere) VALUES (:idg, :genere)";
		$comando = $dbconn->prepare($str_query);
		$esito = $comando->execute($genere);

	}
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
	<meta charset="UTF-8">
	<title>Biblioteca :: Inserisci genere</title>
	<link rel="stylesheet" href="biblio.css">
</head>
<body>
	<div class="main">
		<h1>Aggiungi genere letterario</h1>

		<p><a href="generi.php" class="button">Torna all'elenco dei generi</a></p>

		<?php 
		if(strlen($errore) > 0) {
			echo "<p class=\"messaggio-errore\">$errore</p>";
		}
		?>

		<?php 
		if($esito == true) {
			echo "<p class=\"messaggio-successo\">Inserimento eseguito correttamente</p>";
		}
		?>



		<form method="POST" action="">

			<table>
				<tbody>
					<tr>
						<td><label for="idg">Identificativo</label></td>
						<td><input type="text" name="idg" id="idg" /></td>
					</tr>
					<tr>
						<td><label for="genere">Nome genere</label></td>
						<td><input type="text" name="genere" id="genere" /></td>
					</tr>
					<tr>
						<td></td>
						<td><button type="submit">Salva</button></td>
					</tr>
				</tbody>
			</table>

		</form>
	</div>
</body>
</html>