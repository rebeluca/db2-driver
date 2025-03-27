<?php

namespace rebeluca\DB2Driver;

use Illuminate\Database\Connection;
use PDO;
use rebeluca\DB2Driver\Schema\DB2Builder;
use rebeluca\DB2Driver\Schema\DB2SchemaGrammar;

class DB2Connection extends Connection
{

    /**
     * The name of the default schema.
     */
    protected string $defaultSchema;

    /**
     * The name of the current schema in use.
     */
    protected string $currentSchema;

    public function __construct(
        PDO $pdo,
        string $database = '',
        string $tablePrefix = '',
        array $config = [],
    ) {
        parent::__construct($pdo, $database, $tablePrefix, $config);
        $this->currentSchema = $this->defaultSchema = strtoupper($config['schema'] ?? null);
    }

    /**
     * Reset to default the current schema.
     */
    public function resetCurrentSchema(): void
    {
        $this->setCurrentSchema($this->getDefaultSchema());
    }

    /**
     * Set the name of the current schema.
     */
    public function setCurrentSchema(string $schema): void
    {
        $this->statement('SET SCHEMA ?', [$schema !== "" ? strtoupper($schema) : "DEFAULT"]);
    }

    /**
     * Get the name of the default schema.
     */
    public function getDefaultSchema(): string
    {
        return $this->defaultSchema;
    }

    /**
     * Execute a system command on IBMi.
     */
    public function executeCommand($command)
    {
        $this->statement('CALL QSYS2.QCMDEXC(?)', [$command]);
    }

    /**
     * Get a schema builder instance for the connection.
     */
    public function getSchemaBuilder()
    {
        if (is_null($this->schemaGrammar)) {
            $this->useDefaultSchemaGrammar();
        }

        return new DB2Builder($this);
    }

    /**
     * @return \Illuminate\Database\Grammar
     */
    protected function getDefaultQueryGrammar(): \Illuminate\Database\Grammar
    {
        $defaultGrammar = new DB2QueryGrammar();

        // If a date format was specified in constructor
        if (array_key_exists('date_format', $this->config)) {
            $defaultGrammar->setDateFormat($this->config['date_format']);
        }

        // If offset compatability mode was specified in constructor
        if (array_key_exists('offset_compatibility_mode', $this->config)) {
            $defaultGrammar->setOffsetCompatibilityMode($this->config['offset_compatibility_mode']);
        }

        return $this->withTablePrefix($defaultGrammar);
    }

    /**
     * Get the efault grammar for specified Schema
     */
    protected function getDefaultSchemaGrammar(): \Illuminate\Database\Grammar
    {
        return new DB2SchemaGrammar();
    }

    /**
     * Get the default post processor instance
     */
    protected function getDefaultPostProcessor(): \Illuminate\Database\Query\Processors\Processor
    {
        return new DB2Processor();
    }

}
