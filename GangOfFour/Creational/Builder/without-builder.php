<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Creational\WithoutBuilder;

abstract class StandardQuery
{
    public function __construct(  // issue: a lot of constructor parameters
        protected string $table = '',
        protected array $selectFields = [],
        protected array $wheres = [],
        protected ?int $limitCount = null,
        protected int $limitStart = 1,
    ) {}

    public function getQuery(): string
    {
        $query = 'SELECT ' . implode(', ', $this->selectFields) . " FROM $this->table";
        $whereClauses = [];
        foreach ($this->wheres as $where) {
            $field = $where[0];
            $value = $where[1];
            $operator = $where[2] ?? '=';
            $value = is_string($value) ? "'$value'" : $value;
            $whereClauses[] = "$field $operator $value";
        }
        if (!empty($whereClauses)) {
            $query .= ' WHERE ' . implode(' AND ', $whereClauses);
        }
        return $query;
    }
}

class MySQLQuery extends StandardQuery
{
    public function getQuery(): string
    {
        if (is_null($this->limitCount)) {
            return parent::getQuery();
        }
        return parent::getQuery() . " LIMIT $this->limitStart, $this->limitCount";
    }
}

class PostgreSQLQuery extends StandardQuery
{
    public function getQuery(): string
    {
        $limitCount = $this->limitCount;
        if (is_null($limitCount)) {
            $limitCount = 'ALL';
        }
        return parent::getQuery() . " LIMIT $limitCount OFFSET $this->limitStart";
    }
}

// Complex object construction is required:
$parameters = [
    'table' => 'users',
    'selectFields' => ['last_name', 'email'],
    'wheres' => [
        ['last_name', 'Jo%', 'LIKE'],
        ['is_active', 1]
    ],
    'limitCount' => 10,
    'limitStart' => 20
];
$mySQLQuery = new MySQLQuery(...$parameters);
echo 'MySQL query:' . PHP_EOL;
echo $mySQLQuery->getQuery() . PHP_EOL;

$postgreSQLQuery = new PostgreSQLQuery(...$parameters);
echo 'PostgreSQL query:' . PHP_EOL;
echo $postgreSQLQuery->getQuery() . PHP_EOL;