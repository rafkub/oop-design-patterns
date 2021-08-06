<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Structural\WithoutAdapter;

use JsonException;
use RuntimeException;

class ExchangeRateHostAPI
{
    public function getRatio(string $targetCurrency, string $baseCurrency): float
    {
        $requestUrl = "https://api.exchangerate.host/latest?base=$baseCurrency&symbols=$targetCurrency&source=ecb";
        $responseJson = file_get_contents($requestUrl);
        if ($responseJson === false) {
            throw new RuntimeException(message: "There was a problem with performing the request: $requestUrl");
        }
        try {
            $response = json_decode(json: $responseJson, associative: false, depth: 3, flags: JSON_THROW_ON_ERROR );
            if (!$response->success) {
               throw new RuntimeException(message: "The following request failed: $requestUrl");
            }
            return $response->rates->$targetCurrency;
        } catch (JsonException $e) {
            throw new RuntimeException(message: "There was a problem with parsing $responseJson: " . $e->getMessage());
        }
    }
}

class NBPAPI // returns currency ratio only for a fixed base currency: PLN
{
    public function getRatioToPLN(string $targetCurrency): float
    {
        $requestUrl = "https://api.nbp.pl/api/exchangerates/rates/a/$targetCurrency?format=json";
        $responseJson = file_get_contents($requestUrl);
        if ($responseJson === false) {
            throw new RuntimeException(message: "There was a problem with performing the request: $requestUrl");
        }
        try {
            $response = json_decode(json: $responseJson, associative: false, depth: 4, flags: JSON_THROW_ON_ERROR );
            return $response->rates[0]->mid;
        } catch (JsonException $e) {
            throw new RuntimeException(message: "There was a problem with parsing $responseJson: " . $e->getMessage());
        }
    }
}

// Above classes perform similar tasks, but they have incompatible interfaces (different method signatures).
// Changing their code is not always possible (3rd-party library, encrypted code etc.)

function clientCode(ExchangeRateHostAPI|NBPAPI $api): void
{
    // No unified interface to deal with the APIs:
    if ($api instanceof ExchangeRateHostAPI) {
        echo $api->getRatio(targetCurrency: 'GBP', baseCurrency: 'EUR') . PHP_EOL;
    } else {
        echo $api->getRatioToPLN(targetCurrency: 'EUR') / $api->getRatioToPLN(targetCurrency: 'GBP') . PHP_EOL;
        // NOTE: for efficiency could be also done in one request using another API endpoint (not implemented in NBPAPI)
    }
}

$nbp = new NBPAPI();
clientCode(api: $nbp);

$exchangeRateHost = new ExchangeRateHostAPI();
clientCode(api: $exchangeRateHost);