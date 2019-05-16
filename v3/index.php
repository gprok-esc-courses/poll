<?php
/*
 * Displays all available polls.
 */

require_once('lib/Poll.php');

$title = "Home";
$body_title = "Available Polls";
$content = PollView::activeUnorderedList();

require_once('template.php');

