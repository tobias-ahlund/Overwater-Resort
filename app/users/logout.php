<?php

declare(strict_types=1);

session_start();

$authenticated = $_SESSION['authenticated'] ?? false;

if (!$authenticated) : header("location: ../../index.php");
else : unset($_SESSION['authenticated']);
    session_destroy();
    header("location: ../../index.php");
endif;
