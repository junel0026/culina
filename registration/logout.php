<?php
session_start();
session_destroy();
header("Location: /culina/index.php");
exit;
