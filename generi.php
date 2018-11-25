<?php

require_once('include/connessione.php');


$str_query = "SELECT * FROM generi ORDER BY genere ASC";
$comando = $dbconn->prepare($str_query);
$comando->execute();

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8" />
    <title>Gestione biblioteca</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <div class="main">
		<h1>Generi letterari</h1>
		<p>
			<a class="button" href="index.php">
				&laquo; Torna alla home page
			</a>
		</p>
		<p>
			<a href="genere-add.php" class="button">
				+ Aggiungi nuovo
			</a>
		</p>
		<table class="data-grid">
			<thead>
				<tr>
					<th>Identificativo</th>
					<th>Genere</th>
					<th>Azioni</th>
				</tr>
			</thead>
			<tbody>
				<?php if($comando) : ?>
					<?php while($genere = $comando->fetch()) : ?>
						<tr>
							<td><?php echo $genere['idg']; ?></td>
							<td><?php echo $genere['genere']; ?></td>
							<td>
								<a href="genere-edit.php?idg=<?php echo $genere['idg']; ?>">Modifica</a>&nbsp;
								<a href="genere-delete.php?idg=<?php echo $genere['idg']; ?>" onclick="return confirm('Il genere evidenziato sarà eliminato. Confermare?');">Elimina</a>
							</td>
						</tr>
					<?php endwhile; ?>
				<?php else : ?>
					<tr>
						<td colspan="2" style="text-align: center;">
							<strong>Non ci sono ancora generi</strong><br />
							<a href="genere.php">Fai clic qui</a> per creare il primo.
						</td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</body>
</html>