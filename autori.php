<?php
require_once "connessione.php";
require_once "funzioni.php";

$elenco_nazioni = getElencoNazioni();
$conteggio_autori = getConteggioAutori();

// creo una variabile di tipo string contenente la query
// questo tipo di sintassi si chiama 'heredoc' e permette di
// scrivere facilmente una stringa formata da più righe
// si inizia con <<<QUALCOSA, dove qualcosa è un nome a scelta
// la stringa termina con una riga che deve contenere solo il nome scelto.
$str_query = "SELECT
    autori.ida, nomea, cognomea, autori.id_naz, 
    nazioni.nazione AS nazione,
    COUNT(libri.idl) AS n_libri
FROM AUTORI
LEFT JOIN scrive ON scrive.ida = autori.ida 
LEFT JOIN libri ON libri.idl = scrive.idl
LEFT JOIN nazioni ON nazioni.id_naz = autori.id_naz
GROUP BY autori.ida, nomea, cognomea, nazione";

// dichiaro una variabile result con la preparazione della query
$comando = $dbconn->prepare($str_query);

// eseguo la query
$esegui = $comando->execute();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestione biblioteca</title>
    <link rel="stylesheet" href="biblio.css">
</head>
<body>
    <div class="main">
        <h1>Gli autori</h1>
        <p>
            <a href="autore-add.php"><button>Aggiungi un nuovo autore</button></a>
            <a href="index.php"><button>Torna alla pagina iniziale</button></a>
        </p>

        <form action="" method="get">
            <fieldset>
                <legend>Filtro autori</legend>
                <table>
                    <tbody>
                        <tr>
                            <td>Cognome</td>
                            <td>Nome</td>
                            <td>Nazionalità</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="filtro_cognome" id="filtro_cognome" />
                            </td>
                            <td>
                                <input type="text" name="filtro_nome" id="filtro_nome" />
                            </td>
                            <td>
                                <select name="filtro_id_naz" id="filtro_id_naz">
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
                            <td><button type="submit">Applica filtri</button></td>
                        </tr>
                    </tbody>
                </table>
                
                
            </fieldset>
        </form>
        <p>&nbsp;</p>
        <table class="data-grid">
            <thead>
                <tr>
                    <th>Identificativo</th>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <th>Nazionalità</th>
                    <th>Numero libri</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($record = $comando->fetch()) : ?>
                <tr>
                    <td><?php echo $record['ida']; ?></td>
                    <td><?php echo $record['nomea']; ?></td>
                    <td><?php echo $record['cognomea']; ?></td>
                    <td><?php echo $record['nazione']; ?></td>
                    <td style="text-align:center;"><?php echo $record['n_libri']; ?></td>
                    <td>
                        <a href="autore-edit.php?ida=<?php echo $record['ida']; ?>">Modifica</a> | 
                        <a href="autore-delete.php?ida=<?php echo $record['ida']; ?>">Cancella</a></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" style="text-align:center;">
                        <em>Sono presenti <?php echo $conteggio_autori; ?> autori</em>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>