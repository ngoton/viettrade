<?php
class baseModel {
    private static $instance;
    
    public $host;
    public $db_name; 
    public $db_username; 
    public $db_password;
    public $dbh;

    public $host2;
    public $db_name2; 
    public $db_username2; 
    public $db_password2;
    public $dbh2;

    public $host3;
    public $db_name3; 
    public $db_username3; 
    public $db_password3;
    public $dbh3;
    
    /*
    * Khởi tạo kết nối database
    */
    function __construct($config = array('host'=>DB_SERVER,'db_name'=>DB_DATABASE,'db_username'=>DB_USERNAME,'db_password'=>DB_PASSWORD,'host2'=>DB_SERVER_2,'db_name2'=>DB_DATABASE_2,'db_username2'=>DB_USERNAME_2,'db_password2'=>DB_PASSWORD_2,'host3'=>DB_SERVER_3,'db_name3'=>DB_DATABASE_3,'db_username3'=>DB_USERNAME_3,'db_password3'=>DB_PASSWORD_3)) 
    {
        if(is_array($config))
        {
            $this->host = $config['host'];
            $this->db_name = $config['db_name'];
            $this->db_username = $config['db_username'];
            $this->db_password = $config['db_password'];

            $this->host2 = $config['host2'];
            $this->db_name2 = $config['db_name2'];
            $this->db_username2 = $config['db_username2'];
            $this->db_password2 = $config['db_password2'];

            $this->host3 = $config['host3'];
            $this->db_name3 = $config['db_name3'];
            $this->db_username3 = $config['db_username3'];
            $this->db_password3 = $config['db_password3'];
        }   
        try 
        {
            $this->dbh = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->db_username, $this->db_password);
            $this->dbh->exec("SET CHARACTER SET utf8");

            $this->dbh2 = new PDO("mysql:host=" . $this->host2 . ";dbname=" . $this->db_name2, $this->db_username2, $this->db_password2);
            $this->dbh2->exec("SET CHARACTER SET utf8");

            $this->dbh3 = new PDO("mysql:host=" . $this->host3 . ";dbname=" . $this->db_name3, $this->db_username3, $this->db_password3);
            $this->dbh3->exec("SET CHARACTER SET utf8");
        }
        catch (PDOException $e)
        {
            throw new Exception($e->getMessage());
        }
    }

    /*
    * Lấy tên Model
    */
    public function get($name){
        $file = __SITE_PATH.'/model/'.str_replace("model","",strtolower($name))."Model.php";
        
        if(file_exists($file))
        {
            include ($file);
            $class = str_replace("model","",strtolower($name))."Model";
            return new $class;
        }        
        return NULL;
    }

    public static function getInstance() {
        if (!self::$instance)
        {    
            self::$instance = new baseModel();
        }
        return self::$instance;
    }
    
    /*
    * Thêm vào CSDL
    */
    public function insert($table, $insert)
    //Timestamp always set unless otherwise specified
    {       
        // Filter out fields that don't exist
        $insert = $this->filter2($insert, $table);
        //End Filter
        
        
        $keys = implode(', ', array_keys($insert));
        $table_values = implode(", :", array_keys($insert));
        $sql = "INSERT INTO $table ($keys) VALUES(:$table_values)";
        $query = $this->dbh2->prepare($sql);
        $new_insert = array();
        foreach($insert as $key=>$value)
        {
            if($value==null)
            {
                $value = '';
            }
            $new_insert[":" . $key] = $value;
        }
        $query->execute($new_insert);

        $col = $table.'_id';
        $id_last = $this->getLast2($table)->$col;

        $insert[$col] = $id_last;

        $insert2 = $this->filter($insert, $table);
        //End Filter
        
        
        $keys2 = implode(', ', array_keys($insert2));
        $table_values2 = implode(", :", array_keys($insert2));
        $sql2 = "INSERT INTO $table ($keys2) VALUES(:$table_values2)";
        $query2 = $this->dbh->prepare($sql2);
        $new_insert2 = array();
        foreach($insert2 as $key=>$value)
        {
            if($value==null)
            {
                $value = '';
            }
            $new_insert2[":" . $key] = $value;
        }
        $query2->execute($new_insert2);
        //to check that there is an id field before using it to get the last object
        if($this->dbh->lastInsertId())
        {
            $stmt = $this->dbh->query("SELECT * FROM $table WHERE {$this->getPrimaryKey($table)}='" . $this->dbh->lastInsertId() . "'");
            return $stmt->fetch(PDO::FETCH_OBJ);
        }
        else
        //if there isn't, just get the object by fields
        {
            return $this->getByWhere($table, $insert);
        }
    }

    public function insert2($table, $insert)
    //Timestamp always set unless otherwise specified
    {       
        // Filter out fields that don't exist
        $insert = $this->filter($insert, $table);
        //End Filter
        
        
        $keys = implode(', ', array_keys($insert));
        $table_values = implode(", :", array_keys($insert));
        $sql = "INSERT INTO $table ($keys) VALUES(:$table_values)";
        $query = $this->dbh->prepare($sql);
        $new_insert = array();
        foreach($insert as $key=>$value)
        {
            if($value==null)
            {
                $value = '';
            }
            $new_insert[":" . $key] = $value;
        }
        $query->execute($new_insert);
        //End Filter
        
        
        //to check that there is an id field before using it to get the last object
        if($this->dbh->lastInsertId())
        {
            $stmt = $this->dbh->query("SELECT * FROM $table WHERE {$this->getPrimaryKey($table)}='" . $this->dbh->lastInsertId() . "'");
            return $stmt->fetch(PDO::FETCH_OBJ);
        }
        else
        //if there isn't, just get the object by fields
        {
            return $this->getByWhere($table, $insert);
        }
    }

    public function insert3($table, $insert)
    //Timestamp always set unless otherwise specified
    {       
        // Filter out fields that don't exist
        $insert = $this->filter3($insert, $table);
        //End Filter
        
        
        $keys = implode(', ', array_keys($insert));
        $table_values = implode(", :", array_keys($insert));
        $sql = "INSERT INTO $table ($keys) VALUES(:$table_values)";
        $query = $this->dbh3->prepare($sql);
        $new_insert = array();
        foreach($insert as $key=>$value)
        {
            if($value==null)
            {
                $value = '';
            }
            $new_insert[":" . $key] = $value;
        }
        $query->execute($new_insert);
        //End Filter
        
        
        //to check that there is an id field before using it to get the last object
        if($this->dbh3->lastInsertId())
        {
            $stmt = $this->dbh3->query("SELECT * FROM $table WHERE {$this->getPrimaryKey($table)}='" . $this->dbh3->lastInsertId() . "'");
            return $stmt->fetch(PDO::FETCH_OBJ);
        }
        else
        //if there isn't, just get the object by fields
        {
            return $this->getByWhere3($table, $insert);
        }
    }

    public function insert4($table, $insert)
    //Timestamp always set unless otherwise specified
    {       
        // Filter out fields that don't exist
        $insert = $this->filter2($insert, $table);
        //End Filter
        
        
        $keys = implode(', ', array_keys($insert));
        $table_values = implode(", :", array_keys($insert));
        $sql = "INSERT INTO $table ($keys) VALUES(:$table_values)";
        $query = $this->dbh2->prepare($sql);
        $new_insert = array();
        foreach($insert as $key=>$value)
        {
            if($value==null)
            {
                $value = '';
            }
            $new_insert[":" . $key] = $value;
        }
        $query->execute($new_insert);
        //End Filter
        
        
        //to check that there is an id field before using it to get the last object
        if($this->dbh2->lastInsertId())
        {
            $stmt = $this->dbh2->query("SELECT * FROM $table WHERE {$this->getPrimaryKey($table)}='" . $this->dbh2->lastInsertId() . "'");
            return $stmt->fetch(PDO::FETCH_OBJ);
        }
        else
        //if there isn't, just get the object by fields
        {
            return $this->getByWhere2($table, $insert);
        }
    }
    
    /*
    * Cập nhật CSDL
    */
    public function update($table, $insert, $object)
    {
        $tmp = array();
        $conditions = array();
        $primaryKey = $this->getPrimaryKey($table);
        $insert = $this->filter($insert, $table);
        
        foreach($insert as $key=>$value)
        {
            $tmp[] = "$key=?";
        }
        $str = implode(', ', $tmp);

        $object = $this->filter($object, $table);
        
        foreach($object as $key=>$value)
        {
            $conditions[] = "$key=$value";
        }
        $where = implode(' AND ', $conditions);
        
        $sql = "UPDATE $table SET $str WHERE $where";

        $query = $this->dbh->prepare($sql);
        $query->execute(array_values($insert));

        $query2 = $this->dbh2->prepare($sql);
        $query2->execute(array_values($insert));
        $this->dbh2->exec($sql);
        
        return $this->dbh->exec($sql);
    }

    public function update2($table, $insert, $object)
    {
        $tmp = array();
        $conditions = array();
        $primaryKey = $this->getPrimaryKey($table);
        $insert = $this->filter($insert, $table);
        
        foreach($insert as $key=>$value)
        {
            $tmp[] = "$key=?";
        }
        $str = implode(', ', $tmp);

        $object = $this->filter($object, $table);
        
        foreach($object as $key=>$value)
        {
            $conditions[] = "$key=$value";
        }
        $where = implode(' AND ', $conditions);
        
        $sql = "UPDATE $table SET $str WHERE $where";

        $query = $this->dbh->prepare($sql);
        $query->execute(array_values($insert));

        return $this->dbh->exec($sql);
    }

    public function update3($table, $insert, $object)
    {
        $tmp = array();
        $conditions = array();
        $primaryKey = $this->getPrimaryKey3($table);
        $insert = $this->filter3($insert, $table);
        
        foreach($insert as $key=>$value)
        {
            $tmp[] = "$key=?";
        }
        $str = implode(', ', $tmp);

        $object = $this->filter3($object, $table);
        
        foreach($object as $key=>$value)
        {
            $conditions[] = "$key=$value";
        }
        $where = implode(' AND ', $conditions);
        
        $sql = "UPDATE $table SET $str WHERE $where";

        $query = $this->dbh3->prepare($sql);
        $query->execute(array_values($insert));

        return $this->dbh3->exec($sql);
    }

    public function update4($table, $insert, $object)
    {
        $tmp = array();
        $conditions = array();
        $primaryKey = $this->getPrimaryKey2($table);
        $insert = $this->filter2($insert, $table);
        
        foreach($insert as $key=>$value)
        {
            $tmp[] = "$key=?";
        }
        $str = implode(', ', $tmp);

        $object = $this->filter2($object, $table);
        
        foreach($object as $key=>$value)
        {
            $conditions[] = "$key=$value";
        }
        $where = implode(' AND ', $conditions);
        
        $sql = "UPDATE $table SET $str WHERE $where";

        $query = $this->dbh2->prepare($sql);
        $query->execute(array_values($insert));

        return $this->dbh2->exec($sql);
    }

    /*
    * Xóa CSDL
    */
    public function delete($table, $data)
    {
        
        $data = $this->filter($data, $table);
        $conditions = array();
        foreach($data as $key=>$value)
        {
            if($value==null)
            {
                $conditions[] = "$key IS NULL";
                unset($data[$key]);
            }
            else
            {
                $conditions[] = "$key=?";
            }
        }
        $str = implode(' AND ', $conditions);
        
        $sql = "DELETE FROM $table WHERE $str";
        $query = $this->dbh->prepare($sql);
        $query->execute(array_values($data));

        $query2 = $this->dbh2->prepare($sql);
        $query2->execute(array_values($data));
        $this->dbh2->exec($sql);
        //var_dump($sql);
        return $this->dbh->exec($sql);
    }

    public function delete2($table, $data)
    {
        
        $data = $this->filter($data, $table);
        $conditions = array();
        foreach($data as $key=>$value)
        {
            if($value==null)
            {
                $conditions[] = "$key IS NULL";
                unset($data[$key]);
            }
            else
            {
                $conditions[] = "$key=?";
            }
        }
        $str = implode(' AND ', $conditions);
        
        $sql = "DELETE FROM $table WHERE $str";
        $query = $this->dbh->prepare($sql);
        $query->execute(array_values($data));

        //var_dump($sql);
        return $this->dbh->exec($sql);
    }

    public function delete3($table, $data)
    {
        
        $data = $this->filter3($data, $table);
        $conditions = array();
        foreach($data as $key=>$value)
        {
            if($value==null)
            {
                $conditions[] = "$key IS NULL";
                unset($data[$key]);
            }
            else
            {
                $conditions[] = "$key=?";
            }
        }
        $str = implode(' AND ', $conditions);
        
        $sql = "DELETE FROM $table WHERE $str";
        $query = $this->dbh3->prepare($sql);
        $query->execute(array_values($data));

        //var_dump($sql);
        return $this->dbh3->exec($sql);
    }

    public function delete4($table, $data)
    {
        
        $data = $this->filter2($data, $table);
        $conditions = array();
        foreach($data as $key=>$value)
        {
            if($value==null)
            {
                $conditions[] = "$key IS NULL";
                unset($data[$key]);
            }
            else
            {
                $conditions[] = "$key=?";
            }
        }
        $str = implode(' AND ', $conditions);
        
        $sql = "DELETE FROM $table WHERE $str";
        $query = $this->dbh2->prepare($sql);
        $query->execute(array_values($data));

        //var_dump($sql);
        return $this->dbh2->exec($sql);
    }

    public function query($sql){
        //var_dump($sql);
        $query = $this->dbh->prepare($sql);
        $query->execute();

        $query2 = $this->dbh2->prepare($sql);
        $query2->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function query2($sql){
        //var_dump($sql);
        $query = $this->dbh->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function query3($sql){
        //var_dump($sql);
        $query = $this->dbh3->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function query4($sql){
        //var_dump($sql);
        $query = $this->dbh2->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    /*
    * Lấy tất cả
    */
    public function fetchAll($table,$data = array('where','order_by','order','limit'),$join = array('table','where')){
        //var_dump($data['order_by']);die();
        $where = null;
        $order_by = null;
        $order = null;
        $limit = null;

        $table_join = null;
        $join_where = null;

        if (isset($data['where'])) {
            $where = 'WHERE '.$data['where'];
            //
        }
        if (isset($data['order_by'])) {
            $order_by = 'ORDER BY '.$data['order_by'];
            //
        }
        if (isset($data['order'])) {
            $order = $data['order'];
            //
        }
        if (isset($data['limit'])) {
            $limit = 'LIMIT '.$data['limit'];
            //
        }
        if (isset($join['table'])) {
            if (!isset($data['where'])) {
                $join_where = $join['where'];
                $table_join = ', '.$join['table'].' WHERE ';
            }
            else{
                $table_join = ', '.$join['table'];
                $join_where = ' AND '.$join['where'];
            }
            
            //
        }
        $sql = "SELECT * FROM $table $table_join $where $join_where $order_by $order $limit";
        //var_dump($sql);
        $query = $this->dbh->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function fetchAll2($table,$data = array('where','order_by','order','limit'),$join = array('table','where')){
        //var_dump($data['order_by']);die();
        $where = null;
        $order_by = null;
        $order = null;
        $limit = null;

        $table_join = null;
        $join_where = null;

        if (isset($data['where'])) {
            $where = 'WHERE '.$data['where'];
            //
        }
        if (isset($data['order_by'])) {
            $order_by = 'ORDER BY '.$data['order_by'];
            //
        }
        if (isset($data['order'])) {
            $order = $data['order'];
            //
        }
        if (isset($data['limit'])) {
            $limit = 'LIMIT '.$data['limit'];
            //
        }
        if (isset($join['table'])) {
            if (!isset($data['where'])) {
                $join_where = $join['where'];
                $table_join = ', '.$join['table'].' WHERE ';
            }
            else{
                $table_join = ', '.$join['table'];
                $join_where = ' AND '.$join['where'];
            }
            
            //
        }
        $sql = "SELECT * FROM $table $table_join $where $join_where $order_by $order $limit";
        //var_dump($sql);
        $query = $this->dbh2->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function fetchAll3($table,$data = array('where','order_by','order','limit'),$join = array('table','where')){
        //var_dump($data['order_by']);die();
        $where = null;
        $order_by = null;
        $order = null;
        $limit = null;

        $table_join = null;
        $join_where = null;

        if (isset($data['where'])) {
            $where = 'WHERE '.$data['where'];
            //
        }
        if (isset($data['order_by'])) {
            $order_by = 'ORDER BY '.$data['order_by'];
            //
        }
        if (isset($data['order'])) {
            $order = $data['order'];
            //
        }
        if (isset($data['limit'])) {
            $limit = 'LIMIT '.$data['limit'];
            //
        }
        if (isset($join['table'])) {
            if (!isset($data['where'])) {
                $join_where = $join['where'];
                $table_join = ', '.$join['table'].' WHERE ';
            }
            else{
                $table_join = ', '.$join['table'];
                $join_where = ' AND '.$join['where'];
            }
            
            //
        }
        $sql = "SELECT * FROM $table $table_join $where $join_where $order_by $order $limit";
        //var_dump($sql);
        $query = $this->dbh3->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    /*
    * Lấy ID cuối cùng
    */
    public function getLast($table)
    {
        $sql = "SELECT * FROM $table ORDER BY ".$table."_id DESC LIMIT 1";
        $query = $this->dbh->prepare($sql);
        $query->execute();
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function getLast2($table)
    {
        $sql = "SELECT * FROM $table ORDER BY ".$table."_id DESC LIMIT 1";
        $query = $this->dbh2->prepare($sql);
        $query->execute();
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function getLast3($table)
    {
        $sql = "SELECT * FROM $table ORDER BY ".$table."_id DESC LIMIT 1";
        $query = $this->dbh3->prepare($sql);
        $query->execute();
        return $query->fetch(PDO::FETCH_OBJ);
    }
    
    /*
    * Lấy theo ID
    */
    public function getByID($table, $id)
    {
        return $this->getByField($table, $this->getPrimaryKey($table), $id);
    }

    public function getByID2($table, $id)
    {
        return $this->getByField2($table, $this->getPrimaryKey2($table), $id);
    }

    public function getByID3($table, $id)
    {
        return $this->getByField3($table, $this->getPrimaryKey3($table), $id);
    }
    
    /*
    * Lấy theo cột
    */
    public function getByField($table, $field, $value, $options = false)
    {
        $data = array($field=>$value);
        return $this->getByWhere($table, $data, $options);
    }

    public function getByField2($table, $field, $value, $options = false)
    {
        $data = array($field=>$value);
        return $this->getByWhere2($table, $data, $options);
    }

    public function getByField3($table, $field, $value, $options = false)
    {
        $data = array($field=>$value);
        return $this->getByWhere3($table, $data, $options);
    }
    
    /*
    * Lấy 1 dòng theo điều kiện
    */
    public function getByWhere($table, $data, $options = false)
    {
        $data = $this->filter($data, $table);
        $conditions = array();
        foreach($data as $key=>$value)
        {
            if($value==null)
            {
                $conditions[] = "$key IS NULL";
                unset($data[$key]);
            }
            else
            {
                $conditions[] = "$key=?";
            }
        }
        $str = implode(' AND ', $conditions);
        $sql = "SELECT * FROM $table WHERE $str";
        if($options)
        {
            $sql .= ' ' . $options;
        }
        $query = $this->dbh->prepare($sql);
        $query->execute(array_values($data));
        return $query->fetch(PDO::FETCH_OBJ);           
    }

    public function getByWhere2($table, $data, $options = false)
    {
        $data = $this->filter2($data, $table);
        $conditions = array();
        foreach($data as $key=>$value)
        {
            if($value==null)
            {
                $conditions[] = "$key IS NULL";
                unset($data[$key]);
            }
            else
            {
                $conditions[] = "$key=?";
            }
        }
        $str = implode(' AND ', $conditions);
        $sql = "SELECT * FROM $table WHERE $str";
        if($options)
        {
            $sql .= ' ' . $options;
        }
        $query = $this->dbh2->prepare($sql);
        $query->execute(array_values($data));
        return $query->fetch(PDO::FETCH_OBJ);           
    }

    public function getByWhere3($table, $data, $options = false)
    {
        $data = $this->filter3($data, $table);
        $conditions = array();
        foreach($data as $key=>$value)
        {
            if($value==null)
            {
                $conditions[] = "$key IS NULL";
                unset($data[$key]);
            }
            else
            {
                $conditions[] = "$key=?";
            }
        }
        $str = implode(' AND ', $conditions);
        $sql = "SELECT * FROM $table WHERE $str";
        if($options)
        {
            $sql .= ' ' . $options;
        }
        $query = $this->dbh3->prepare($sql);
        $query->execute(array_values($data));
        return $query->fetch(PDO::FETCH_OBJ);           
    }
    
    /*
    * Lấy tất cả theo điều kiện
    */
    public function getAllByWhere($table, $data, $options = false)
    {
        $data = $this->filter($data, $table);
        $conditions = array();
        foreach($data as $key=>$value)
        {
            if($value==null)
            {
                $conditions[] = "$key IS NULL";
                unset($data[$key]);
            }
            else
            {
                $conditions[] = "$key=?";
            }
        }
        $str = implode(' AND ', $conditions);
        $sql = "SELECT * FROM $table WHERE $str";
        if($options)
        {
            $sql .= ' ' . $options;
        }
        $query = $this->dbh->prepare($sql);
        $query->execute(array_values($data));
        return $query->fetchAll(PDO::FETCH_OBJ);            
    }

    public function getAllByWhere2($table, $data, $options = false)
    {
        $data = $this->filter2($data, $table);
        $conditions = array();
        foreach($data as $key=>$value)
        {
            if($value==null)
            {
                $conditions[] = "$key IS NULL";
                unset($data[$key]);
            }
            else
            {
                $conditions[] = "$key=?";
            }
        }
        $str = implode(' AND ', $conditions);
        $sql = "SELECT * FROM $table WHERE $str";
        if($options)
        {
            $sql .= ' ' . $options;
        }
        $query = $this->dbh2->prepare($sql);
        $query->execute(array_values($data));
        return $query->fetchAll(PDO::FETCH_OBJ);            
    }

    public function getAllByWhere3($table, $data, $options = false)
    {
        $data = $this->filter3($data, $table);
        $conditions = array();
        foreach($data as $key=>$value)
        {
            if($value==null)
            {
                $conditions[] = "$key IS NULL";
                unset($data[$key]);
            }
            else
            {
                $conditions[] = "$key=?";
            }
        }
        $str = implode(' AND ', $conditions);
        $sql = "SELECT * FROM $table WHERE $str";
        if($options)
        {
            $sql .= ' ' . $options;
        }
        $query = $this->dbh3->prepare($sql);
        $query->execute(array_values($data));
        return $query->fetchAll(PDO::FETCH_OBJ);            
    }
    
    public function filter($insert, $table)
    {
        $columns = $this->dbh->query("SHOW COLUMNS FROM `$table`")->fetchAll();
        $fields = array();
        foreach($columns as $row)
        {
            $fields[$row['Field']] = true;
        }
        
        foreach($insert as $key=>$value)
        {
            if(!isset($fields[$key]))
            {
                unset($insert[$key]);
            }
        }
        
        if(count($insert)===0)
        {
            throw new Exception('At least one field must be passed as data.  Check to make sure fields exist in Database');
        }
        return $insert;
    }

    public function filter2($insert, $table)
    {
        $columns = $this->dbh2->query("SHOW COLUMNS FROM `$table`")->fetchAll();
        $fields = array();
        foreach($columns as $row)
        {
            $fields[$row['Field']] = true;
        }
        
        foreach($insert as $key=>$value)
        {
            if(!isset($fields[$key]))
            {
                unset($insert[$key]);
            }
        }
        
        if(count($insert)===0)
        {
            throw new Exception('At least one field must be passed as data.  Check to make sure fields exist in Database');
        }
        return $insert;
    }

    public function filter3($insert, $table)
    {
        $columns = $this->dbh3->query("SHOW COLUMNS FROM `$table`")->fetchAll();
        $fields = array();
        foreach($columns as $row)
        {
            $fields[$row['Field']] = true;
        }
        
        foreach($insert as $key=>$value)
        {
            if(!isset($fields[$key]))
            {
                unset($insert[$key]);
            }
        }
        
        if(count($insert)===0)
        {
            throw new Exception('At least one field must be passed as data.  Check to make sure fields exist in Database');
        }
        return $insert;
    }
    
    public function getPrimaryKey($table)
    {
        $sql = "SHOW KEYS FROM $table WHERE Key_name = 'PRIMARY'";
        $stmt = $this->dbh->query($sql);    
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res->Column_name;
    }

    public function getPrimaryKey2($table)
    {
        $sql = "SHOW KEYS FROM $table WHERE Key_name = 'PRIMARY'";
        $stmt = $this->dbh2->query($sql);    
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res->Column_name;
    }

    public function getPrimaryKey3($table)
    {
        $sql = "SHOW KEYS FROM $table WHERE Key_name = 'PRIMARY'";
        $stmt = $this->dbh3->query($sql);    
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res->Column_name;
    }
       
    function __destruct() {
        try {
            $this->dbh = null; //Closes connection
            $this->dbh2 = null; //Closes connection
            $this->dbh2;
            $this->dbh3 = null; //Closes connection
            $this->dbh3;
            return $this->dbh;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
} 