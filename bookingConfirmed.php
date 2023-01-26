<?php

declare(strict_types=1);

// Function is called from roomCheck.php if booking of specific dates is possible.
// Function handles booking requests and sends data to the database.
// Magnus V. - Added $selectedExtraFeatures to this function. It will be sent to a nested function beneath:
function booking($arrDate, $depDate, $room, $selectedExtraFeatures)
{
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

    // Magnus V. - Aaaaaand finally the function that puts the selected extra features in the database is put here:
    foreach ($selectedExtraFeatures as $selectedExtraFeature) {
        if ($selectedExtraFeature['feature'] != "") {
            foreach ($selectedExtraFeatures as $selectedExtraFeature) {
                // Magnus V. - This creates an array that only contains the extra features that was actually selected:
                if ($selectedExtraFeature['feature'] != "") {
                    $cleanFeaturesList[] = $selectedExtraFeature;
                }
            }
            // Magnus V - Adds extra features to table extra_features_selected if they were selected:
            bookingAddSelectedFeatures($arrDate, $room, $cleanFeaturesList);
            break;
        }
    }
}

// Magnus V. - (Seriously, this is the last function I'm gonna create for this webpage) This will be appended to booking-function, and will add the selected extra features to the "extra featueres selected"-table:
function bookingAddSelectedFeatures($arrDate, $room, $selectedExtraFeatures)
{
    $database = new PDO("sqlite:bookings.db");

    foreach ($selectedExtraFeatures as $selectedExtraFeature) :

        $featureName = $selectedExtraFeature['feature'];

        // Prepares a SQL statement for execution.
        $statement = $database->prepare('INSERT INTO extra_features_selected (feature_name, arr_date, room_id) VALUES (:feature_name, date(:arrDate), :room)');

        // Binds a parameter to the specified variable name.
        $statement->bindParam(":feature_name", $featureName, PDO::PARAM_STR);

        $statement->bindParam(":arrDate", $arrDate, PDO::PARAM_STR);

        $statement->bindParam(":room", $room, PDO::PARAM_STR);

        // Executes the prepared statement.
        $statement->execute();

    endforeach;
}
