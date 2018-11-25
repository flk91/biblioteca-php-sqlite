# Manuale di informatica

Il presente manuale è consultabile durante la seconda prova scritta dell'Esame di Stato.

# HTML

## Tag di base

```html
<html>…</html> definire un documento Html
<head>…</head> definire le informazioni di intestazione, quali il titolo e i meta tag
<title>…</title> Definire il titolo che appare nella scheda del browser
```
## Corpo di un documento HTML

```html
<body>…</body> Il corpo del documento html
```

## Collegamenti

```html
<a>...</a> Origine e destinazione di un collegamento ipertestuale
<a href="url">…</a> Collegamento ipertestuale
<a href="#name">…</a>	Collegamento ad un'ancora nel documento stesso.
<a href="URL#name">…</a> Collegamento ad un'ancora in un altro documento.
<a name="name">…</a> Ancora in un documento.
<a href="mailto: e-mail">…</a> Collegamento ad una e-mail.
```


## Tabelle

```html
<table>...</table>	Creare una tabella.
<table style="border:1px solid black; width: nnpx;"> Grandezza del bordo della tabella.
<tr>…</tr> Righe di una tabella (table row).
<td>…</td> Colonne di una tabella (table data).
<td colspan="colonne"> Estendere la cella attraverso il numero di colonne specificato
<td rowspan="righe"> Estendere la cella attraverso.
<th>…</th> Tabella d'intestazione con il testo in grassetto, allineato al centro.
```

## Immagini (estensioni .jpg, .png, .gif, .jfif)

```html
<img src="nomefile.estensione" alt="Testo alternativo" 
        style="width:nnpx; height: mmpx" />
```


## Form (moduli)

```html
<form name="…"     action="url"   method="get|post">      </form>
```
*(Esempi url: pagina1.php, pagina1.php?v1=valore1&v2=valore, http://www.pincopallo.it)*


## Campo di immissione

```html
<input type="…" name="aaa" id=”aaa” value="…" size="" />
```

## Tipi validi in HTML 5

**button**:	Pulsante cliccabile\
**checkbox**:	Casella di spunta\
**color**:	Selettore di colore\
**date**	Casella inserimento data (senza ora, formato nella lingua dell'utente)\
**datetime-local**:	Defines a date and time control (year, month, day, hour, minute, second, and fraction of a second (no time zone)\
**email**:	Casella inserimento indirizzo e-mail\
**file**:	Permette di selezionare dal computer un file da caricare\
**hidden**:	Campo invisibile all'utente\
**image**:	Permette di inserire un'immagine che si comporta come un pulsante\
**month**:	Controllo mese e anno (senza fuso orario)\
**number**:	Campo per l'inserimento di un numero\
**password**:	Campo password (i caratteri sono mascherati)\
**radio**:	Pulsante radio (una sola scelta)\
**range**:	Defines a control for entering a number whose exact value is not important (like a slider control). Default range is from 0 to 100\
**reset**:	Defines a reset button (resets all form values to default values)\
**search**:	Defines a text field for entering a search string\
**submit**:	Defines a submit button\
**tel**:	Casella inserimento numero di telefono\
**text**:	*Predefinito*. Casella di testo a linea singola\
**time**:	Casella inserimento ora (senza fuso orario)\
**url**:	Casella inserimento URL\
**week**:	Controllo n° settimana e anno (senza fuso orario)

## Lista a discesa

```html
<select name="aaa"  id=”aaa”>
  <option value="…"   [selected] > prima opzione   </option>
  <option value="…" > seconda opzione   </option>
</select>
```

## Prototipo pagina index.html

```html
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8" /> 
        <title>prototipo</title> 
        <link href="mio.css" rel="stylesheet" />
    </head>
    <body>
        <div>
            <h1>Benvenuto nel sito prototipo</h1>
            <br />
            <a href="pagina1.php">richiesta 1</a>
            <br />
            <a href="pagina2.php"> richiesta 2</a>
        </div>
    </body>
</html>
```

# HTML, PHP

## Connessione al DB e apertura sessione

```php
<?php
session_start();

$dbpath = "database.db";
$dbconn = new PDO("sqlite:" . $dbpath);

$dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
```

## Prototipo pagina di raccolta e inserimento dati

```html
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8" /> 
    <title>Raccolta dati</title> 
    <link href="mio.css" rel="stylesheet">
    <script>
    function controllo () {	
        if (document.getElementById("primo").value=="") {
            alert ("devi riempire il campo");
            return false; // controllo campo riempito
        }
        
        if (document.getElementById("primo").value != 
            document.getElementById("secondo").value) {
            alert ("i due campi devono essere uguali");
            return false;  
        }
    return true;
    }
    </script>
</head>
<body>
    <form name="form1" id="form1" action="#" method="post" />
        Primo <input type="text" name="primo" id="primo" />
        Secondo <input type="Text" name="secondo" id="secondo" />
        Terzo <input type="number" name="terzo" id="terzo" />
        Data <input type="date" name="data" id="data" /> …
        <input type="submit" value="Conferma" onclick="return controllo ();" />
    </form>
    <?php
    if ($_POST) {	
        $dbconn = new PDO("sqlite:database.db");

        $riga = [
            "primo" => $_POST['primo'],
            "secondo" => $_POST['secondo'],
            "terzo" => $_POST['terzo'],
            "data" => $_POST['data']
        ];
        
        // eventuali controlli

        $str_query="insert into tabella (campotestuale, campotestuale, camponumerico, 
                    campodata) values (:primo, :secondo, :terzo, :data)";
        $comando = $dbconn->prepare($str_query);
        $risultato = $comando->execute($riga);
    }
    ?>
</body>
</html>
```

# PHP + SQLite

## Query di selezione

```php
require_once("connessione.php"); //importo il file con la variabile di connessione
//...
$str_query = "SELECT campo1, campo2, campo3 FROM TABELLA"; //1. stringa query
$comando = $dbconn->prepare($str_query); //2. preparo la query
$esegui = $comando->execute(); //3. eseguo la query
//...
while($riga = $comando->fetch(PDO::FETCH_ASSOC)) {
    //la variabile $riga contiene la riga corrente.
    //il ciclo while gira per tutte le righe restituite dalla query
    echo $riga['campo1'];
    echo $riga['campo2'];
    echo $riga['campo3'];
}
```

## Query di selezione con parametri

```php
require_once("connessione.php");

$parametri = [
    'campo1' => 'valore campo 1'
]

$str_query = "SELECT campo1, campo2, campo3 FROM TABELLA WHERE campo1 = :campo1"; 
$comando = $dbconn->prepare($str_query);
$esegui = $comando->execute($parametri); 

while($riga = $comando->fetch(PDO::FETCH_ASSOC)) {
    //utilizzo la variabile $riga
}
```

## Query di inserimento

```php
require_once("connessione.php");

$riga = [
    'campoA' => $_POST['campoA'],
    'campoB' => $_POST['campoB'],
    'campoC' => $_POST['campoC'],
];

$str_query = "INSERT INTO tabella 
(campoA, campoB, campoC)
VALUES
(:campoA, :campoB, :campoC)";
$comando = $dbconn->prepare($str_query);
$esegui = $comando->execute($riga); 

//ottengo il numero di righe inserite dalla query
$righe_modificate = $comando->rowCount();
//se ho campo numerazione automatica, ottengo l'ultimo ID generato.
$id_generato = $dbconn->lastInsertId();
```

## Query di modifica

```php
require_once("connessione.php");

$riga = [
    'campoA' => $_POST['campoA'],
    'campoB' => $_POST['campoB'],
    'campoC' => $_POST['campoC'],
];

$str_query = "UPDATE tabella 
SET
campoA = :campoA, 
campoB = :campoB, 
campoC = :campoC";
$comando = $dbconn->prepare($str_query);
$esegui = $comando->execute($riga);
//ottengo il numero di righe modificate dalla query
$righe_modificate = $comando->rowCount();
```

## Query di cancellazione

```php
require_once('connessione.php');
$id = $_POST['id'];

$str_query = "DELETE FROM tabella WHERE id = :id";
$comando = $dbconn->prepare($str_query);
$esegui = $dbconn->execute(['id' => $id]);
//ottengo il numero di righe cancellate dalla query
$righe_cancellate = $comando->rowCount();
```



# SQL (SQLite)

## Create table

```sql
CREATE TABLE tabella1 (
    Idtabella1      CHAR (5) primary key,
    CampoA          INT NOT NULL,
    CampoB          REAL
);

CREATE TABLE tabella2 (
    Idtabella2      CHAR (3) primary key,
    CampoX          VARCHAR (30)
);

CREATE TABLE tabella3 (
    Idtabella3      AUTOINCREMENT,
    Campo1          VARCHAR (30) NOT NULL,
    Campo2          CHAR (25),
    Campo3          INTEGER,
    Campo4          TEXT (10),
    Campo5          DATE,
    Campo6          DATETIME,
    Campo7          TIME,
    Campo8          TEXT,
    Campo9          BOOL,
    Idtabella1      CHAR (5) REFERENCES tabella1 (Idtabella1),
    Idtabella2      CHAR (3), 
    CONSTRAINT t1 PRIMARY KEY (Idtabella3), 
    CONSTRAINT t2 FOREIGN KEY (Idtabella2) 
        REFERENCES tabella2 (Idtabella2) 
);
```

## Tipi di JOIN

### INNER JOIN (WHERE)

```sql
SELECT …
FROM tabella1, tabella2
WHERE tabella1.Idtabella1 = tabella3.Idtabella1
```
Visualizza solo i campi correlati tra le due tabelle

### LEFT JOIN (FROM)

```sql
SELECT …
FROM tabella1 
LEFT JOIN tabella3 
    ON tabella1.Idtabella1=tabella3.Idtabella1
```
Visualizza tutti i campi della tabella a sinistra, anche se non hanno niente di collegato con l’altra

### RIGHT JOIN (FROM)	

```sql
SELECT …
FROM tabella2 
RIGHT JOIN tabella3 
    ON tabella2.Idtabella2 = tabella3.Idtabella2
```
Visualizza tutti i campi della tabella a destra, anche se non hanno niente di collegato con l’altra

## Query

```
SELECT DISTINCT/TOP/BOTTOM      campi da visualizzare
FROM                            tabelle usate
WHERE                           condizioni
GROUP BY                        raggruppamenti
HAVING                          operazioni / condizioni su funz. di aggregazione
ORDER BY ASC/DESC               ordinamenti
```

## Funzioni sulle date

```sql
DATE()
```

## Altre funzioni

```
SUM()       : restituisce la somma
COUNT()     : restituisce il numero degli elementi
              (se nella parentesi metto * conta tutti i record del campo)
AVG()       : restituisce la media
MAX()       : restituisce il valor massimo
MIN()       : restituisce il valor minimo
```

## Operatori

```
IN / NOT IN () : verificare se il campo contiene i valori
LIKE : consente di utilizzare caratteri jolly
```

## Caratteri jolly

```
%       sostituisce un numero indefinito di caratteri (ANCHE NIENTE)
_       sostituisce un singolo carattere
```

