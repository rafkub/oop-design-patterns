<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\Creational\WithoutSimpleFactory;

use RuntimeException;

class Domain
{
    public function __construct(private string $domainName) {}

    public function getName(): string
    {
        return $this->domainName;
    }

    public function getTopLevelDomain(): string
    {
        return substr($this->domainName, strrpos($this->domainName, '.'));
    }
}

interface Registry
{
    function register(Domain $domain): void;
}

class ComRegistry implements Registry
{
    public function register(Domain $domain): void
    {
        echo "Registering {$domain->getName()} via Verisign..." . PHP_EOL;
    }
}

class OrgRegistry implements Registry
{
    public function register(Domain $domain): void
    {
        echo "Registering {$domain->getName()} via Public Interest Registry..." . PHP_EOL;
    }
}

$domain = new Domain(domainName: 'example.org');
$registry = match ($domain->getTopLevelDomain()) { // to introduce new registry a client code has to be modified
    '.com' => new ComRegistry(),
    '.org' => new OrgRegistry(),
    default => throw new RuntimeException(message: 'Registry not supported or incorrect domain name'),
};
$registry->register(domain: $domain);

//NOTE: client code creating the registry object might be present in multiple places