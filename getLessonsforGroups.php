<?php
include("connect.php");
$Group = $_GET["Group"];
    try 
    {
        $sqlSelect = "SELECT * FROM lesson,`groups`,lesson_groups 
        WHERE ID_Groups = FID_Groups AND ID_Lesson = FID_Lesson2 
        AND title =:Group";
        $sth = $dbh->prepare($sqlSelect);
        $sth->bindValue(":Group",$Group);
        $sth->execute();
        $res = $sth->fetchAll(PDO::FETCH_NUM);
    
        foreach($res as $row)
        {
            echo "<tr><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td></tr>";
        }
    }
    catch(PDOException $ex)
    {
        echo $ex->GetMessage();
    }
    $dbh = null;
?>