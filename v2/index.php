<?php
/*
 * Displays all available polls.
 */

require_once('lib/Poll.php');
?>

<h1>Polls</h1>

<div>
    <?= PollView::activeUnorderedList(); ?>
</div>
