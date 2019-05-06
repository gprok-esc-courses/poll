<?php
/*
 * Displays the selected poll (from the index.php page)
 * If the visitor has voted recently will display the results for the poll,
 * otherwise will display a form for voting.
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('lib/Poll.php');

$poll = PollModel::find($_GET['id']);

if($poll == null)
{
    echo "<h2>Poll not available</h2>";
    die();
}

echo "<a href='index.php'>Home</a>";
echo "<h1>Poll</h1>";
echo $poll->title;

if (isset($_COOKIE['poll'.$poll->id]))
{
    echo PollView::pollResult($poll);
}
else {
    echo PollView::pollVote($poll);
}
$dbh = null;

