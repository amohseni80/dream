<?php
$hostname = "localhost";
$username = "mohsenas";
$password = "9&Nk&VCkQyt";
$databasename = "mohsenas_dream_recording";

$mysqli = new mysqli($hostname, $username, $password, $databasename);
$command = isset($_POST["command"]) ? $_POST["command"] : "";


  if ($command == "delete") {
  $id = isset($_POST["id"]) ? $_POST["id"] : "";
  $query = "DELETE FROM dreams WHERE id=?";
  $stmt = $mysqli->stmt_init();
  if ($stmt->prepare($query)) {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo "deleteSuccess";
    exit;
} else {
  echo"Error";
  }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Dream Recordings</title>
    <script src=ajax.js></script>
    <script>

    function remove(id) {

            var client = new HttpClient();
            client.isAsync = true;
            client.requestType = "POST";

             var string = `command=delete&id=${id}`;
             client.makeRequest('dream.php', string);

             client.callback = function(result) {
               console.log(string);
               console.log(result);
               if (result == "deleteSuccess") {
                 document.getElementById(id).style.display = "none";
                 alert("your dream has been deleted succesfully!");
               } else {
                 alert("An error has occurred!!");
               }
             }

           }


    </script>
    <style media="screen">

    body {
      /* background-color: red; */
      background-image: url('https://steamuserimages-a.akamaihd.net/ugc/909031767935442036/DAB42DF2EFCF98D42951810FE055D918CBE6A283/');
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-size: cover;
    }
    span{
      font-family: Impact;
      font-size: 150px;
      color: #DFE4C8;
    }
    table{
      width: 1300px;
      width:1300px;
      padding:8px;

      background-image: url('https://steamuserimages-a.akamaihd.net/ugc/909031767935442036/DAB42DF2EFCF98D42951810FE055D918CBE6A283/');
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-size: cover;
      align=center;
    }
    td, th {
        background-image: url('https://steamuserimages-a.akamaihd.net/ugc/909031767935442036/DAB42DF2EFCF98D42951810FE055D918CBE6A283/');
        font-family:verdana;
        color:white;
        opacity: 0.75;
        padding:10px;
        size:30px;
        text-align: center;
        /* background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover; */
    }
    td:hover{
      opacity: 1;
    }
    th:hover{
      opacity: 1;
    }

    th {
      background-image: url('https://steamuserimages-a.akamaihd.net/ugc/909031767935442036/DAB42DF2EFCF98D42951810FE055D918CBE6A283/');
      /* background-repeat: no-repeat;
      background-attachment: fixed;
      background-size: cover; */
    }

    </style>
  </head>
  <body>



    <?php


    $type = isset($_POST["type"]) ? $_POST["type"] : "";
    $dream = isset($_POST["dream"]) ? $_POST["dream"] : "";



    $query = "INSERT INTO dreams (id, type, dream) VALUES (NULL, ?, ?)";
    $stmt = $mysqli->stmt_init();
    if ($stmt->prepare($query)) {
        $stmt->bind_param("ss", $type, $dream);
        $stmt->execute();

        $stmt->close();

        echo "<span>COOL DREAM!</span>";
    } else {
        echo "<span>OOPS! DATA NOT COLLECTED</span>";
    }

    $query = "SELECT id, type, dream FROM dreams";

    $stmt = $mysqli->stmt_init();
    if ($stmt->prepare($query)) {
    	$stmt->bind_param("ss",$type, $dream);
    	$stmt->execute();

    	$stmt->bind_result($tempId, $tempType, $tempDream);
    	echo "<br><br><table>
    			<tr><th>ID</th><th>TYPE</th><th>DREAM</th><th>DELETE</th>";
    	while ($stmt->fetch()) {
    		echo "<tr id='".$tempId."'>
            <td>".$tempId."</td>
    				<td>".$tempType."</td>
    				<td>".$tempDream."</td>
            <td><button onclick=remove('".$tempId."')>X</button></td>
    			  </tr>\n";
    	}
    	echo "</table>";

$stmt->close();

} else {
    	$error = "Sorry an error has occurred!";  echo $error;  return;
    }
    ?>


  </body>
</html>
