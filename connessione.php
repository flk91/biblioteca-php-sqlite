<?php
// attiva il supporto alle variabili di sessione
session_start();

// dichiaro variabile con il percorso al file del database
$dbpath = "biblioteca.db";

// dichiaro oggetto dbconn che permette di interrogare il database
$dbconn = new PDO("sqlite:" . $dbpath);

// serve a fare in modo che in caso di errori nella query,
// il programma si blocchi mostrando l'errore all'utente
$dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
