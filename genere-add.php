<?php
require(__DIR__ . '/include/header.php');

$genere = [
	'idg' => 0,
	'nome' => ''
];

if(isset($_POST) && count($_POST) > 0) {
	$idg = intval($_POST['idg']);
	$genere = $_POST['genere'];
	
	if($id > 0) {
		//se l'ID è maggiore di zero vuol dire che devo aggiornare
		//un record esistente.
		
		$strQuery = "UPDATE generi SET nome = :nome WHERE id= :id";
		
	} else {
		//altrimenti, creo un nuovo record
		
		//inizializzo una variabile con la stringa della query
		$strQuery = "INSERT INTO generi (nome) VALUES (:nome)";
		//chiedo all'oggetto dbconn di "preparare" la query
		$query = $dbconn->prepare($strQuery);
		//assegno il nome del genere al relativo parametro
		$query->bindParam(':nome', $genere['nome']);
		//eseguo la query
		$query->execute();
		
	}
}
?>
<h1>Aggiungi genere letterario</h1>

<p><a href="generi.php">Torna all'elenco dei generi</a></p>

<form method="POST" action="">

<p>
	<button type="submit">Salva</button>
	<a href="generi.php">
		<button type="button">Annulla</button>
	</a>
</p>

</form>
<?php
require(__DIR__ . '/include/footer.php');