<?php

require_once('dbconn.php');


class Poll
{
    var $id;
    var $title;
    var $date_posted;
    var $answers;

    function __construct($title, $id, $date_posted)
    {
        $this->id = $id;
        $this->title = $title;
        $this->date_posted = $date_posted;
        $this->answers = array();
    }

    function addAnswer($answer)
    {
        array_push($this->answers, $answer);
    }
}


class Answer
{
    var $id;
    var $title;
    var $poll_id;
    var $responses;

    function __construct($title, $id, $responses, $poll_id)
    {
        $this->id = $id;
        $this->title = $title;
        $this->responses = $responses;
        $this->poll_id = $poll_id;
    }

    function addResponse()
    {
        $responses = $this->responses + 1;
        $dbh = $GLOBALS['dbh'];
        $dbh->query("UPDATE answers SET responses=$responses WHERE id=" . $this->id);
    }

}


class PollModel
{
    static function active()
    {
        $dbh = $GLOBALS['dbh'];
        $polls = $dbh->query('SELECT * from polls WHERE activated=1 AND archived=0');

        $poll_list = array();
        foreach($polls as $row) {
            $poll = new Poll($row['title'], $row['id'], $row['date_posted']);
            $poll_list[] = $poll;
        }

        return $poll_list;
    }

    static function find($id)
    {
        $dbh = $GLOBALS['dbh'];
        $pollRequested = $dbh->query("SELECT * from polls WHERE id=$id AND activated=1 AND archived=0");

        if($pollRequested->rowCount() == 0) {
            return null;
        }

        $row = $pollRequested->fetch();
        $poll = new Poll($row['title'], $row['id'], $row['date_posted']);

        $answers = $dbh->query("SELECT * FROM answers WHERE poll_id=$id");

        foreach ($answers as $answer) {
            $ans = new Answer($answer['title'], $answer['id'], $answer['responses'], $answer['poll_id']);
            $poll->addAnswer($ans);
        }

        return $poll;
    }
}


class PollView
{
    static function activeUnorderedList()
    {
        $polls = PollModel::active();

        $view = "<div>";
        foreach($polls as $poll) {
            $view .= "<p><a href='poll.php?id=" . $poll->id . "'>" . $poll->title . "</a></p>";
        }
        $view .= "</div>";

        return $view;
    }

    static function pollResult($poll)
    {
        $view = "<div id='results'><table border='1'>";
        foreach ($poll->answers as $answer) {
            $view .= "<p>" . $answer->title . ": <span class='answer'>" . $answer->responses . " votes</span></p>";
        }
        $view .= "</table></div>";

        return $view;
    }

    static function pollVote($poll)
    {
        $view = "<form method='post' action='record.php'>";
        $view .= "<div>";
        foreach ($poll->answers as $answer) {
            $view .= "<p><input type='radio' name='option' value='" . $answer->id . "'> " . $answer->title . "</p>";
        }
        $view .= "</div>";
        $view .= "<input type='submit'>";
        $view .= "</form>";

        return $view;
    }
}


class AnswerModel
{
    static function find($id)
    {
        $dbh = $GLOBALS['dbh'];
        $answerQuery = $dbh->query("SELECT * FROM answers WHERE id=$id");

        if ($answerQuery->rowCount() == 0)
        {
            return null;
        }

        $ans = $answerQuery->fetch();
        $answer = new Answer($ans['title'], $ans['id'], $ans['responses'], $ans['poll_id']);

        return $answer;
    }
}