<?php
try {
    $dsn = "mysql:host=localhost;dbname=lb_pdo_lessons";
    $user = 'root';
    $pass = '';
    $dbh = new PDO($dsn, $user, $pass);
} catch(PDOException $ex) {
    echo $ex->getMessage();
}

?>