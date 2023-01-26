<?php

declare(strict_types=1);

require "vendor/autoload.php";
require_once "moneyTransfer.php";

// Magnus V. - This is required beacause fetching the extra_features-table is needed to check if some of the extra features are set:
require "app/users/addFeatures.php";

// Using Guzzle for POST requests.
use GuzzleHttp\Client;

// Conditional that calls a function if the POST variables are set, and calculates the total cost of the hotel room.
if (isset($_POST["transferCode"], $_POST["room"], $_POST["arrDate"], $_POST["depDate"])) :
    $room = $_POST["room"];
    if ($room == "budget") :
        $cost = 1;
    elseif ($room == "standard") :
        $cost = 2;
    elseif ($room == "luxury") :
        $cost = 3;
    endif;

    $arrDate = $_POST["arrDate"];
    $arrDate = new DateTime($arrDate);
    $depDate = $_POST["depDate"];
    $depDate = new DateTime($depDate);
    $period = date_diff($arrDate, $depDate);
    $days = $period->days;

    // Magnus V. - isset-logic (unecessary complicated, no doubt) for extra features |--- --- --->
    $path = './';
    $dbh = connectBookingsDatabase($path);
    $currentExtraFeatures = getFeaturesFromDatabase($dbh);
    $extrasCost = 0;

    foreach ($currentExtraFeatures as $featureNr => $features) :
        $postExtraFeatureName = str_replace(" ", "-", strtolower($features['feature_name']));
        $checkIssetExtraFeatures = isset($_POST[$postExtraFeatureName]);

        //Magnus V. - Creates an array with selected extra features, and their respective costs:
        if ($checkIssetExtraFeatures) :
            foreach ($_POST[$postExtraFeatureName] as $value) :
                $selectedExtraFeatures[] = ['feature' => $features['feature_name'], 'featureCost' => (int)$value];
                $extrasCost += (int)$value;
            endforeach;;
        endif;

    endforeach;

    // <--- --- ---|

    // Magnus V - Rewrote this part a little bit to include extra features-cost |--- --- --->
    $totalExtrasCost = $extrasCost * $days;
    $totalBookingCost = $cost * $days;

    // <--- --- ---|

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

    $transferCode = $_POST["transferCode"];
    checkValidTransferCode($transferCode, $totalCost);
endif;

// Checks if the transfer code is valid with a POST request to transferCode.php.
function checkValidTransferCode($transferCode, $totalCost)
{
    $client = new Client([
        'base_uri' => 'https://www.yrgopelago.se/centralbank/transferCode'
    ]);

    $response = $client->request('POST', 'https://www.yrgopelago.se/centralbank/transferCode', [
        'form_params' => [
            'transferCode' => $transferCode,
            'total_cost' => $totalCost
        ]
    ]);

    if ($response->hasHeader('Content-Length')) :

        // Gets the content and decodes it.
        $transferCodeCheck = json_decode($response->getBody()->getContents());

        // Prints error message if error occurs.
        if (!empty($transferCodeCheck->error) || is_null($transferCodeCheck->transferCode)) : ?>
            <div class="transfer-code-check">
                <p>It looks like your transfer code can't be found or is already used. Please try again.</p>
                <button class="OK-button">Okay</button>
            </div>
            <?php endif;

        // Calls a new function if the transfer code is valid and there are sufficient funds.
        if (!empty($transferCodeCheck->transferCode)) :
            $transferCode = $transferCodeCheck->transferCode;
            $amount = $transferCodeCheck->amount;

            if ($amount >= $totalCost) :
                transferCodeSuccess($transferCode, $totalCost);
            elseif ($amount < $totalCost) : ?>
                <div class="transfer-code-check">
                    <p>Sadly your booking didn't go through due to insufficient funds. The total cost is $<?= $totalCost; ?> while your funds are $<?= $amount; ?>.</p>
                    <button class="OK-button">Okay</button>
                </div>
<?php endif;
        endif;
    endif;
}
