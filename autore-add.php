<?php

require_once("connessione.php");
require_once("funzioni.php");

$elenco_nazioni = getElencoNazioni();

$inserito = false;

if($_POST) {
    $autore = [
        'ida' => $_POST['ida'],
        'cognomea' => $_POST['cognomea'],
        'nomea' => $_POST['nomea'],
        'data_nascita' => $_POST['data_nascita'],
        'id_naz' => $_POST['id_naz']
    ];

    $str_query = "INSERT INTO autori (ida, cognomea, nomea, data_nascita, id_naz)
    VALUES
    (:ida, :cognomea, :nomea, :data_nascita, :id_naz)";
    $comando = $dbconn->prepare($str_query);
    $esegui = $comando->execute($autore);

    if($esegui) {
        header("location:autore-edit.php?ida=" . $autore['ida']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>Inserimento autore</title>
    <link rel="stylesheet" href="biblio.css" />
</head>
<body>
    <div class="main">
        <h1>Inserisci autore</h1>
        <p><a href="autori.php"><button>&laquo; Torna all'elenco degli autori</button></a> <a href="index.php"><button>Torna alla home</button></a></p>

        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <td>Identificativo*:</td>
                    <td><input type="text" name="ida" id="ida"></td>
                </tr>
                <tr>
                    <td>Nome:</td>
                    <td><input type="text" name="nomea" id="nomea" /></td>
                </tr>
                <tr>
                    <td>Cognome*:</td>
                    <td>
                        <input type="text" name="cognomea" id="cognomea" />
                    </td>
                </tr>
                <tr>
                    <td>Data di nascita:</td>
                    <td>
                        <input type="date" name="data_nascita" id="data_nascita" />
                    </td>
                </tr>
                <tr>
                    <td>Nazionalità:</td>
                    <td>
                        <select name="id_naz">
                            <option value="">---</option>
                            <?php 
                            foreach($elenco_nazioni as $riga_nazione) { 
                                $id_naz = htmlentities($riga_nazione['id']);
                                $nazione = htmlentities($riga_nazione['nazione']);

                                echo "<option value=\"$id_naz\">$nazione</option>";
                            } 
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><button type="submit">Salva</button></td>
                </tr>
            </table>
        </form>
        <p>* = campo obbligatorio</p>
    </div>
</body>
</html>
