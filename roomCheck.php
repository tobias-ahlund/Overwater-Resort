<?php

declare(strict_types=1);

require_once "bookingConfirmed.php";
require_once "receipt.php";
require_once "moneyTransfer.php";
require_once "checkTransferCode.php";

// Magnus V. - This is required beacause fetching the extra_features-table is needed to check if some of the extra features are set:
// require "app/users/addFeatures.php"; WTF!!! Redeclare error!?

// Function is called from checkTransferCode.php with a valid transfer code as argument.
function transferCodeSuccess($transferCode, $totalCost)
{
    // Checks if POST variables are set nad pass them as parameters to the checkRoomAvailable function.
    if (isset($_POST["arrDate"], $_POST["depDate"])) :
        $arrDate = $_POST["arrDate"];
        $depDate = $_POST["depDate"];
        $room = $_POST["room"];

        // Magnus V. - Added (parts of) this logic (again) to include selected extra features: |--- --- --->
        $path = './';
        $dbh = connectBookingsDatabase($path);
        $currentExtraFeatures = getFeaturesFromDatabase($dbh);

        foreach ($currentExtraFeatures as $featureNr => $features) :
            $postExtraFeatureName = str_replace(" ", "-", strtolower($features['feature_name']));
            $checkIssetExtraFeatures = isset($_POST[$postExtraFeatureName]);

            if ($checkIssetExtraFeatures) :
                foreach ($_POST[$postExtraFeatureName] as $value) :
                    $selectedExtraFeatures[] = ['feature' => $features['feature_name'], 'featureCost' => (int)$value];
                endforeach;
            // Magnus V. - 26 jan-23. Late bug-fixing. Added this variable-definiton to prevent errors when no extra features are selected:
            else : $selectedExtraFeatures[] = ['feature' => "", 'featureCost' => 0];
            endif;

        endforeach;

        // <--- --- ---|

        return checkRoomAvailable($arrDate, $depDate, $room, $transferCode, $selectedExtraFeatures);
    endif;
}

// Checks if the room is already booked or not. If not, booking is made and receipt is created. Error message is displayed if booking error occurs.
// Magnus V. - Added "$selectedExtraFeatures" to this function. The idea is to complete the receipt with extra features.
function checkRoomAvailable($arrDate, $depDate, $room, $transferCode, $selectedExtraFeatures)
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
        <?php echo booking($arrDate, $depDate, $room, $selectedExtraFeatures);
        moneyTransfer($transferCode);

        // Magnus V. - The same hard-scripted logic here again. It's almost 11PM. Why are you doing this to me? :(
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

        // Magnus V. This will modify $totalCost to include the selected extra features:
        $extrasCost = 0;

        foreach ($selectedExtraFeatures as $selectedExtraFeature) :
            $extrasCost += $selectedExtraFeature['featureCost'];
        endforeach;

        $totalExtrasCost = $extrasCost * $days;
        $totalBookingCost = $cost * $days;

        // $1 discount if more than one night is booked.
        // Magnus V - Rewrote this part a little to just handle the room-cost:
        if ($room == "budget" && $totalBookingCost > "1") :
            $totalBookingCost -= "1";
        elseif ($room == "standard" && $totalBookingCost > "2") :
            $totalBookingCost -= "1";
        elseif ($room == "luxury" && $totalBookingCost > "3") :
            $totalBookingCost -= "1";
        endif;

        $totalCost = $totalBookingCost + $totalExtrasCost;

        //Magnus V. - Added the array with selected extra features, to be added to the receipt.
        return receipt($arrDate, $depDate, $totalCost, $selectedExtraFeatures);
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
