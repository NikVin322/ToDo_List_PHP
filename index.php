<?php
$tasks = simplexml_load_file("todo.xml") -> Task;

function searchItemByTask($query){
    global $tasks;

    $result = array();
    foreach ($tasks as $task){
        if(substr(strtolower($task -> Target), 0, strlen($query)) == strtolower($query))
            array_push($result, $task);
    }
    return $result;
}

function xmlToArray() {
    global $tasks;

    $result = array();
    foreach($tasks as $node) {
        $result[] = $node;
    }
    return $result;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>ToDo list</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://vinogradov17.thkit.ee/ToDo/style.css">
    <meta charset="utf-8" />
</head>
<body>
    <div>
        <h1>Task1 (XML and HTML)</h1>
        <br>
        <b>1-st task -</b>
        <b>
            <?php
                echo $tasks[0] -> Target;
            ?>
        </b>
        <br>
        <b>In the penultimate description</b>
        <b>
            <?php
            $var_Ps=$tasks->xpath('/TODO/Task[last()-1]/Description')[0];
            echo strlen($var_Ps);
            ?>
            characters</b><br>
        <b>Second description without letter "a" - </b>
        <?php
        $clean_code = preg_replace('/[^b-z,B-Z ]/', '', $tasks[1] -> Description);
        echo $clean_code ;
        ?>
        <br /><br />
        <table border="1">
            <tr>
               <th>Id</th>
               <th>Task name</th>
               <th>Description</th>
               <th>CreateDate</th>
               <th>Deadline</th>
               <th>Status</th>
            </tr>
            <?php
            $result = xmlToArray();
            foreach($result as $task) {
                echo '<tr>';
                    echo '<td>'.($task -> id).'</td>';
                    echo '<td>'.($task -> Target).'</td>';
                    echo '<td>'.($task -> Description).'</td>';
                    echo '<td>'.($task -> CreateDate).'</td>';
                    echo '<td>'.($task -> Deadline).'</td>';
                    echo '<td>'.($task -> BoolStatus).'</td>';
                echo '</tr>';
            }
            ?>
        </table>
        <div>
          <br>
            <h4>Search by task name</h4>
            <div>
                <form action="?" method="post">
                    <h3>
                        <div>
                            <input type="text" name="searchName" />
                            <input class="btn btn-primary" type="submit" value="Find" />
                        </div>
                    </h3>
                </form>
                <table border="1">
                    <tr>
                      <th>Id</th>
                      <th>Task name</th>
                      <th>Description</th>
                      <th>Date of create</th>
                      <th>Deadline</th>
                      <th>Status</th>
                    </tr>
                    <?php
                        if(!empty($_POST['searchName'])) {
                            $result = searchItemByTask($_POST['searchName']);
                            foreach($result as $task) {
                echo '<tr>';
                  echo '<td>'.($task -> id).'</td>';
                  echo '<td>'.($task -> Target).'</td>';
                  echo '<td>'.($task -> Description).'</td>';
                  echo '<td>'.($task -> CreateDate).'</td>';
                  echo '<td>'.($task -> Deadline).'</td>';
                  echo '<td>'.($task -> BoolStatus).'</td>';
                echo '</tr>';
                            }
                        }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>