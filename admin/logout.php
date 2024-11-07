<?php

if(isset($_POST['logoutBtn'])){
    session_start();
    require 'comps/connection.php';
    require 'comps/functions.php';
    session_unset();
    session_destroy();

    redirect('login.php');
}
?>