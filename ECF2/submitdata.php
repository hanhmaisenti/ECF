<?php
//Functions here - Note, globals cannot be accessed inside functions. pass everything into this!
function AddNewUser($mysqli, $email,$flight,$fname,$lname,$starter,$maincourse,$rating,$newdesserts){
    $sql = "INSERT INTO people (email, flight, fname, lname, starter, maincourse, rating) VALUES ('$email','$flight','$fname','$lname','$starter','$maincourse','$rating')";
    if ( $mysqli->query($sql) ){
        //it worked. Get the unique ID
        $uniqueid = $mysqli->insert_id; 
        //now cycle through and save all the desserts the user chose against the new unique ID
        //it will do nothing if no desserts were selected
        foreach($newdesserts as $newdessert){
            //now we have the ID, we can save all the dessert preferences for that particular email address
            //Should really error check here but not for now.
            $mysqli->query("INSERT INTO desserts (id, dessert) VALUES ('$uniqueid','$newdessert')");
        }
    } else {
        return true;  //it didnt work. True means error
    }
    return false; //no error
}

//#### REST OF CODE ####
//get all post data from main page
$email      = $_POST['email'];
$flight     = $_POST['flightnumber'];
$fname      = $_POST['firstname'];
$lname      = $_POST['lastname'];
$starter    = $_POST['starter'];
$maincourse = $_POST['maincourse'];
$rating     = $_POST['rating'];
$newdesserts= $_POST['desserts']; //multiple instances of this may arrive

//first we need to look for the persons email address
$result = $mysqli->query("SELECT * FROM people WHERE email='$email'");
if ( $result->num_rows == 0 ){
    // User doesn't exist. Add a new user
    AddNewUser($mysqli, $email,$flight,$fname,$lname,$starter,$maincourse,$rating,$newdesserts);
    
}
else {
    // User already exists. Now check the flight number. If its the same we need to update the preferences for that flight
    $myuser = $result->fetch_assoc();
    $userID = $myuser['id'];
//    var_dump ($myuser);

    if ($flight == $myuser['flight']) {
        //same email and flight. So, just update the food preferences, not personal details.
        $mysqli->query("UPDATE people SET starter='$starter',maincourse='$maincourse',rating='$rating' WHERE id='$userID'");
        
        //this part is fiddly. we need to syncronise the desserts!
        //get the existing records
        $result = $mysqli->query("SELECT * FROM desserts WHERE id='$userID'");
        
        if ( $result->num_rows == 0 ){
            //nothing there anyway. Go ahead and add everything
            foreach($newdesserts as $dessert){
                $mysqli->query("INSERT INTO desserts (id, dessert) VALUES ('$userID','$dessert')");
            }    
        } else {
            //We need to do TWO rounds. one to look for new entries, the other to look for REMOVED entries            

            //ADD STUFF            
            //NEW DESSERTS
            foreach ($newdesserts as $newdessert)
            {    
                $found = false;
                //OLD DESSERTS
                mysqli_data_seek($result,0); //reset the pointer
                while($existingdessert = $result->fetch_assoc())
                {
    
                    if ($existingdessert['dessert'] == $newdessert)
                    {
                        $found = true;
                        break 1; //only break out of one level
                    }
                }

                if (!$found)
                {
                    //it wasnt found. Add it
                    $mysqli->query("INSERT INTO desserts (id, dessert) VALUES ('$userID','$newdessert')");
                }
            }

            //REMOVE STUFF
            //OLD DESSERTS
            mysqli_data_seek($result,0); //reset the pointer
            while($existingdessert = $result->fetch_assoc())
            {
                $found = false;
                //NEW DESSERTS
                foreach ($newdesserts as $newdessert)
                {
                    if ($existingdessert['dessert'] == $newdessert)
                    {
                        $found = true;
                        break 1; //only break out of one level
                    }
                }

                if (!$found)
                {
                    //it wasnt found. remove it
                    $mysqli->query("DELETE FROM desserts WHERE id='$userID' AND dessert='".$existingdessert['dessert']."'");
                }
            }
        }
    } else {
        //different flight. add another unique record
        AddNewUser($mysqli,$email,$flight,$fname,$lname,$starter,$maincourse,$rating,$desserts);
    }
}
?>