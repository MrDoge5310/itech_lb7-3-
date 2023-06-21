<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lessons</title>
    <script>
        let ajax = new XMLHttpRequest();
        
        function getLessonsforGroups() {
            let Group = document.getElementById("Group").value;
            ajax.onreadystatechange = load1;
            
            ajax.open("GET", "getLessonsforGroups.php?Group=" + Group);
            ajax.send();
        }
        
        function load1() {
            if (ajax.readyState === 4 && ajax.status === 200) {
                document.getElementById("tabl1").innerHTML = ajax.responseText;
            }
        }
        function getLessonsforTeacher() {
            let Teacher = document.getElementById("Teacher").value;

            ajax.onreadystatechange = load2;
            ajax.open("GET", "getLessonsforTeacher.php?name=" + Teacher);
            ajax.send();
        }
        
        function load2() {
            if (ajax.readyState === 4 && ajax.status === 200) {
                let res2 = JSON.parse(ajax.responseText);
                let res21 = "";
                for (let i = 0; i < res2.length; i++) {
                    console.dir(res2[i]);
                    let week_day = res2[i].week_day;
                    let lesson_number = res2[i].lesson_number;
                    let auditorium = res2[i].auditorium;
                    let disciple = res2[i].disciple;
                    let type = res2[i].type;
                    res21 += "<b>День: </b>" + week_day + "<br><b>Пара: </b>" + lesson_number + "<br><b>Аудитория: </b>" + auditorium + "<br><b>Предмет: </b>" + disciple + "<br><b>Вид занятий: </b>" + type + "<br>";
                }
                document.getElementById("Result2").innerHTML = res21;
            }
        }
        



        
        function getAuditoriumforLesson(url, callback, format) {
    const ajax3 = new XMLHttpRequest();
    ajax3.onreadystatechange = function() {
        if (ajax3.readyState === 4 && ajax3.status === 200) {
            if (format === 'xml') {
                console.log("xml");
                callback(ajax3.responseXML);
            }           
        }
    };
    ajax3.open('GET', url);
    ajax3.send();   
}

function getAuditorium() {
    const auditorium = document.getElementById('Auditorium').value;
    getAuditoriumforLesson('getAuditoriumforLesson.php?auditorium=' + auditorium, 
    function(response) {
        console.log(response);

        const auditoriums = response.getElementsByTagName('auditorium');
        let tableRows = '';

        for (let i = 0; i < auditoriums.length; i++) {
            const week_day  = auditoriums[i].getElementsByTagName('week_day')[0].textContent;
            const lesson_number = auditoriums[i].getElementsByTagName('lesson_number')[0].textContent;
            const disciple = auditoriums[i].getElementsByTagName('disciple')[0].textContent;
            const type = auditoriums[i].getElementsByTagName('type')[0].textContent;
            tableRows += `<tr><td>${week_day}</td><td>${lesson_number}</td><td>${disciple}</td><td>${type}</td></tr>`;
        }

        document.getElementById('res3').innerHTML = tableRows;
    },
    'xml');
}
    </script>
</head>
<body>
    
<h2>Виведення розкладу занять для довільної групи зі списку</h2>
    <select name="Group" id="Group">
        <?php
        include("connect.php");

        try {
            foreach ($dbh->query("SELECT title FROM `groups`") as $row) {
                $optionValue = htmlspecialchars($row[0]);
                echo "<option value='$optionValue'>$optionValue</option>";
            }
        } catch(PDOException $ex) {
            echo $ex->getMessage();
        }
        ?>
    </select>
    <input type="submit" name="butt1" onclick="getLessonsforGroups()">
        <table border="1">
        <tr><th>День</th><th>Пара</th><th>Аудитория</th><th>Предмет</th><th>Тип занятия</th></tr>
            <tbody id="tabl1"></tbody>
        </table> 





    <h2>Виведення розкладу занять для довільного викладача зі списку</h2>
        <select name="Teacher" id="Teacher">
    <?php
    include("connect.php");
    try {
         foreach($dbh->query("SELECT Name FROM teacher") as $row){
            $optionValue = htmlspecialchars($row[0]);
                echo "<option value='$optionValue'>$optionValue</option>";
        }
    }
    catch(PDOException $ex){
        echo $ex->GetMessage();
    }
    ?>
    </select>
        <input type="submit" value="Результат"onclick="getLessonsforTeacher()">
        <div id="Result2"></div>


<h2>Виведення розкладу занять для аудиторії зі списку</h2>
        <select name="Auditorium" id="Auditorium">
    <?php
    include("connect.php");
    try {
         foreach($dbh->query("SELECT DISTINCT auditorium FROM lesson") as $row){
            $optionValue = htmlspecialchars($row[0]);
                echo "<option value='$optionValue'>$optionValue</option>";
        }
    }
    catch(PDOException $ex){
        echo $ex->GetMessage();
    }
    ?>
    </select>
        <input type="submit" value="Результат" onclick="getAuditorium()">
        <table border = '1'>
    <tbody id= "res3"></tbody>
    </table>
</body>
</html>