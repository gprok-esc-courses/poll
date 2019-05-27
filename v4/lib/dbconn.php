<?php
/*
 * DB connection. Include in each page that needs DB interaction.
 */

try {
    $dbh = new PDO('mysql:host=localhost;dbname=poll', 'test', 'test');
} catch (PDOException $e) {
    print "DB Connection Error!: " . $e->getMessage() . "<br/>";
    die();
}
