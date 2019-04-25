<?php
/*
 * Displays all available polls.
 */

require_once 'dbconn.php';

$polls = $dbh->query('SELECT * from polls WHERE activated=1 AND archived=0');

echo "<h1>POLLS</h1>";

echo "<ul>";
foreach($polls as $row) {
    echo "<li><a href='poll.php?id=" . $row['id'] . "'>" . $row['title'] . "</a></li>";
}
echo "</ul>";

$dbh = null;