<?php
/*
 * Called from the poll.php page
 * Gets the answer selected and increases the responses value,
 * sets a cookie so that we know if this visitor voted,
 * then redirects back to the calling page
 */

require_once('lib/Poll.php');

$answer = AnswerModel::find($_POST['option']);

$answerQuery = $dbh->query("SELECT * FROM answers WHERE id=$id");

if ($answer == null)
{
    echo "<h2>Invalid answer</h2>";
    die();
}

$answer->addResponse();

setcookie("poll".$answer->poll_id, 1, time()+1000);

header("Location: poll.php?id=" . $answer->poll_id);
die();