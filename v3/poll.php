<?php
/*
 * Displays the selected poll (from the index.php page)
 * If the visitor has voted recently will display the results for the poll,
 * otherwise will display a form for voting.
 */

require_once('lib/Poll.php');

$poll = PollModel::find($_GET['id']);

if($poll == null)
{
    $title = "Error";
    $body_title = "Poll not available";
    $content = "";
}
else {

    $title = $poll->title;
    $body_title = $poll->title;
    if (isset($_COOKIE['poll' . $poll->id])) {
        $content = PollView::pollResult($poll);
    } else {
        $content = PollView::pollVote($poll);
    }
}
$dbh = null;

require_once('template.php');


