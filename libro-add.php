<?php

require_once("connessione.php");

if($_POST) {

    //prendo in input la riga in un array associativo
    $riga = [
        'titolo' => $_POST['titolo'],
        'anno_pub' => $_POST['anno_pub'],
        'num_pag' => $_POST['num_pag'],
        'idg' => $_POST['idg'],
        'id_ce' => $_POST['id_ce'],
    ];

    //compongo la stringa della query
    $str_query = "INSERT INTO libri 
    (titolo, anno_pub, num_pag, idg, id_ce) 
    VALUES 
    (:titolo, :anno_pub, :num_pag, :idg, :id_ce)";
    //creao il comando
    $comando = $dbconn->prepare($str_query);
    //eseguo la query passando in input l'array della riga
    $esegui = $comando->execute($riga);

    //la funzione $dbconn->lastInsertId() restituisce l'ID assegnato dal database ai nuovi record.
    //va utilizzata dove è prevista la numerazione automatica
    $idl = $dbconn->lastInsertId();

    //Se la query è andata a buon fine, mando l'utente alla pagina di modifica del libro
    if($esegui) {
        header("location:libro-edit.php?idl=$idl");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <title>Aggiungi un nuovo libro</title>
    <link rel="stylesheet" href="biblio.css">
</head>
<body>
    <div class="main">
        <h1>Aggiungi un libro</h1>
        <p>
            <a href="libri.php" class="button">Annulla e torna indietro</a>
        </p>

        <form action="" method="post">
            <table class="form-table">
                <tbody>
                    <tr>
                        <td>Titolo:</td>
                        <td>
                            <input type="text" name="titolo" id="titolo" />
                        </td>
                    </tr>
                    <tr>
                        <td>Anno di pubblicazione:</td>
                        <td><input type="number" name="anno_pub" id="anno_pub" /></td>
                    </tr>
                    <tr>
                        <td>N° pagine:</td>
                        <td><input type="number" name="num_pag" id="num_pag" /></td>
                    </tr>
                    <tr>
                        <td>Genere:</td>
                        <td>
                            <select name="idg" id="idg">
                                <option value="">---</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Casa editrice:</td>
                        <td>
                            <select name="id_ce" id="id_ce">
                                <option value="">---</option>

                            </select>
                        </td>
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