<?php

/* Displays user information and some useful messages */
require 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hanh Maisenti JSvalidator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css?v=<?=time();?>" /> <!--Chrome Refresh is TERRIBLE. Remove for production -->
    <script src="main.js"></script>
</head>

<body>
	<h1>Display Travellers</h1>
	<table class="data-table">
        <thead>
            <tr>
                <th>Unique ID</th>
                <th>Flight</th>
                <th>Email</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Starter</th>
                <th>Main Course</th>
                <th>Rating</th>
                <th>Dessert</th>
            </tr>
        </thead>
        <tbody>

        <?php
        //This part extracts the data from the database
        $result = $mysqli->query("SELECT * FROM people");

        if ($result->num_rows == 0) { // Nothing exists
            echo "<p>No travellers Found</p>";
        } else {
            // Users exists (num_rows != 0)
            // output data of each row
            while ($user = $result->fetch_assoc()) {
                $id = $user['id'];

                echo "<tr>";
                echo "<td>" . $id . "</td>";
                echo "<td>" . $user['flight'] . "</td>";
                echo "<td>" . $user['email'] . "</td>";
                echo "<td>" . $user['fname'] . "</td>";
                echo "<td>" . $user['lname'] . "</td>";
                echo "<td>" . $user['starter'] . "</td>";
                echo "<td>" . $user['maincourse'] . "</td>";
                echo "<td>" . $user['rating'] . "</td>";

                //we need to get the dessert stuff
                $desserts = $mysqli->query("SELECT * FROM desserts WHERE id='$id'");
                $count = 0;
                while ($dessert = $desserts->fetch_assoc()) {
                    if ($count>0){
                        echo "</tr>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                    } 
                    echo "<td>" . $dessert['dessert'] . "</td>";
                    $count++;
                }
                echo "</tr>";
            }
            echo "</table>";
        }
        ?>
        </tbody>
	</table>
</body>
</html>