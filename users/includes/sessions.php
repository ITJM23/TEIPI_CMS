<?php

    if(!isset($_COOKIE['CMS_usr_Id'])){

        echo "<script>location.href='../users/login.php';</script>";
    }

    // else if($_COOKIE['CMS_usr_Id'] == '' || $_COOKIE['CMS_usr_Id'] == null){

    //     echo "<script>location.href='../users/login.php';</script>";
    // }

    // else{

    //     if($_COOKIE['CMS_usr_Id'] == '' || $_COOKIE['CMS_usr_Id'] == null){

    //         echo "<script>location.href='../login.php';</script>";
    //     }
    // }

?>