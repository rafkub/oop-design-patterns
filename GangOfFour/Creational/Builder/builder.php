<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Creational\Builder;

// "Builder"
interface SQLQueryBuilder
{
    function select(string $table, array $fields): static; //': static' allows chaining builder methods
    function where(string $field, string|int|float $value, string $operator = '='): static;
    function limit(?int $count = null, int $start = 1): static;
    // All query builders create "Products" of the same type (string), so it is possible to include getQuery()
    // in a "Builder" interface, rather than in the usual place - "Concrete Builders":
    function getQuery(): string;
}

// "Concrete Builders"
class StandardSQLQueryBuilder implements SQLQueryBuilder
{
    protected string $select = '';
    protected array $where = [];
    protected string $limit = '';

    // SECURITY WARNING!
    // This simple implementation is susceptible to SQL injection attack and for demonstration purposes only:
    public function select(string $table, array $fields): static
    {
        $this->select = 'SELECT ' . implode(', ', $fields) . " FROM $table";
        return $this;
    }

    // SECURITY WARNING!
    // This simple implementation is susceptible to SQL injection attack and for demonstration purposes only:
    public function where(string $field, string|int|float $value, string $operator = '='): static
    {
        $value = is_string($value) ? "'$value'" : $value;
        $this->where[] = "$field $operator $value";
        return $this;
    }

    public function limit(?int $count = null, int $start = 1): static
    {
        if (is_null($count)) {
            $this->limit = " OFFSET $start";
        } else {
            $this->limit = " OFFSET $start FETCH $count";
        }
        return $this;
    }

    public function getQuery(): string
    {
        $query = $this->select;
        if (!empty($this->where)) {
            $query .= ' WHERE ' . implode(' AND ', $this->where);
        }
        $query .= $this->limit;
        return $query;
    }
}

class MySQLQueryBuilder extends StandardSQLQueryBuilder
{
    public function limit(?int $count = null, int $start = 1): static
    {
        if (is_null($count)) {
            return $this;
        }
        $this->limit = " LIMIT $start, $count"; // non-standard limit clause syntax
        return $this;
    }
}

class PostgreSQLQueryBuilder extends StandardSQLQueryBuilder
{
    public function limit(?int $count = null, int $start = 1): static
    {
        $limitCount = $count;
        if (is_null($limitCount)) {
            $limitCount = 'ALL';
        }
        $this->limit = " LIMIT $limitCount OFFSET $start"; // non-standard limit clause syntax
        return $this;
    }
}

// A designated "Director" class is not necessary for SQL, because in a real application the building steps
// cannot be easily reused. However, we use it here for performing a test with the same query for both database servers
class TestDirector
{
    public function __construct(private SQLQueryBuilder $queryBuilder) {}

    public function buildTestQuery(): void
    {
        // "Director" uses "Concrete Builder" to build a product:
        $this->queryBuilder
            ->select(table: 'users', fields: ['last_name', 'email'])
            ->where(field: 'last_name', value: 'Jo%', operator: 'LIKE')
            ->where(field: 'is_active', value: 1)
            ->limit(count: 10, start: 20);
    }
}

// Client code creates the "Director" object and configures it with the desired "Concrete Builder" object:
$mySQLQueryBuilder = new MySQLQueryBuilder();
$testDirector = new TestDirector(queryBuilder: $mySQLQueryBuilder);

$testDirector->buildTestQuery(); // "Director" is used to build a specific query
echo 'MySQL query:' . PHP_EOL;
echo $mySQLQueryBuilder->getQuery() . PHP_EOL; // client code retrieves the product directly from the "Concrete Builder"

$postgreSQLQueryBuilder = new PostgreSQLQueryBuilder();
$testDirector = new TestDirector(queryBuilder: $postgreSQLQueryBuilder); // configuring with another "Concrete Builder"
$testDirector->buildTestQuery();
echo 'PostgreSQL query:' . PHP_EOL;
echo $postgreSQLQueryBuilder->getQuery() . PHP_EOL;

$standardSQLQueryBuilder = new StandardSQLQueryBuilder();
$testDirector = new TestDirector(queryBuilder: $standardSQLQueryBuilder); // configuring with another "Concrete Builder"
$testDirector->buildTestQuery();
echo 'Standard SQL query:' . PHP_EOL;
echo $standardSQLQueryBuilder->getQuery() . PHP_EOL;