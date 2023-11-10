<?php

    if(isset($_COOKIE['CMS_usrlevel'])){

        if($_COOKIE['CMS_usrlevel'] == 1){

            echo "<script>location.href='index.php';</script>";
        }

        else if($_COOKIE['CMS_usrlevel'] == 2){

            echo "<script>location.href='index.php';</script>";
        }
    }
    
?>