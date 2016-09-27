<?php

if(!isset($_POST['install_step'])){
    header('Location: index.php');
    die;
}

session_start();

switch($_POST['install_step']){
    case 'db':
        
        $SERVER = $_POST['db_server'];
        $USER = $_POST['db_user'];
        $PASS = $_POST['db_pass'];
        $DB = $_POST['db_db'];
        $PREFIX = $_POST['db_prefix'];
        
        $dbconfig = fopen(__DIR__. "/../config/db.php", "w");
        $config = "<?php
        
        define('SERVER', '" . $SERVER . "');
        define('USER', '" . $USER . "');
        define('PASSWORD', '" . $PASS . "');
        define('DB', '" . $DB . "');
        define('PREFIX', '" . $PREFIX . "_');
        ";
        
        fwrite($dbconfig, $config);
        fclose($dbconfig);
        
        require_once(__DIR__. '/../config/db.php');
        $conn = mysqli_connect(SERVER, USER, PASSWORD, DB);
        
        // sql to create table
        $sql = "CREATE TABLE `" . $PREFIX . "_users` (
         `ID` int(11) NOT NULL AUTO_INCREMENT,
         `USERNAME` text NOT NULL,
         `FULLNAME` text NOT NULL,
         `PASSWORD` text NOT NULL,
         `EMAIL` text NOT NULL,
         `ROLE` int(11) NOT NULL,
         `ACCESS` text NOT NULL,
         PRIMARY KEY (`ID`),
         UNIQUE KEY `ID` (`ID`),
         KEY `ID_2` (`ID`)
        )";
        
        if ($conn->query($sql) === TRUE) {
        } else {
            echo "Error creating table: " . $conn->error;
            die();
        }
        
        $sql = "CREATE TABLE `" . $PREFIX . "_programs` (
         `ID` int(11) NOT NULL AUTO_INCREMENT,
         `name` text NOT NULL,
         `settings` text NOT NULL,
         `kiosks` text NOT NULL,
         PRIMARY KEY (`ID`),
         UNIQUE KEY `ID` (`ID`)
        )";
        
        if ($conn->query($sql) === TRUE) {
        } else {
            echo "Error creating table: " . $conn->error;
            die();
        }
        
        $sql = "CREATE TABLE `" . $PREFIX . "_kiosks` (
         `ID` int(11) NOT NULL AUTO_INCREMENT,
         `apid` int(11) NOT NULL,
         `name` text NOT NULL,
         `expire` int(11) NOT NULL,
         PRIMARY KEY (`ID`),
         UNIQUE KEY `ID` (`ID`)
        )";
        
        if ($conn->query($sql) === TRUE) {
        } else {
            echo "Error creating table: " . $conn->error;
            die();
        }
        
        $sql = "CREATE TABLE `" . $PREFIX . "_data` (
         `ID` int(11) NOT NULL AUTO_INCREMENT,
         `Name` text NOT NULL,
         `Signature` text,
         `Signin` datetime DEFAULT NULL,
         `Signout` datetime DEFAULT NULL,
         `Description` text NOT NULL,
         `Verify` int(11) NOT NULL,
         `Program` int(11) NOT NULL,
         PRIMARY KEY (`ID`),
         UNIQUE KEY `ID` (`ID`)
        )";
        
        if ($conn->query($sql) === TRUE) {
        } else {
            echo "Error creating table: " . $conn->error;
            die();
        }
        
        header('Location: index.php');
        die;
        break;
    case 'general':
        $_SESSION['district_name'] = $_POST['district_name'];
        $_SESSION['timezone'] = $_POST['timezone'];
        $_SESSION['dir_name'] = $_POST['dir_name'];
        header('Location: users.php');
        break;
    case 'users':
        $_SESSION['admin_name'] = $_POST['admin_name'];
        $_SESSION['admin_username'] = $_POST['admin_username'];
        $_SESSION['admin_password'] = $_POST['admin_password'];
        $_SESSION['admin_email'] = $_POST['admin_email'];
        
        $districtconfig = fopen(__DIR__. "/../config/district.php", "w");
        $config = "<?php
        
        define('DISTRICT_NAME', '" . $_SESSION['district_name'] . "');
        define('TIMEZONE', '" . $_SESSION['timezone'] . "');
        define('PATH', '" . $_SESSION['dir_name'] . "');
        //MORE SETTINGS TO COME!
        ";
        
        fwrite($districtconfig, $config);
        fclose($districtconfig);
        
        $pass_hash = md5($_SESSION['admin_password']);
        $array = array();
        
        require_once(__DIR__. '/../config/db.php');
        $conn = mysqli_connect(SERVER, USER, PASSWORD, DB);
        
        $sql = "INSERT INTO " . PREFIX . "users (USERNAME, FULLNAME, EMAIL, PASSWORD, ROLE, ACCESS)
        VALUES ('" . $_SESSION['admin_username'] . "', '" . $_SESSION['admin_name'] . "', '" . $_SESSION['admin_email'] . "', '" . $pass_hash . "', 1, '" . $array . "')";
        
        if ($conn->query($sql) === TRUE) {
        } else {
            echo "Error creating table: " . $conn->error;
            die();
        }
        
        header('Location: ../');
        break;
}