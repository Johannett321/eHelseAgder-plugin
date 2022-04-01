<?php
/**
 * Sletter draft tabellen som allerede eksisterer, og oppretter en ny draft tabell
 */
function prepareProsjekterDraftsTable() {
    global $wpdb;
    $wpdb->query("DROP TABLE " . getDraftProsjekterDatabaseRef());
    createProsjekterTable(getDraftProsjekterDatabaseRef());
}

/**
 * Sletter draft tabellen som allerede eksisterer, og oppretter en ny draft tabell
 */
function prepareCollapsibleDraftsTable() {
    global $wpdb;
    $wpdb->query("DROP TABLE " . getDraftCollapsibleDatabaseRef());
    createCollapsibleTable(getDraftCollapsibleDatabaseRef());
}

/**
 * Genererer en unik prosjektID som er lik antall rader i prosjekter databasen + 1.
 * @return int Den unike iden
 */
function generateProjectID() {
    global $wpdb;
    $result = $wpdb->get_results("SELECT id FROM " . getProsjekterDatabaseRef());
    return sizeof($result)+1;
}