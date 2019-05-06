<?php
/*
 * Called from the poll.php page
 * Gets the answer selected and increases the responses value,
 * sets a cookie so that we know if this visitor voted,
 * then redirects back to the calling page
 */

require_once 'dbconn.php';

$id = $_POST['option'];

$answerQuery = $dbh->query("SELECT * FROM answers WHERE id=$id");

if ($answerQuery->rowCount() == 0)
{
    echo "<h2>Invalid answer</h2>";
    die();
}

$answer = $answerQuery->fetch();
$responses = $answer['responses'] + 1;
$dbh->query("UPDATE answers SET responses=$responses WHERE id=$id");


$poll_id = $answer['poll_id'];
setcookie("poll".$poll_id, 1, time()+1000);

$dbh = null;
header("Location: poll.php?id=$poll_id");
die();