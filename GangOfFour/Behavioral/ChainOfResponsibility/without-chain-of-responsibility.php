<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Behavioral\WithoutChainOfResponsibility;

use JsonException;
use RuntimeException;

class NBPAPI // returns currency ratio only for a fixed base currency: PLN
{
    public function getConversionRatio(string $fromCurrency, string $toCurrency): float
    {
        if ($fromCurrency === 'PLN' || $toCurrency !== 'PLN') { // cannot handle these cases itself
            throw new RuntimeException("Cannot get the $fromCurrency/$toCurrency conversion ratio.");
        }
        $requestUrl = "https://api.nbp.pl/api/exchangerates/rates/a/$fromCurrency?format=json";
        $responseJson = file_get_contents($requestUrl);
        if ($responseJson === false) {
            // whenever it cannot fulfil the request
            throw new RuntimeException("Cannot get the $fromCurrency/$toCurrency conversion ratio.");
        }
        try {
            $response = json_decode(json: $responseJson, associative: false, depth: 4, flags: JSON_THROW_ON_ERROR );
            return $response->rates[0]->mid;
        } catch (JsonException) {
            throw new RuntimeException("Cannot get the $fromCurrency/$toCurrency conversion ratio.");
        }
    }
}

class ExchangeRateHostAPI
{
    public function getConversionRatio(string $fromCurrency, string $toCurrency): float
    {
        $requestUrl = "https://api.exchangerate.host/latest?base=$fromCurrency&symbols=$toCurrency&source=ecb";
        $responseJson = file_get_contents($requestUrl);
        if ($responseJson === false) {
            throw new RuntimeException("Cannot get the $fromCurrency/$toCurrency conversion ratio.");
        }
        try {
            $response = json_decode(json: $responseJson, associative: false, depth: 3, flags: JSON_THROW_ON_ERROR );
            if (!$response->success || !isset($response->rates->$toCurrency) || $response->base !== $fromCurrency) {
                throw new RuntimeException("Cannot get the $fromCurrency/$toCurrency conversion ratio.");
            }
            return $response->rates->$toCurrency;
        } catch (JsonException) {
            throw new RuntimeException("Cannot get the $fromCurrency/$toCurrency conversion ratio.");
        }
    }
}

class CachedExchange // returns fixed ratios
{
    private function cannotHandle(string $fromCurrency, string $toCurrency): bool
    {
        $canHandle = ['EUR', 'GBP', 'USD', 'PLN', 'USH'];
        return (!in_array($fromCurrency, $canHandle) || !in_array($toCurrency, $canHandle));
    }

    public function getConversionRatio(string $fromCurrency, string $toCurrency): float
    {
        return match ($fromCurrency) {
            'EUR' => match ($toCurrency) {
                'EUR' => 1,
                'GBP' => 0.85,
                'USD' => 1.17,
                'PLN' => 4.59,
                'USH' => 4135.0725,
                default => throw new RuntimeException("Cannot get the $fromCurrency/$toCurrency conversion ratio."),
            },
            'GBP' => match ($toCurrency) {
                'EUR' => 1.18,
                'GBP' => 1,
                'USD' => 1.38,
                'PLN' => 5.41,
                'USH' => 4879.68,
                default => throw new RuntimeException("Cannot get the $fromCurrency/$toCurrency conversion ratio."),
            },
            'USD' => match ($toCurrency) {
                'EUR' => 0.85,
                'GBP' => 0.72,
                'USD' => 1,
                'PLN' => 3.91,
                'USH' => 3534.25,
                default => throw new RuntimeException("Cannot get the $fromCurrency/$toCurrency conversion ratio."),
            },
            'PLN' => match ($toCurrency) {
                'EUR' => 0.22,
                'GBP' => 0.18,
                'USD' => 0.26,
                'PLN' => 1,
                'USH' => 906.32,
                default => throw new RuntimeException("Cannot get the $fromCurrency/$toCurrency conversion ratio."),
            },
            'USH' => match ($toCurrency) {
                'EUR' => 0.00024,
                'GBP' => 0.0002,
                'USD' => 0.00028,
                'PLN' => 0.0010948,
                'USH' => 1,
                default => throw new RuntimeException("Cannot get the $fromCurrency/$toCurrency conversion ratio."),
            },
            default => throw new RuntimeException("Cannot get the $fromCurrency/$toCurrency conversion ratio."),
        };
    }
}

$nbp = new NBPAPI();
$exchangeRateHost = new ExchangeRateHostAPI();
$cachedExchange = new CachedExchange();

$fromCurrencies = ['EUR', 'EUR', 'USD', 'USD', 'AAA', 'USD', 'AAA'];
$toCurrencies = ['PLN', 'GBP', 'USD', 'USH', 'USD', 'AAA', 'ZZZ'];

foreach ($fromCurrencies as $key => $fromCurrency) {
    $toCurrency = $toCurrencies[$key];
    // Implementation is verbose and the order of the APIs that are queried is fixed:
    try { // try to get data from the first API
        echo "Handled by NBPAPI. $fromCurrency/$toCurrency: " . $nbp->getConversionRatio($fromCurrency, $toCurrency)
            . PHP_EOL;
    } catch (RuntimeException) {
        try { // when the first attempt failed, try to get data from the second API
            echo "Handled by ExchangeRateHostAPI. $fromCurrency/$toCurrency: "
                . $exchangeRateHost->getConversionRatio($fromCurrency, $toCurrency) . PHP_EOL;
        } catch (RuntimeException) {
            try { // when the second attempt failed, try to get data from the third API
                echo "Handled by CachedExchange. $fromCurrency/$toCurrency: "
                    . $cachedExchange->getConversionRatio($fromCurrency, $toCurrency) . PHP_EOL;
            } catch (RuntimeException $e) {
                echo $e->getMessage() . PHP_EOL; // cannot handle the request
            }
        }
    }
}