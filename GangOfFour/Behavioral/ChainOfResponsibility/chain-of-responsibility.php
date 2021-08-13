<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Behavioral\ChainOfResponsibility;

use JsonException;
use ReflectionClass;
use RuntimeException;

// "Handler"
abstract class ExchangeAPI
{
    public function __construct(private ?self $nextAPI = null) {} // link to the successor in a chain

    // default implementation of handle request
    public function getConversionRatio(string $fromCurrency, string $toCurrency): float
    {
        if (is_null($this->nextAPI)) { // end of chain
            throw new RuntimeException("Cannot get the $fromCurrency/$toCurrency conversion ratio.");
        }
        return $this->nextAPI->getConversionRatio($fromCurrency, $toCurrency); // forward the request to the successor
    }

    public function attach(self $nextHandler): self // optional, for alternative way of building a chain
    {
        $this->nextAPI = $nextHandler;
        return $this->nextAPI;
    }

    protected function handledBy(): void // helper method for printing debug info
    {
        echo 'Handled by ' . (new ReflectionClass(objectOrClass: $this))->getShortName() . '. ';
    }
}

// "Concrete Handlers":
class NBPAPI extends ExchangeAPI // returns currency ratio only for a fixed base currency: PLN
{
    public function getConversionRatio(string $fromCurrency, string $toCurrency): float
    {
        if ($fromCurrency === 'PLN' || $toCurrency !== 'PLN') { // cannot handle these cases itself
            return parent::getConversionRatio($fromCurrency, $toCurrency); // forward the request to the successor
        }
        $requestUrl = "https://api.nbp.pl/api/exchangerates/rates/a/$fromCurrency?format=json";
        $responseJson = file_get_contents($requestUrl);
        if ($responseJson === false) {
            return parent::getConversionRatio($fromCurrency, $toCurrency); // whenever it cannot fulfil the request
        }
        try {
            $response = json_decode(json: $responseJson, associative: false, depth: 4, flags: JSON_THROW_ON_ERROR );
            $this->handledBy(); // print debug information
            return $response->rates[0]->mid;
        } catch (JsonException) {
            return parent::getConversionRatio($fromCurrency, $toCurrency);
        }
    }
}

class ExchangeRateHostAPI extends ExchangeAPI
{
    public function getConversionRatio(string $fromCurrency, string $toCurrency): float
    {
        $requestUrl = "https://api.exchangerate.host/latest?base=$fromCurrency&symbols=$toCurrency&source=ecb";
        $responseJson = file_get_contents($requestUrl);
        if ($responseJson === false) {
            return parent::getConversionRatio($fromCurrency, $toCurrency);
        }
        try {
            $response = json_decode(json: $responseJson, associative: false, depth: 3, flags: JSON_THROW_ON_ERROR );
            if (!$response->success || !isset($response->rates->$toCurrency) || $response->base !== $fromCurrency) {
                return parent::getConversionRatio($fromCurrency, $toCurrency);
            }
            $this->handledBy();
            return $response->rates->$toCurrency;
        } catch (JsonException) {
            return parent::getConversionRatio($fromCurrency, $toCurrency);
        }
    }
}

class CachedExchange extends ExchangeAPI // returns fixed ratios
{
    private function cannotHandle(string $fromCurrency, string $toCurrency): bool
    {
        $canHandle = ['EUR', 'GBP', 'USD', 'PLN', 'USH'];
        return (!in_array($fromCurrency, $canHandle) || !in_array($toCurrency, $canHandle));
    }

    public function getConversionRatio(string $fromCurrency, string $toCurrency): float
    {
        if ($this->cannotHandle($fromCurrency, $toCurrency)) { // instead of match's "default" cases (to allow logging)
            return parent::getConversionRatio($fromCurrency, $toCurrency);
        }
        $this->handledBy(); // logging
        return match ($fromCurrency) {
            'EUR' => match ($toCurrency) {
                'EUR' => 1,
                'GBP' => 0.85,
                'USD' => 1.17,
                'PLN' => 4.59,
                'USH' => 4135.0725,
                // default => parent::getConversionRatio($fromCurrency, $toCurrency), // when no logging present
            },
            'GBP' => match ($toCurrency) {
                'EUR' => 1.18,
                'GBP' => 1,
                'USD' => 1.38,
                'PLN' => 5.41,
                'USH' => 4879.68,
                // default => parent::getConversionRatio($fromCurrency, $toCurrency),
            },
            'USD' => match ($toCurrency) {
                'EUR' => 0.85,
                'GBP' => 0.72,
                'USD' => 1,
                'PLN' => 3.91,
                'USH' => 3534.25,
                // default => parent::getConversionRatio($fromCurrency, $toCurrency),
            },
            'PLN' => match ($toCurrency) {
                'EUR' => 0.22,
                'GBP' => 0.18,
                'USD' => 0.26,
                'PLN' => 1,
                'USH' => 906.32,
                // default => parent::getConversionRatio($fromCurrency, $toCurrency),
            },
            'USH' => match ($toCurrency) {
                'EUR' => 0.00024,
                'GBP' => 0.0002,
                'USD' => 0.00028,
                'PLN' => 0.0010948,
                'USH' => 1,
                // default => parent::getConversionRatio($fromCurrency, $toCurrency),
            },
            // default => parent::getConversionRatio($fromCurrency, $toCurrency),
        };
    }
}

// "Client"
function clientCode(ExchangeAPI $exchangeAPI): void
{
    $fromCurrencies = ['EUR', 'EUR', 'USD', 'USD', 'AAA', 'USD', 'AAA'];
    $toCurrencies = ['PLN', 'GBP', 'USD', 'USH', 'USD', 'AAA', 'ZZZ'];

    foreach ($fromCurrencies as $key => $fromCurrency) {
        $toCurrency = $toCurrencies[$key];
        try {
            // initiate the request
            echo "$fromCurrency/$toCurrency: " . $exchangeAPI->getConversionRatio($fromCurrency, $toCurrency) . PHP_EOL;
        } catch (RuntimeException $e) {
            echo $e->getMessage() . PHP_EOL; // cannot handle the request
        }
    }
}

// dynamically building a chain ($nbp-->$exchangeRateHost-->$cachedExchange):
$cachedExchange = new CachedExchange();
$exchangeRateHost = new ExchangeRateHostAPI($cachedExchange);
$nbp = new NBPAPI($exchangeRateHost);

// alternative, more intuitive way of building the same chain:
$nbp = new NBPAPI();
$exchangeRateHost = new ExchangeRateHostAPI();
$cachedExchange = new CachedExchange();
$nbp->attach($exchangeRateHost)->attach($cachedExchange);

clientCode(exchangeAPI: $nbp); // execution