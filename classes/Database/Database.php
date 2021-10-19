<?php
class Database {
    protected static $db = null;
    
    public static function initialDatabase()
    {
        $dsn = "mysql:host=".RIANBASE_DB_HOST.";port=".RIANBASE_DB_PORT.";dbname=".RIANBASE_DB_DATABASE_NAME.";charset=".RIANBASE_DB_CHARSET;
        try {
            self::$db = new PDO($dsn, RIANBASE_DB_USER, RIANBASE_DB_PASSWORD);
            self::$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function executeQuery($query)
    {
        if(self::$db == null) Database::initialDatabase();
        $begin_transaction = false;
        $variables = array();

        $args = func_get_args();
		$arg_count = func_num_args();
		if($arg_count != substr_count($cmd, '?') + 1) {
            throw new \RianBase\Message\Exception(EXCEPTION_LEVEL_WARNING, 'Placeholder count not matching argument list.');
			return false;
		}

        if($arg_count > 1) {
			array_shift($args);

			foreach($args as $arg_value) {
                array_push($variables, $arg_value);
			}
		}
        
        $return_obj = new stdClass();
        $return_obj->query = $query;
        $return_obj->variables = $variables;

        try {
            $stmt = self::$db->prepare($query);
            
            self::$db->beginTransaction();
            $begin_transaction = true;
            $stmt->execute($variables);
            self::$db->commit();

            $return_obj->data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $return_obj->last_insert_id = self::$db->lastInsertId();
            $return_obj->error = 0;
            $return_obj->message = 'success';
        } catch(PDOException $e) {
            if($begin_transaction) self::$db->rollback();
            $return_obj->error = 1;
            $return_obj->message = $e->getMessage();
            $return_obj->data = array();
        }

        return $return_obj;
    }
}