<?php

    // session_start();

    error_reporting(0);
    
    session_destroy();

    if( isset($_COOKIE["CMS_usr_Id"]) && 
        isset($_COOKIE["CMS_usrname"]) && 
        isset($_COOKIE["CMS_usrlevel"]) ){

        setcookie("CMS_usr_Id", $_COOKIE["CMS_usr_Id"], time()-3600 * 24 * 365, '/');
        setcookie("CMS_usrname", $_COOKIE["CMS_usrname"], time()-3600 * 24 * 365, '/');
        setcookie("CMS_usrlevel", $_COOKIE["CMS_usrlevel"], time()-3600 * 24 * 365, '/');
    
        echo "<script>location.href='../login.php';</script>";

    }
    

?>