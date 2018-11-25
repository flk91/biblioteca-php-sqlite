<?php
require_once("connessione.php");

$dati_validi = true;
$errore = "";
$esito = false;

$idg = $_GET['idg'];

$str_query = "SELECT * FROM generi WHERE idg = :idg";
$comando = $dbconn->prepare($str_query);
$esegui = $comando->execute(['idg' => $idg]);

$genere = $comando->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Modifica genere</title>
    <link rel="stylesheet" href="biblio.css" />
</head>
<body>
    <div class="main">
        <h1>Modifica genere letterario</h1>
        <p>
            <a href="generi.php" class="button">Inizio</a>
            <a href="generi.php" class="button">Generi letterari</a>
        </p>

        <form action="" method="post">
            <table>
                <tr>
                    <td>Identificativo</td>
                    <td><input type="text" name="idg" id="idg" readonly="readonly" value="<?php echo $genere['idg']; ?>" /></td>
                </tr>
                <tr>
                    <td>Genere</td>
                    <td><input type="text" name="genere" id="genere" value="<?php echo $genere['genere']; ?>" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td><button type="submit">Salva</button></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>