<?php
require_once("connessione.php");
$idl = $_GET['idl'];

$str_query = "SELECT * FROM libri WHERE idl = :idl";
$comando = $dbconn->prepare($str_query);
$esegui = $comando->execute(['idl' => $idl]);

$libro = $comando->fetch();

//dopo aver caricato il libro, carico l'elenco degli autori già associati al libro
$str_query = "SELECT a.ida, a.cognomea, a.nomea  
FROM autori AS a, scrive AS s 
WHERE a.ida = s.ida AND s.idl=:idl
ORDER BY a.cognomea, a.nomea";

$comandoGetAutori = $dbconn->prepare($str_query);
$esegui = $comandoGetAutori->execute(['idl' => $idl]);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <title>Modifica libro</title>
    <link rel="stylesheet" href="biblio.css" />
</head>
<body>
    
    <div class="main">
        <h1>Modifica libro</h1>
        <p><a href="libri.php" class="button">Torna all'elenco dei libri</a></p>
        <form action="" method="post">
            <fieldset>
                <legend>Dati del libro</legend>
                <table class="form-table">
                    <tbody>
                        <tr>
                            <td>Titolo</td>
                            <td><input type="text" name="titolo" id="titolo" value="<?php echo $libro['titolo']; ?>" /></td>
                            
                        </tr>
                        <tr>
                            <td>Anno di pubblicazione</td>
                            <td><input type="number" name="anno_pub" id="anno_pub" value="<?php echo $libro['anno_pub']; ?>" /></td>
                        </tr>
                        <tr>
                            <td>N° pagine</td>
                            <td><input type="number" name="num_pag" id="num_pag" value="<?php echo $libro['num_pag']; ?>" /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><button type="submit">Salva</button></td>
                        </tr>
                    </tbody>
                </table>
            </fieldset>
        </form>

        <form action="libro-unset-autore.php">
            <fieldset>
                <legend>Autori associati al libro</legend>

                <ul>
                    <?php 
                    while($autore = $comandoGetAutori->fetch()) {
                        $cognomea = $autore['cognomea'];
                        $nomea = $autore['nomea'];
                        $ida = $autore['ida'];
                        echo "<li>$cognomea, $nomea <a href=\"libro-unset-autore.php?idl=$idl&ida=$ida\" onclick=\"return confirm('Dissociare l\'autore selezionato?');\">dissocia</a></li>";
                    }
                    ?>
                </ul>
            </fieldset>
        </form>

        <form action="libro-set-autore.php">
            <fieldset>
                <legend>Associa autore</legend>

                <table>
                    <tr>
                        <td>Autore:</td>
                        <td>
                            <select name="id_autore" id="id_autore"></select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button type="submit">Associa</button></td>
                    </tr>
                </table>
            </fieldset>
            
        </form>
        
    </div>
    
</body>
</html>