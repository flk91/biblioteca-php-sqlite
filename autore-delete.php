<?php

require_once("dbconn.php");

// PAGINA DI ELIMINAZIONE AUTORE

$result = false; // risultato dell'operazione
$errstr = ""; // eventuale messaggio di errore

//controllo il dato in input
if(isset($_GET['ida']) && strlen($_GET['ida'])>0) {
    // prendiamo in input l'ID dell'autore da eliminare
    $ida = $_GET['ida'];
    
    $sql = "DELETE FROM autori WHERE ida = :ida";
    $stmt = $dbconn->prepare($sql);
    $elimina = $stmt->execute([
        'ida' => $ida
    ]);

    if($elimina) {
        $result = true;
    }

} else {
    $errstr .= "Non è stato specificato l'identificativo dell'autore da eliminare.";
}

//carico parte superiore pagina
require_once("include/header.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <title>Eliminazione autore</title>
    <link rel="stylesheet" href="biblio.css" />
</head>
<body>
    <div class="main">
        <h1>Elimina autore</h1>

        <?php 
        if($result == true) {
            echo "<p class=\"alert alert-success\">L'eliminazione è andata a buon fine</p>";
        } else {
            echo "<p class=\"alert alert-error\">$errstr</p>";
        }
        ?>

        <p>
            <a href="autori.php">&laquo; Torna all'elenco degli autori</a>
        </p>

    </div>
</body>
</html>