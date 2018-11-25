# Biblioteca "Io speriamo che me la cavo"

Questo progetto è stato creato a scopo didattico, per illustrare ai 
ragazzi delle classi quinte del corso SIA (ragionieri programmatori) 
il funzionamento di PHP con una base di dati.

## Tecnologie

Il database scelto è SQLite3, per i seguenti motivi:

* conformità alla sintassi SQL standard
* open-source, cross-platform
* contenuto in un solo file, un DB SQLite è più maneggevole in confronto ad altri DBMS quali MySQL, PostgreSQL o Microsoft SQL Server.

Per l'interoperatività tra PHP e SQLite3 è stata scelta l'API PDO, in quanto è universale. Il database potrà quindi essere facilmente migrato ad altra piattaforma senza richiedere modifiche al codice (eccetto per la stringa di connessione, che si trova nel file **include/dbconn.php**).

## Stile di programmazione

* Non viene adoperata la programmazione orientata agli oggetti, fatta eccezione per l'uso degli oggetti di PDO.
* Le funzioni sono commentate con commenti docbook. Si tratta di commenti scritti con una sintassi particolare, il cui scopo è comunicare agli ambienti di sviluppo (es: Eclipse, Netsons, Visual Studio Code), le caratteristiche e i tipi di dati richiesti e/o restituiti.
* Si cerca di mantenere il più possibile la separazione tra codice HTML e codice PHP.