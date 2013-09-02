<?PHP
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Database
 *
 * @author Phobia
 */
class Database extends PDO {

    private static $_instance = Null;
    private static $_lastInsertedId = Null;
    private static $_fetchmode = PDO::FETCH_ASSOC;

    public function __construct($Type, $Host, $Database, $Username, $Password) {
        if (!self::$_instance instanceof Database) {
            $dsn = $Type . ':dbname=' . $Database . ';host=' . $Host;
            parent::__construct($dsn, $Username, $Password);
            self::$_instance = $this;
        }
        return self::$_instance;
    }

    /**
     * select data from database
     * 
     * @param string $table          => The table to select the data from
     * @param array $fields          => The requered field from the database, an empty array stands for a wildcard *
     * @param string $where        => The where condition eg: "WHERE id=:id and password=:password"
     * @param array $BindData   => The data to bind to the query eg: array(":id" => $id, ":password" => $password)
     * @param integer $limit         => The Limit of the number of rows to be returned (default = 30 rows)
     * @param integer $from        => The row form where the rows must be returned (default = 0)   
     * @return array                    => An array with found rows
     * 
     *  eg: select("User", array("id","name", "password"), "WHERE id=:id and password=:password", array(":id" => $id, ":password" => $password), 1, 0)
     * 
     */
    public function select($table, $fields = array(), $where = Null, $BindData = array(), $limit = 30, $from = 0) {
        if (empty($fields))
            $fields = " * "; else
            $fields = "'" . implode("', '", $fields) . "'";

        $sql = "SELECT " . $fields . " FROM " . $table . ' ' . $where . " Limit " . $from . ", " . $limit;
        $stmt = self::$_instance->prepare($sql);
        if ($where != Null)
            $stmt->execute($BindData); else
            $stmt->execute();
        $result = $stmt->FetchAll(self::$_fetchmode);
        if (!empty($result))
            return $result;
        else
            return false;
    }

    /**
     * Update data in the database
     * 
     * @param string $table             => The table to select the data from
     * @param string $where           => The where condition eg: "WHERE id=:id and password=:password"
     * @param array $whereData    => The data to bind to the where clause eg: array(":id" => $id, ":password" => $password)
     * @param array $BindData      => The fields and data to update eg: array("name" => $name, "date" => $date)
     * 
     * @return mixed => true or Exception
     * 
     * eg: update("User", "WHERE id=:id and password=:password", array(":id" => $id, ":password" => $password), array("name" => $name,"date" => $date))
     * 
     */
    public function update($table, $where = Null, $whereData = array(), $BindData = array()) {
        $data = Null;
        $Binded = array();
        // re-order and build SET string
        foreach ($BindData as $key => $value) {
            $data .= "$key = :$key, ";
            $Binded[":$key"] = $value;
        }
        $data = rtrim($data, ", "); // trim trailing ',' from string       
        $Binded = array_merge($Binded, $whereData); // bind the two array into one

        $sql = "UPDATE $table SET $data $where"; // Build the query
        $stmt = self::$_instance->prepare($sql);
        if ($stmt->execute($Binded)) {
            return true;
        } else {
            throw new Exception("Error: PDO Update faild");
        }
    }

    /**
     * Insert data in the database
     * 
     * @param string $table             => The table to select the data from
     * @param array $data              => The fields and data to update eg: array("name" => $name, "date" => $date)
     * 
     * @return mixed => true or Exception
     * 
     * eg: insert("User", array("name" => $name,"date" => $date))
     * 
     */
    public function insert($table, array $data) {
        $columNames = "(" . implode(", ", array_keys($data)) . ")";
        // re-order and build SET string
        $bindkeys = Null;
        $binddata = Null;
        foreach ($data as $key => $value) {
            $bindkeys .= ":$key, ";
            $Binddata[":$key"] = $value;
        }
        $bindkeys = rtrim($bindkeys, ", ");
        $sql = "INSERT INTO $table $columNames VALUES ($bindkeys)"; // Build the query
        $stmt = self::$_instance->prepare($sql);

        try {
            $stmt->execute($Binddata);
            self::$_lastInsertedId = self::$_instance->lastInsertId();
            echo $stmt->rowCount(); // 1
            return true;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    /**
     * delete data in the database
     * 
     * @param string $table             => The table to select the data from
     * @param string $wherre         => The Where statement eg: "WHERE id = :id AND banned = :banned"
     * @param array $data              => The fields and data for the where statement eg: array("id" => $id, "banned" => $banned)
     * 
     * @return mixed => true or Exception
     * 
     * eg: insert("User", "WHERE id = :id AND banned = :banned", array("id" => $id, "banned" => $banned))
     * 
     */
    public function delete($table, $where, array $data) {
        $Binded = array();
        // re-order and build SET string
        foreach ($data as $key => $value) {
            $Binded[":$key"] = $value;
        }
        // "DELETE FROM Persons WHERE LastName='Griffin'"
        $sql = "DELETE FROM $table $where "; // Build the query
        $stmt = self::$_instance->prepare($sql);
        if ($stmt->execute($Binded)) {
            return true;
        } else {
            throw new Exception("Error: PDO Update faild");
        }
    }

    /**
     * 
     * @return integer => Will return the last inserted row id
     */
    public function last_inserted_id() {
        return self::$_lastInsertedId;
    }

    /**
     * 
     * @return object of the Database Class with a active connection
     * @throws Exception if no active instance is found
     */
    static public function Instance() {
        if (self::$_instance instanceof Database) {
            return self::$_instance;
        }
        throw new Exception("Error: The is no connection instance made with the database.");
    }

}

