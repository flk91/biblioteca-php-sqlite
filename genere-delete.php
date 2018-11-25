<?php

require_once ("connessione.php");

$eliminato = false;
$errore .= "";

if(isset($_GET['idg'])) {
    $idg = $_GET['idg'];

    $str_query = "DELETE FROM generi WHERE idg = :idg";
    $comando = $dbconn->prepare($str_query);
    $esegui = $comando->execute(['idg' => $idg]);
} else {
    $errore = "Identificativo genere letterario non specificato";
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8" />

    <title>Elimina genere letterario</title>
    <link rel="stylesheet" href="biblio.css" />
</head>
<body>
    <div class="main">
        <h1>Elimina genere letterario</h1>
        <?php 
        if($eliminato) {
            echo "<p>Eliminazione avvenuta con successo</p>";
        } 
        ?>
    </div>
</body>
</html>