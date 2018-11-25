<?php

require_once (__DIR__ . "/connessione.php");

/**
 * Ottiene il conteggio dei libri presenti in biblioteca
 * 
 * @return int
 */
function getConteggioLibri() {
    // in PHP le variabili globali devono essere dichiarate nelle funzioni che ne fanno uso
    // mediante la parola chiave 'global'
    global $dbconn;

    $str_query = "SELECT COUNT(*) as conteggio FROM libri";
    $comando = $dbconn->query($str_query);
    $conteggio = $comando->fetchColumn();

    return $conteggio;
}

/**
 * Ottiene il conteggio degli autori in archivio
 * 
 * @return int
 */
function getConteggioAutori() {
    global $dbconn;

    $str_query = "SELECT COUNT(*) as conteggio FROM autori";
    $comando = $dbconn->query($str_query);
    $conteggio = $comando->fetchColumn();

    return $conteggio;
}

/**
 * Ottiene il conteggio dei generi
 * 
 * @return int
 */
function getConteggioGeneri() {
    global $dbconn;

    $str_query = "SELECT COUNT(*) as conteggio FROM generi";
    $comando = $dbconn->query($str_query);
    $conteggio = $comando->fetchColumn();

    return $conteggio;
}

/**
 * Ottiene il conteggio dei libri di un determinato autore
 * 
 * @param string $ida ID identificativo dell'autore
 * @return int
 */
function getConteggioLibriPerAutore($ida) {
    global $dbconn;

    $str_query = "SELECT COUNT(*) as conteggio FROM autori WHERE ida = :ida";

    // in questo caso usiamo una query parametrica
    $stmt = $dbconn->prepare($str_query);
    $comando = $dbconn->query($stmt, ['ida' => $ida]);
    $conteggio = $comando->fetchColumn();

    return $conteggio;
}

/**
 * Ottiene l'elenco di tutti gli autori.
 * Il risultato è un array a 2 dimensioni ([riga][nome_colonna])
 * 
 * @return array
 */
function getElencoAutori() {
    global $dbconn;
    $str_query = "SELECT ida, cognomea, nomea FROM autori ORDER BY cognomea ASC, nomea ASC";
    $comando = $dbconn->query($str_query);
    $dataset = $comando->fetchAll();
    return $dataset;
}

/**
 * Ottiene l'elenco dei generi presenti in archivio, ordinati per nome.
 * Funzionamento analogo alla funzione getElencoAutori
 * 
 * @return array
 */
function getElencoGeneri() {
    global $dbconn;

    $str_query = "SELECT idg, genere FROM generi ORDER BY genere ASC";
    $comando = $dbconn->query($str_query);
    $dataset = $comando->fetchAll();
    return $dataset;
}

/**
 * Ottiene l'elenco di tutte le case editrici.
 * Idem come sopra.
 * 
 * @return array
 */
function getElencoCasaEd() {
    global $dbconn;

    $str_query = "SELECT id_ce, nome, email FROM casaed ORDER BY nome ASC";
    $comando = $dbconn->query($str_query);
    $dataset = $comando->fetchAll();
    return $dataset;
}

/**
 * Ottiene l'elenco delle nazioni dalla tabella nazioni
 * 
 * @return array
 */
function getElencoNazioni() {
    global $dbconn;

    $str_query = "SELECT * FROM nazioni ORDER BY nazione";
    $comando = $dbconn->prepare($str_query);
    $esegui = $comando->execute();
    if($esegui) {
        $nazioni = $comando->fetchAll();
        return $nazioni;
    }
}

/**
 * Ottiene l'elenco degli autori che hanno scritto 
 * un determinato libro
 * 
 * @return string
 */
function getElencoAutoriLibro($idl) {
    global $dbconn;

    //inizilizzo stringa elenco autori che andrò successivamente a comporre
    $elenco_autori = "";

    $str_query = "SELECT cognomea, nomea 
        FROM autori AS a, scrive AS s
        WHERE s.ida = a.ida
        AND s.idl = :idl
        ORDER BY cognomea, nomea";

    $comando = $dbconn->prepare($str_query);
    $esegui = $comando->execute(['idl' => $idl]);

    if($esegui == true) {
        while($riga = $comando->fetch()) {
            //se ho già altri autori, antepongo un trattino.
            if(strlen($elenco_autori)>0) {
                $elenco_autori .= ' - ';
            }
            
            $elenco_autori .= $riga['cognomea'] . ', ' . $riga['nomea'];
        }
    } 

    if($elenco_autori == "") {
        $elenco_autori = "N.D.";
    }

    return $elenco_autori;
    
}