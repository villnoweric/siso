<?php

if(!file_exists('../config/db.php')){
    header('Location: db.php');
    die();
}


if(!file_exists('../config/district.php')){
    header('Location: general.php');
    die();
}

header('Location: ../');

?>