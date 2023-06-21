<?php
include("connect.php");

$Auditorium = $_GET["auditorium"];

try {
    $sqlSelect = "SELECT week_day, lesson_number, disciple, type FROM lesson WHERE auditorium = :Auditorium";

    $sth = $dbh->prepare($sqlSelect);
    $sth->bindValue(":Auditorium", $Auditorium);
    $sth->execute();
    $res = $sth->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: text/xml');

    echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
    echo '<response>';

    foreach ($res as $row) {
        echo '<auditorium>';
        echo '<week_day>' . $row['week_day'] . '</week_day>';
        echo '<lesson_number>' . $row['lesson_number'] . '</lesson_number>';
        echo '<disciple>' . $row['disciple'] . '</disciple>';
        echo '<type>' . $row['type'] . '</type>';
        echo '</auditorium>';
    }

    echo '</response>';
} catch (PDOException $ex) {
    echo $ex->getMessage();
}

$dbh = null;
?>
