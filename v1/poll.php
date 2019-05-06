<?php
/*
 * Displays the selected poll (from the index.php page)
 * If the visitor has voted recently will display the results for the poll,
 * otherwise will display a form for voting.
 */

require_once 'dbconn.php';

$id = $_GET['id'];

$poll = $dbh->query("SELECT * from polls WHERE id=$id AND activated=1 AND archived=0");

if($poll->rowCount() == 0)
{
    echo "<h2>Poll not available</h2>";
    die();
}


$answers = $dbh->query("SELECT * FROM answers WHERE poll_id=$id");

$row = $poll->fetch();

echo "<a href='index.php'>Home</a>";
echo "<h1>Poll</h1>";
echo $row['title'];

if (isset($_COOKIE['poll'.$id]))
{
    echo "<table>";
    foreach ($answers as $answer) {
        echo "<tr><td>" . $answer['title'] . ":</td><td>" . $answer['responses'] . " votes</td></tr>";
    }
    echo "</table>";

}
else {
    echo "<form method='post' action='record.php'>";
    echo "<ul>";
    foreach ($answers as $answer) {
        echo "<li><input type='radio' name='option' value='" . $answer['id'] . "'> " . $answer['title'] . "</li>";
    }
    echo "</ul>";
    echo "<input type='submit'>";
    echo "</form>";
}
$dbh = null;

