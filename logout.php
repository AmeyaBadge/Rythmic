<?php

session_start();
session_unset();
session_destroy();

require('admin/comps/functions.php');
redirect('login.php');
?>