<?php

namespace Shakilahmmed\MdbParser\Support;

class AttendanceRead
{
    private $filePath;
    private $tableName;
    private $mdbConnection;

    public static function make()
    {
        return new static();
    }

    public function setFile($filePath)
    {
        $this->filePath = $filePath;
    }

    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    public function getFile()
    {
        return $this->filePath;
    }

    public function getTable()
    {
        return $this->tableName;
    }

    private function connection()
    {
        try {
            $this->mdbConnection = new \PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb, *.accdb)};DBQ=$this->filePath; Uid=; Pwd=;");
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getRows()
    {
        try {
            $this->connection();
            $tableName = $this->getTable();
            $sql = "SELECT * FROM {$tableName}";
            $result = $this->mdbConnection->query($sql);
            return $result->fetchAll();
        } catch (\Exception $exception) {
            echo "Connection failed: " . $exception->getMessage();
        }
    }
}