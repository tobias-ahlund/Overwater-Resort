<?php

declare(strict_types=1);

require "vendor/autoload.php";

// Using Guzzle for POST requests.
use GuzzleHttp\Client;

// Function is called from roomCheck.php if room is available.
// If errors don't occur money is transferred to user. 
function moneyTransfer($transferCode) {
    $client = new Client([
        'base_uri' => 'https://www.yrgopelago.se/centralbank/deposit'
    ]);

    $response = $client->request('POST', 'https://www.yrgopelago.se/centralbank/deposit', [
        'form_params' => [
            "user" => "Tobias",
            "transferCode" => $transferCode
        ]
    ]);

    if ($response->hasHeader('Content-Length')) {
        $moneyTransferCheck = json_decode($response->getBody()->getContents());

        if (!empty($moneyTransferCheck->error)) :
            $error = $moneyTransferCheck->error; ?>
            <div class="transfer-code-check">
                <?= $error; ?>
            </div>
        <?php endif;
    }
}
