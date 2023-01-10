<?php

declare(strict_types=1);

// Function is called from roomCheck.php if booking of specific dates is possible.
// Function handles booking requests and sends data to the database.
function booking($arrDate, $depDate, $room) {
    // Connects to database file
    $database = new PDO("sqlite:bookings.db");

    // Prepares a SQL statement for execution.
    $statement = $database->prepare('INSERT INTO bookings (arr_date, dep_date, room) VALUES (date(:arrDate), date(:depDate), :room)');

    // Binds a parameter to the specified variable name.
    $statement->bindParam(":arrDate", $arrDate, PDO::PARAM_STR);

    $statement->bindParam(":depDate", $depDate, PDO::PARAM_STR);

    $statement->bindParam(":room", $room, PDO::PARAM_STR);

    // Executes the prepared statement.
    $statement->execute();
}

