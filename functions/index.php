<?php
session_start();

//DATABASE
require_once(__DIR__ . '/../config/db.php');

$conn = mysqli_connect(SERVER, USER, PASSWORD, DB);

//SCOOL SETTINGS
require_once(__DIR__ . '/../config/district.php');

date_default_timezone_set(TIMEZONE);

function user_role(){
    return 1;
}

if(!isset($_COOKIE['USERNAME'])){

function logged_in(){
    $sql="SELECT * FROM " . PREFIX . "users WHERE username='" . $_COOKIE['USERNAME'] . "' AND password='" . $_COOKIE['PASSWORD'] . "'";
    $result=mysqli_query($GLOBALS['conn'],$sql);
    if(mysqli_num_rows($result) > 0){
        return true;
    }else{
        return false;
    }
}

function user_info($info){
    $sql = "SELECT " . $info . " FROM " . PREFIX . "users WHERE username='" . $_COOKIE['USERNAME'] . "' AND password='" . $_COOKIE['PASSWORD'] . "'";
    $result = $GLOBALS['conn']->query($sql);
    $row = $result->fetch_assoc();

    if ($result->num_rows > 0) {
        return $row[$info];
    } else {
    }   
}

}

?>