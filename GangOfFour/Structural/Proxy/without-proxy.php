<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Structural\WithoutProxy;

class SimpleDownloader
{
    public function download(string $url): string
    {
        return file_get_contents(filename: $url);
    }
}

$simpleDownloader = new SimpleDownloader();

$start = hrtime(true);
$simpleDownloader->download('https://www.example.com'); // time-consuming request
$firstRequest = hrtime(true) - $start;

$start = hrtime(true);
$simpleDownloader->download('https://www.example.com'); // second time-consuming request to the same resource
$secondRequest = hrtime(true) - $start;

echo "Execution time of the first request: $firstRequest ns" . PHP_EOL;
echo "Execution time of the second request: $secondRequest ns" . PHP_EOL;