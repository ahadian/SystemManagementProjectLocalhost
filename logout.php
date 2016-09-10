<?php
session_start();
unset($_SESSION['usr_manage']);
session_destroy();
?>
<meta http-equiv="refresh" content="0;http://localhost/">