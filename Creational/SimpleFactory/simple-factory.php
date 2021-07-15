<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\Creational\SimpleFactory;

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

class RegistrySimpleFactory // there is one, centralized way of creating registries
{
    // any new registry has to be implemented only here; client code stays the same
    public function create(string $topLevelDomain): Registry // could be also defined as static (Static Factory)
    {
        return match ($topLevelDomain) {
            '.com' => new ComRegistry(),
            '.org' => new OrgRegistry(),
            default => throw new RuntimeException(message: 'Registry not supported or incorrect domain name'),
        };
    }
}

$domain = new Domain(domainName: 'example.org');

$registrySimpleFactory = new RegistrySimpleFactory();
$registry = $registrySimpleFactory->create(topLevelDomain: $domain->getTopLevelDomain());
// or when using a Static Factory:
// $registry = RegistrySimpleFactory::create(topLevelDomain: $domain->getTopLevelDomain());

$registry->register(domain: $domain);