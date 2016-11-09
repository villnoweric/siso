<?php
//echo '9.';
//GET DB
require_once('functions/index.php');

//PREVENT DIRECT ACCESS
if(!isset($_POST['Name'])){
    die('You cannot access this page directly!');
}

//REQUIRED CHECK
if(empty($_POST['Name'])){
    header('Location: ./kiosk/' . $_POST['redirect'] . '?m=4');
    die;
}

if(empty($_POST['Reason'])){
    header('Location: ./kiosk/' . $_POST['redirect'] . '?m=5');
    die;
}
//echo '10.';
//GETS SETTINGS OFF DB
$program_sql = "SELECT * FROM " . PREFIX . "programs WHERE ID='" . $_POST['program'] . "'";
$program_result = $conn->query($program_sql);
$program = $program_result->fetch_assoc();
$program['settings'] = unserialize($program['settings']);

$Time = date('Y-m-d H:i:s');
$Check_Time = date('Y-m-d');

//Check if user has previous instance
$instance_sql = "SELECT * FROM " . PREFIX . "data WHERE Name='" . $_POST['Name'] . "' AND Program='" . $_POST['program'] . "' AND ( Signin LIKE '%$Check_Time%' OR Signout LIKE '%$Check_Time%' ) ORDER BY ID DESC";
$instance_result = $conn->query($instance_sql);

$instances = $instance_result->num_rows;
$instance = $instance_result->fetch_assoc();

if(is_null($instance['Signin'])){
    $si = 0;
}else{
    $si = 1;
}
if(is_null($instance['Signout'])){
    $so = 0;
}else{
    $so = 1;
}

$task = $_POST['task'];
$Name = $_POST['Name'];
$Program = $_POST['program'];

if(isset($_POST['Reason'])){
    $Reason = $_POST['Reason'];
    if($Reason == 'Other' && isset($_POST['otherReason'])){
        $Reason = 'Other: ' . $_POST['otherReason'];
    }
}

if($program['settings']['order'] == '1'){
    //ECL
    if($task == 'in'){
        if($instances == 0){
            if($program['settings']['signature'] == '0'){
                $sql = "INSERT INTO " . PREFIX . "data (Name, Signin, Description, Program) VALUES ('$Name', '$Time', '$Reason', '$Program')";
            }else{
                //$Signature = $_POST['Signature'];
                //$sql = "INSERT INTO " . PREFIX . "data (Name, Signature, Signin, Description, Program) VALUES ('$Name', '$Signature' '$Time', '$Reason', '$Program')";
            }
            if ($conn->query($sql) === TRUE) {
                header('Location: ./kiosk/' . $_POST['redirect'] . '?m=2');
                die;
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }else{
            if($si == 1 && $so == 0){
                header('Location: ./kiosk/' . $_POST['redirect'] . '?m=8');
                die;
            }elseif($si == 1 && $so == 1){
                header('Location: ./kiosk/' . $_POST['redirect'] . '?m=9');
                die;
            }elseif($si == 0 && $so == 1){
                header('Location: ./kiosk/' . $_POST['redirect'] . '?m=69&c=order1si0so1');
                die;
            }
        }
    }else{
        if($instances == 0){
            header('Location: ./kiosk/' . $_POST['redirect'] . '?m=7');
            die;
        }else{
            if($si == 1 && $so == 0){
                //echo '6';
                $sql = "UPDATE " . PREFIX . "data SET Signout='$Time' WHERE Name='$Name' AND Program='$Program' AND DATE_FORMAT(Signin, '%Y-%m-%d')='$Check_Time' AND Signout IS NULL";
                if ($conn->query($sql) === TRUE) {
                    header('Location: ./kiosk/' . $_POST['redirect'] . '?m=3');
                    die;
                } else {
                    echo "Error updating record: " . $conn->error;
                }
            }elseif($si == 1 && $so == 1){
                header('Location: ./kiosk/' . $_POST['redirect'] . '?m=9');
                die;
            }elseif($si == 0 && $so == 1){
                header('Location: ./kiosk/' . $_POST['redirect'] . '?m=69&c=order1si0so1');
                die;
            }
        }
    }
}else{
    //echo '9';
    //Attendance
    if($task == 'in'){
        if($instances == 0){
            if($program['settings']['signature'] == '0'){
                $sql = "INSERT INTO " . PREFIX . "data (Name, Signin, Description, Program) VALUES ('$Name', '$Time', '$Reason', '$Program')";
            }else{
                //$Signature = $_POST['Signature'];
                //$sql = "INSERT INTO " . PREFIX . "data (Name, Signature, Signin, Description, Program) VALUES ('$Name', '$Signature' '$Time', '$Reason', '$Program')";
            }
            if ($conn->query($sql) === TRUE) {
                header('Location: ./kiosk/' . $_POST['redirect'] . 'm=3');
                die;
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }else{
            if($si == 1 && $so == 0){
                header('Location: ./kiosk/' . $_POST['redirect'] . '?m=8');
                die;
            }elseif($si == 1 && $so == 1){
                header('Location: ./kiosk/' . $_POST['redirect'] . '?m=8');
                die;
            }elseif($si == 0 && $so == 1){
                $sql = "UPDATE " . PREFIX . "data SET Signin='$Time' WHERE Name='$Name' AND Program='$Program' AND DATE_FORMAT(Signout, '%Y-%m-%d')='$Check_Time' AND Signin IS NULL";
                if ($conn->query($sql) === TRUE) {
                    header('Location: ./kiosk/' . $_POST['redirect'] . '?m=2');
                    die;
                } else {
                    echo "Error updating record: " . $conn->error;
                }
            }
        }
    }else{
        if($instances == 0){
           if($program['settings']['signature'] == '0'){
                $sql = "INSERT INTO " . PREFIX . "data (Name, Signout, Description, Program) VALUES ('$Name', '$Time', '$Reason', '$Program')";
            }else{
                //$Signature = $_POST['Signature'];
                //$sql = "INSERT INTO " . PREFIX . "data (Name, Signature, Signin, Description, Program) VALUES ('$Name', '$Signature' '$Time', '$Reason', '$Program')";
            }
            if ($conn->query($sql) === TRUE) {
                header('Location: ./kiosk/' . $_POST['redirect']);
                die;
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }else{
            if($si == 1 && $so == 0){
               if($program['settings']['signature'] == '0'){
                    $sql = "INSERT INTO " . PREFIX . "data (Name, Signout, Description, Program) VALUES ('$Name', '$Time', '$Reason', '$Program')";
                }else{
                    //$Signature = $_POST['Signature'];
                    //$sql = "INSERT INTO " . PREFIX . "data (Name, Signature, Signin, Description, Program) VALUES ('$Name', '$Signature' '$Time', '$Reason', '$Program')";
                }
                if ($conn->query($sql) === TRUE) {
                    header('Location: ./kiosk/' . $_POST['redirect']);
                    die;
                } else {
                    echo "Error updating record: " . $conn->error;
                }
            }elseif($si == 1 && $so == 1){
                if($program['settings']['signature'] == '0'){
                    $sql = "INSERT INTO " . PREFIX . "data (Name, Signout, Description, Program) VALUES ('$Name', '$Time', '$Reason', '$Program')";
                }else{
                    //$Signature = $_POST['Signature'];
                    //$sql = "INSERT INTO " . PREFIX . "data (Name, Signature, Signin, Description, Program) VALUES ('$Name', '$Signature' '$Time', '$Reason', '$Program')";
                }
                if ($conn->query($sql) === TRUE) {
                    header('Location: ./kiosk/' . $_POST['redirect']);
                    die;
                } else {
                    echo "Error updating record: " . $conn->error;
                }
            }elseif($si == 0 && $so == 1){
                header('Location: ./kiosk/' . $_POST['redirect'] . '?m=10');
                die;
            }
        }
    }
}

?>