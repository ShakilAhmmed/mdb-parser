<?php

namespace Shakilahmmed\MdbParser\Support;

class AttendanceSync
{
    private $serverName;
    private $userName;
    private $password;
    private $dbName;
    private $attendanceConnection;
    private $tableName;

    public static function sync()
    {
        return new static();
    }

    public function setServerName($serverName)
    {
        $this->serverName = $serverName;
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setDbName($dbName)
    {
        $this->dbName = $dbName;
    }

    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    private function connection()
    {
        try {
            $this->attendanceConnection = new \PDO("mysql:host=$this->serverName;dbname=$this->dbName", $this->userName, $this->password);
            $this->attendanceConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function store($rows)
    {
        try {
            $this->connection();
            foreach ($rows as $result) {
                $userId = $result['USERID'];
                $punchTime = $result['CHECKTIME'];
                $attendanceDate = \DateTime::createFromFormat("Y-m-d H:i:s", $punchTime)->format('Y-m-d');;
                $flag = 2;
                $machineData = json_encode($result);
                $factoryId = null;
                $createdBy = null;
                $updatedBy = null;
                $deletedBy = null;
                $deletedAt = null;
                $createdAt = null;
                $updatedAt = null;

                $sql = "
                INSERT INTO hr_attendance_raw_data
                    (`user_id`,
                     `puch_time`, 
                     `attedance_date`,
                     `flag`, 
                     `factory_id`, 
                     `created_by`, 
                     `updated_by`, 
                     `deleted_by`, 
                     `deleted_at`, 
                     `created_at`, 
                     `updated_at`,
                     `machine_data`) VALUES 
                     (?,?,?,?,?,?,?,?,?,?,?,?,?)
            ";
                $this->attendanceConnection->prepare($sql)->execute([
                    $userId,
                    $punchTime,
                    $attendanceDate,
                    $flag,
                    $factoryId,
                    $createdBy,
                    $updatedBy,
                    $deletedBy,
                    $deletedAt,
                    $createdAt,
                    $updatedAt,
                    $machineData
                ]);
            }
        } catch (\Exception $exception) {
            echo "Error: " . $exception->getMessage();
        }
    }
}