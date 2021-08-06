<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Structural\Adapter;

use JsonException;
use RuntimeException;

// "Adaptees":
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

// "Target" - unified interface to be used by client code
interface ExchangeAPI
{
    function getConversionRatio(string $fromCurrency, string $toCurrency): float;
}

// "Adapters":
class ExchangeRateHostAPIAdapter implements ExchangeAPI
{
    public function __construct(private ExchangeRateHostAPI $api) {} // relies on object composition to perform actions

    public function getConversionRatio(string $fromCurrency, string $toCurrency): float
    {
        // translates request to the format accepted by ExchangeRateHost API (could also convert data format if needed)
        return $this->api->getRatio(targetCurrency: $toCurrency, baseCurrency: $fromCurrency);
    }
}

class NBPAPIAdapter implements ExchangeAPI
{
    public function __construct(private NBPAPI $api) {}

    public function getConversionRatio(string $fromCurrency, string $toCurrency): float
    {
        // translates request to the format accepted by NBP API and converts the result
        return $this->api->getRatioToPLN(targetCurrency: $fromCurrency) /
                $this->api->getRatioToPLN(targetCurrency: $toCurrency);
    }
}

// "Client"
function clientCode(ExchangeAPI $api): void
{
    echo $api->getConversionRatio(fromCurrency: 'EUR', toCurrency: 'GBP') . PHP_EOL; // uses unified interface
}

$nbp = new NBPAPIAdapter(api: new NBPAPI());
clientCode(api: $nbp);

$exchangeRateHost = new ExchangeRateHostAPIAdapter(api: new ExchangeRateHostAPI());
clientCode(api: $exchangeRateHost);