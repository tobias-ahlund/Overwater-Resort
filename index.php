<?php

declare(strict_types=1);

// Magnus V. - session-logic. Used to keep track of login and logut.
session_start();

$authenticated = $_SESSION['authenticated'] ?? false;
//

require_once "showBookingsBudget.php";
require_once "showBookingsStandard.php";
require_once "showBookingsLuxury.php";
require_once "roomCheck.php";
require_once "bookingConfirmed.php";
require_once "checkTransferCode.php";
require_once "receipt.php";

// Magnus V. - This one holds the function needed to write ot the extra features from the database:
require_once "app/users/addFeatures.php";

// Magnus V. - Reworked the index.php to be composed of three different php-files. This way the header and footer can be used with other pages.
require_once "header.php";
require_once "main.php";
require_once "footer.php";
