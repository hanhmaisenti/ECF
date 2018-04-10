<?php
require 'db.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hanh Maisenti JSvalidator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/main.css?v=<?=time();?>" /> <!--Chrome Refresh is TERRIBLE. Remove for production -->
    <script src="../jscript/main.js"></script>
</head>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') { //this triggers when the submit action is triggered
    //javascript returns true here. form already validated, very simple
    if (isset($_POST['savetodb'])) {
        require 'submitdata.php'; //extension php to submit the form submission data to sql database
    }
}
?>

<body>
    <h1>ECF2</h1>    
    <h2>Traveller Flight Preferences</h2>
    <form name="jsvalidator" action="index.php" onsubmit="return validateForm()" method="POST">

        <div class="container c_green">
            <h3>Please enter your Email Address</h3><input type="text" name="email" value=""><br>
            <h3>Please enter your First Name</h3><input type="text" name="firstname" value=""><br>
            <h3>Please enter your Family Name</h3><input type="text" name="lastname" value=""><br>
            <h3>Please enter your Flight Number</h3><input type="text" name="flightnumber" value="">
        </div>

        <div class="container c_gold">
            <h3>Please select a starter Course</h3>
            <select name="starter">
                <option value="Tomato Soup">Tomato Soup</option>
                <option value="Bread">Bread</option>
                <option value="Prawn Cocktail">Prawn Cocktail</option>
                <option value="Chicken Liver Pate">Chicken Liver Pate</option>
            </select>
        </div>

        <div class="container c_pink">
            <h3>Please select a Main Course Meal</h3>
            <input type="radio" name="maincourse" value="Chicken Curry">Chicken Curry<br>
            <input type="radio" name="maincourse" value="Beef Curry">Beef Curry<br>
            <input type="radio" name="maincourse" value="Stirfry Noodles">Stirfry Noodles<br>
            <input type="radio" name="maincourse" value="Steak">Steak
        </div>

        <div class="container c_grey">
            <h3>Please select your dessert (more than 1 allowed!)</h3>
            <input type="checkbox" name="desserts[]" value="Chocolate Cake">Chocolate Cake<br>
            <input type="checkbox" name="desserts[]" value="Lemon Merangue">Lemon Merangue<br>
            <input type="checkbox" name="desserts[]" value="Gu">Gu!
        </div>

        <div class="container">
            <h3>How do you rate Airhanh? 1(Terrible) to 100(Fantastic)</h3>
            <input name="rating" type="range" min="1" max="100" value="50" id="rating">
            <span>Rating:</span>
            <span id="f" style="font-weight:bold;color:red"></span>
            <br>
            <script>
                var slideCol = document.getElementById("rating");
                var y = document.getElementById("f");

                y.innerHTML = slideCol.value;

                slideCol.oninput = function () {
                    y.innerHTML = this.value;
                }
            </script>
        </div>

        <div class="container">
            <button type="submit" name="savetodb">Save Preferences</button>
        </div>
    </form>
    <form action="viewdata.php">
        <input type="submit" value="View Everyones Preferences" />
    </form>
</body>
</html>