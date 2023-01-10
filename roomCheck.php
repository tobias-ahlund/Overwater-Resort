<?php

declare(strict_types=1);

require_once "bookingConfirmed.php";
require_once "receipt.php";
require_once "moneyTransfer.php";
require_once "checkTransferCode.php";

// Function is called from checkTransferCode.php with a valid transfer code as argument.
function transferCodeSuccess($transferCode, $totalCost)
{
    // Checks if POST variables are set nad pass them as parameters to the checkRoomAvailable function.
    if (isset($_POST["arrDate"], $_POST["depDate"])) :
        $arrDate = $_POST["arrDate"];
        $depDate = $_POST["depDate"];
        $room = $_POST["room"];

        return checkRoomAvailable($arrDate, $depDate, $room, $transferCode);
    endif;
}

// Checks if the room is already booked or not. If not, booking is made and receipt is created. Error message is displayed if booking error occurs.
function checkRoomAvailable($arrDate, $depDate, $room, $transferCode)
{
    $database = new PDO("sqlite:bookings.db");

    // Old query.
    /* $statement = $database->prepare('SELECT * FROM bookings WHERE arr_date BETWEEN :arrDate AND :depDate AND room = :room OR dep_date BETWEEN :arrDate AND :depDate AND room = :room'); */

    $statement = $database->prepare('SELECT * FROM bookings WHERE arr_date BETWEEN :arrDate AND :depDate AND room = :room OR dep_date BETWEEN DATE(:arrDate, "+1 day") AND :depDate AND room = :room');

    $statement->bindParam(":arrDate", $arrDate, PDO::PARAM_STR);

    $statement->bindParam(":depDate", $depDate, PDO::PARAM_STR);

    $statement->bindParam(":room", $room, PDO::PARAM_STR);

    $statement->execute();

    $bookings = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (empty($bookings) && $arrDate != $depDate && $arrDate < $depDate) : ?>
        <?php echo booking($arrDate, $depDate, $room);
        moneyTransfer($transferCode);
        
        if ($room == "budget") :
            $cost = "1";
        elseif ($room == "standard") :
            $cost = "2";
        elseif ($room == "luxury") :
            $cost = "3";
        endif;

        $arrDate = new DateTime($arrDate);
        $depDate = new DateTime($depDate);
        $period = date_diff($arrDate, $depDate);
        $days = $period->days;
        $arrDate = $arrDate->format("Y-m-d"); 
        $depDate = $depDate->format("Y-m-d"); 
        
        $totalCost = $cost * $days;

        // $1 discount if more than one night is booked.
        if ($room == "budget" && $totalCost > "1") :
            $totalCost -= "1";
        elseif ($room == "standard" && $totalCost > "2") :
            $totalCost -= "1";
        elseif ($room == "luxury" && $totalCost > "3") :
                $totalCost -= "1";
        endif;

        return receipt($arrDate, $depDate, $totalCost);
    elseif (!empty($bookings)) : ?>
        <div class="booking-fail">
            <p>We are sorry. The room is already booked during your chosen period. Please try other dates.</p>
            <button class="booking-fail-button">Okay</button>
        </div>
    <?php elseif ($arrDate === $depDate || $arrDate > $depDate) : ?>
        <div class="booking-fail">
            <p>We are sorry. We are unable to fulfill you request. Please try other dates.</p>
            <button class="booking-fail-button">Okay</button>
        </div>
    <?php endif;
}
