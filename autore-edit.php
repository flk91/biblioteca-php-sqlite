<?php

require_once("connessione.php");
require_once("funzioni.php");

$elenco_nazioni = getElencoNazioni();

$errore = "";
$risultato = false;

// Constollo se ho il parametro GET ID autore
if(isset($_GET['ida'])) {
    // ... e lo leggo
    $ida = $_GET['ida'];
} else {
    /*
    Se non è presente un ID autore nell'URL
    (caso che non dovrebbe verificarsi),
    interrompo la pagina e mostro un errore a video.
    */
    die("ID autore non impostato.");
}

// Carico i dati dell'autore esistente
$str_query = "SELECT * FROM autori WHERE ida = :ida";
$comando = $dbconn->prepare($str_query);
$esegui = $comando->execute(['ida' => $ida]);

// Poichè la query restituisce una sola riga, 
// non è necessario fare un ciclo
$autore = $comando->fetch(PDO::FETCH_ASSOC);


//Se il form è stato inviato
if($_POST) {
    
    $dati_validi = true;
    //sovrascrivo nell'array autore i dati presi in input
    $autore = [
        'ida' => $_POST['ida'],
        'nomea' => $_POST['nomea'],
        'cognomea' => $_POST['cognomea'],
        'data_nascita' => strlen($_POST['data_nascita']) ? $_POST['data_nascita'] : null,
        'id_naz' => $_POST['id_naz'],
    ];

    //se cognome è vuoto
    if($autore['cognomea'] == "") {
        $dati_validi = false;
        $errore .= "Il cognome è obbligatorio<br />";
    }

    if($dati_validi) {
        $str_query = "UPDATE autori SET
            nomea = :nomea,
            cognomea = :cognomea,
            data_nascita = :data_nascita,
            id_naz = :id_naz
        WHERE
            ida = :ida
        ";
        $comando = $dbconn->prepare($str_query);
        $esegui = $comando->execute($autore);

        if($esegui) {
            $risultato = true;
        } else {
            $errore .= "Qualcosa è andato storto<br />";
        }
        
    }
    
}

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Modifica autore</title>
    <link rel="stylesheet" href="biblio.css">
</head>
<body>
    <div class="main">
        <h2>Modifica autore</h2>
        <p><a href="index.php">&laquo; Torna alla home</a></p>

        <?php
        if(strlen($errore) > 0) {
            echo "<p class=\"messaggio-errore\">$errore</p>";
        }
        ?>

        <form method="POST" action="">
            <table class="form-table">
                <tbody>
                    <tr>
                        <td>Identificativo:</td>
                        <td><input type="text" name="ida" id="ida" value="<?php echo $autore['ida']; ?>" readonly="readonly" /></td>
                    </tr>
                    <tr>
                        <td>Nome:</td>
                        <td><input type="text" name="nomea" id="nomea" value="<?php echo $autore['nomea']; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Cognome:</td>
                        <td><input type="text" name="cognomea" id="cognomea" value="<?php echo $autore['cognomea']; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Data di nascita:</td>
                        <td><input type="date" name="data_nascita" id="data_nascita" value="<?php echo $autore['data_nascita']; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Nazionalità:</td>
                        <td>
                            <select name="id_naz" id="id_naz">
                            <option value="">---</option>
                            <?php 
                            foreach($elenco_nazioni as $riga_nazione) { 
                                $id_naz = htmlentities($riga_nazione['id_naz']);
                                $nazione = htmlentities($riga_nazione['nazione']);
                                if($autore['id_naz'] == $id_naz) {
                                    $selected = "selected";
                                } else {
                                    $selected = "";
                                }

                                echo "<option value=\"$id_naz\" $selected >$nazione</option>";
                            } 
                            ?>
                            </select>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2">
                            <button type="submit">Salva</button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    </div>
</body>
</html>