<?php

require_once('functions/index.php');

if(logged_in() == false){
  header('Location: /login');
  die;
}

switch($_GET['page']){
    case 'kiosks':
        switch($_GET['action']){
            case 'delete':
                $sql = "DELETE FROM " . PREFIX . "kiosks WHERE ID=" . $_GET['content'];

                if ($conn->query($sql) === TRUE) {
                    header('Location: /admin/kiosks');
                } else {
                    echo "Error deleting record: " . $conn->error;
                }
                break;
        }
        break;
    case 'users':
        switch($_GET['action']){
            case 'add':
                $sql = "SELECT * FROM " . PREFIX . "users WHERE ID='" . $_GET['user'] . "'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $array = unserialize($row['ACCESS']);
                
                if(!in_array($_GET['content'], $array)){
                $array[] = $_GET['content'];
                }
                
                $sql = "UPDATE " . PREFIX . "users SET ACCESS='" . serialize($array) . "' WHERE ID='" . $_GET['user'] . "'";
                if ($conn->query($sql) === TRUE) {
                    header('Location: /admin/users/edit/' . $_GET['user']);
                    die;
                } else {
                    echo "Error updating record: " . $conn->error;
                }
                $conn->close();
                break;
            case 'remove':
                
                
                $sql = "SELECT * FROM " . PREFIX . "users WHERE ID='" . $_GET['user'] . "'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $array = unserialize($row['ACCESS']);
                $key = array_search($_GET['content'], $array);
                if (false !== $key) {
                    unset($array[$key]);
                }
                
                $sql = "UPDATE " . PREFIX . "users SET ACCESS='" . serialize($array) . "' WHERE ID='" . $_GET['user'] . "'";
                if ($conn->query($sql) === TRUE) {
                   header('Location: /admin/users/edit/' . $_GET['user']);
                    die;
                } else {
                    echo "Error updating record: " . $conn->error;
                }
                $conn->close();
                break;
            case 'create':
                $username = $_GET['username'];
                $fullname = $_GET['name'];
                $password = 'invalid';
                $email = $_GET['email'];
                $array = array();
                $access = serialize($array);
                $sql = "INSERT INTO " . PREFIX . "users (USERNAME,FULLNAME,PASSWORD,EMAIL,ROLE,ACCESS) VALUES ('$username','$fullname','$password','$email','0','$access')";
                echo $sql;
                if ($conn->query($sql) === TRUE) {
                    header('Location: /admin/users');
                    die;
                } else {
                    echo "Error deleting record: " . $conn->error;
                }
                $conn->close();
                break;
            case 'reset':
                $hash = md5($_GET['content']);
                $sql = "UPDATE " . PREFIX . "users SET PASSWORD='" . $hash . "' WHERE ID='" . $_GET['user'] . "'";
                if ($conn->query($sql) === TRUE) {
                   header('Location: /admin/users/edit/' . $_GET['user']);
                    die;
                } else {
                    echo "Error updating record: " . $conn->error;
                }
                $conn->close();
                break;
            case 'makeadmin':
                $sql = "UPDATE " . PREFIX . "users SET ROLE='1' WHERE ID='" . $_GET['content'] . "'";
                if ($conn->query($sql) === TRUE) {
                   header('Location: /admin/users/edit/' . $_GET['content']);
                    die;
                } else {
                    echo "Error updating record: " . $conn->error;
                }
                $conn->close();
                break;
            case 'removeadmin':
                $sql = "UPDATE " . PREFIX . "users SET ROLE='0' WHERE ID='" . $_GET['content'] . "'";
                if ($conn->query($sql) === TRUE) {
                   header('Location: /admin/users/edit/' . $_GET['content']);
                    die;
                } else {
                    echo "Error updating record: " . $conn->error;
                }
                $conn->close();
                break;
        }
        die;
        break;
    case 'programs':
        switch($_GET['action']){
            case 'delete':
                $sql = "DELETE FROM " . PREFIX . "programs WHERE ID=" . $_GET['content'];

                if ($conn->query($sql) === TRUE) {
                    header('Location: /admin/programs');
                    die;
                } else {
                    echo "Error deleting record: " . $conn->error;
                }
                $conn->close();
                break;
            case 'create':
                $array = array(
                      'descs' => 
                      array (
                        0 => 'Sample Description',
                      ),
                      'desc_title' => 'Description',
                      'other' => 0,
                      'duration' => 0,
                      'signature' => 0,
                    );
                $settingsarray = serialize($array);
                $sql = "INSERT INTO " . PREFIX . "programs (name, kiosks, settings) VALUES ('" . $_GET['content'] . "', '" . serialize(array()) . "', '" . $settingsarray . "')";

                if ($conn->query($sql) === TRUE) {
                    header('Location: /admin/programs');
                    die;
                } else {
                    echo "Error deleting record: " . $conn->error;
                }
                $conn->close();
                break;
        }
        break;
    case 'settings':
        switch($_GET['action']){
            case 'add':
                $sql = "SELECT * FROM " . PREFIX . "programs WHERE name='" . str_replace("-"," ",$_GET['program']) . "'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $array = unserialize($row['kiosks']);
                
                if(!in_array($_GET['content'], $array)){
                $array[] = $_GET['content'];
                }
                
                $sql = "UPDATE " . PREFIX . "programs SET kiosks='" . serialize($array) . "' WHERE name='" . str_replace("-"," ",$_GET['program']) . "'";
                if ($conn->query($sql) === TRUE) {
                    header('Location: /programs/' . $_GET['program'] . '/kiosks');
                    die;
                } else {
                    echo "Error updating record: " . $conn->error;
                }
                $conn->close();
                break;
            case 'remove':
                
                
                $sql = "SELECT * FROM " . PREFIX . "programs WHERE name='" . str_replace("-"," ",$_GET['program']) . "'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $array = unserialize($row['kiosks']);
                $key = array_search($_GET['content'], $array);
                if (false !== $key) {
                    unset($array[$key]);
                }
                
                $sql = "UPDATE " . PREFIX . "programs SET kiosks='" . serialize($array) . "' WHERE name='" . str_replace("-"," ",$_GET['program']) . "'";
                if ($conn->query($sql) === TRUE) {
                    header('Location: /programs/' . $_GET['program'] . '/kiosks');
                    die;
                } else {
                    echo "Error updating record: " . $conn->error;
                }
                $conn->close();
                break;
            case 'update':
                $descs = $_GET['descs'];
                $descs = explode("\n", $descs);
                foreach($descs as $k => $v){
                $descs[$k] = rtrim($descs[$k]);
                }
                $programs['descs'] = $descs;
                $programs['single_transaction'] = $_GET['single_transaction'];
                $programs['single_instance'] = $_GET['single_instance'];
                $programs['require_first'] = $_GET['require_first'];
                $programs['order'] = $_GET['order'];
                $programs['other'] = $_GET['other'];
                $programs['signature'] = $_GET['signature'];
                $programs['duration'] = $_GET['duration'];
                $programs['desc_title'] = $_GET['desc_title'];
                
                $sql = "UPDATE " . PREFIX . "programs SET settings='" . serialize($programs) . "' WHERE name='" . str_replace("-"," ",$_GET['program']) . "'";
                if ($conn->query($sql) === TRUE) {
                    header('Location: /programs/' . $_GET['program'] . '/settings');
                    die;
                } else {
                    echo "Error updating record: " . $conn->error;
                }
                $conn->close();
                break;
        }
        break;
}