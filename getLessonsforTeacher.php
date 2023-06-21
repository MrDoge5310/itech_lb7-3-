<?php
include("connect.php");
$Teacher = $_GET["name"];

    try 
    {
        $sqlSelect = "SELECT * FROM lesson,teacher,lesson_teacher
        WHERE ID_Teacher = FID_Teacher AND ID_Lesson = FID_Lesson1 
        AND `Name` =:Teacher";

        $sth = $dbh->prepare($sqlSelect);
        $sth->bindValue(":Teacher",$Teacher);
        $sth->execute();
        $res = $sth->fetchAll(PDO::FETCH_ASSOC);
      
        
    echo json_encode($res); 

    }
    catch(PDOException $ex)
    {
        echo $ex->GetMessage();
    }
    $dbh = null;
?>
