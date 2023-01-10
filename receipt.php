<?php

declare(strict_types=1);

// Function is called from roomCheck.php if booking is successful.
// Function prints booking info in JSON format.
function receipt($arrDate, $depDate, $totalCost) {
    $receiptContent = [
        "island" => "Isla de los Monos",
        "hotel" => "Overwater Resort",
        "arrival_date" => $arrDate,
        "departure_date" => $depDate,
        "total_cost" => $totalCost,
        "stars" => "2",
        "features" => null,
        "additional_info" => "Thank you for choosing Overwater Resort."
    ];

    $receiptContent = json_encode($receiptContent, JSON_PRETTY_PRINT);

    ?> 
    <div class="receipt">
        <p>Congratulations, the room is now booked. Be sure to save your receipt:</p>
        <pre><?= $receiptContent; ?></pre>
        <button>Okay</button>
    </div> 
    <?php 
}