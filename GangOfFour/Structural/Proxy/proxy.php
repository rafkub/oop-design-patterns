<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Structural\Proxy;

// "Subject"
interface Downloader
{
    function download(string $url): string;
}

// "Real Subject":
class SimpleDownloader implements Downloader
{
    public function download(string $url): string
    {
        return file_get_contents(filename: $url);
    }
}

// "Proxy"
class CachedDownloader implements Downloader // interface identical to "Real Subject"
{
    private array $cache = [];

    public function __construct(private SimpleDownloader $simpleDownloader) {} // keeps reference to "Real Subject"

    public function download(string $url): string
    {
        // Controls access to the real subject:
        return $this->cache[$url] ?? $this->cache[$url] = $this->simpleDownloader->download($url);
    }
}

$cachedDownloader = new CachedDownloader(new SimpleDownloader());

$start = hrtime(true);
$cachedDownloader->download('https://www.example.com'); // time-consuming request; response is being cached
$firstRequest = hrtime(true) - $start;

$start = hrtime(true);
$cachedDownloader->download('https://www.example.com'); // second request to the same resource is not performed
$secondRequest = hrtime(true) - $start;

echo "Execution time of the first request: $firstRequest ns" . PHP_EOL;
echo "Execution time of the second request: $secondRequest ns" . PHP_EOL;