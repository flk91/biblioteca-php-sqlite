<?php
require_once('connessione.php');
require_once('funzioni.php');


//dataset elenco libri
$libri = [];
//dataset elenco autori
$autori = getElencoAutori();
//dataset elenco generi
$generi = getElencoGeneri();

$conteggioTotaleLibri = getConteggioLibri();

//inizializzo le variabili che prendo in input con dati di default
$sort = 'titolo';
$sort_dir = 'ASC';
$filtro_autore = null;
$find = '';

//se ho dati in input...
if(count($_GET)>0) {
	//valorizzo le variabili precedentemente impostate
	$sort = $_GET['sort'];
	$sort_dir = $_GET['sort_dir'];
	$filtro_autore = $_GET['filtro_autore'];
}

//compongo la query
$str_query = "SELECT * FROM LIBRI";

$str_query .= " ORDER BY $sort $sort_dir ";
$comando = $dbconn->prepare($str_query);
$esegui = $comando->execute();

?>

<!DOCTYPE html>
<html lang="it">
<head>
	<meta charset="UTF-8">
	<title>Elenco libri</title>
	<link rel="stylesheet" href="biblio.css" />
</head>
<body>
	<div class="main">

		<h1>Elenco libri</h1>

		<p>
			<a href="libro-add.php" class="button">Aggiungi un libro</a>
			<a href="index.php" class="button">&laquo; Torna alla pagina iniziale</a>
		</p>

		<form method="get">
			<fieldset>
				<legend>Ordina &amp; filtra</legend>

				<table style="width: 100%;">
					<thead>
						<tr>
							<th>Ordina per:</th>
							<th>Cerca titolo:</th>
							<th>Genere:</th>
							<th>Casa editrice</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="text-align:center;">
								<select name="ordina" id="ordina">
									<option value="titolo ASC">Titolo crescente</option>
									<option value="titolo DESC">Titolo decrescente</option>
									<option value="anno_pub ASC">Anno pubb. crescente</option>
									<option value="anno_pub DESC">Anno pubb. decrescente</option>
								</select>
							</td>
							<td style="text-align:center;">
								<input type="text" name="cerca_titolo" id="cerca_titolo">
							</td>
							<td style="text-align:center">
								<select name="filtro_idg" id="filtro_idg">
									<option value="">Tutti i generi</option>
								</select>
							</td>
							<td style="text-align:center">
							
							</td>
							<td style="text-align:center">
								<button type="submit">Applica filtri</button>
							</td>
						</tr>
					</tbody>
				</table>
				
					
			</fieldset>
		</form>

		<table class="data-grid">
			<thead>
				<tr>
					<th>Titolo</th>
					<th>Autore/i</th>
					<th>Anno pub.</th>
					<th>N° pagine</th>
					<th>Azioni</th>
				</tr>
			</thead>
			<tbody>
				<?php while($riga = $comando->fetch()) { ?>
				<tr>
					<td><?php echo $riga['titolo']; ?></td>
					<td><?php echo getElencoAutoriLibro($riga['idl']); ?></td>
					<td></td>
					<td></td>
					<td><a href="libro-edit.php?idl=<?php echo $riga['idl']; ?>">Modifica</a> | <a href="libro.php?delete=">Elimina</a></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>

		<p style="text-align:center;">
			<em>Ci sono <strong><?php echo $conteggioTotaleLibri; ?></strong> libri in anagrafica</em><br />
			<em>La ricerca corrente ha restituito <strong>y</strong> libri</em>
		</p>

	</div>
</body>
</html>