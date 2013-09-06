<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once dirname (__FILE__) . "/class/class.MySQL.php";

class Model {
    public $db;
    public $table;
    
    
    public $config = array (
        "host" => "127.0.0.1",
        "user" => "root",
        "password" => "root",
        "database" => "bulkemails"
    );
    public $prefix = "";
     
    /*
    public $prefix = "bulkmailer_";
    
    public $config = array (
        "host" => "mysql.demo.letstalkfreely.com",
        "user" => "havegoodlucktk",
        "password" => "ChW8kvZ6",
        "database" => "freelanceworks"
    );*
     */
    
    
    
    function Model () {
        $this->db = new MySQL($this->config['database'], $this->config['user'], $this->config['password'], $this->config['host']);//, [MYSQL_HOST]);
        
    }
}

class Requests extends Model {
    
    function Requests () {
        $this->table = $this->prefix . "requests";
        parent::Model();
    }
    
    function bulk_save ($values, $guid)
    {
        $i = 0;
        
        foreach ($values as $key => $value) {
            
            $value['request_guid'] = uniqid();
            $value['file_guid'] = $guid;
            $value['request_created'] = time();
            
            $this->db->Insert ($value, $this->table);
        }
        
    }
    
    function getRequests ($guid)
    {
        $result = $this->db->Select ($this->table, "file_guid='$guid'");
        return $result;
    }
    
    function getRequestsByEmail ($email, $guid)
    {
        $result = $this->db->ExecuteSQL ("select * from " . $this->table . " where request_email='" . $email . "' AND file_guid='$guid' order by request_email");
        
        return $result;
        
    }
    
    function getEmails ($guid)
    {
        $result = $this->db->ExecuteSQL ("select request_email from " . $this->table . " where file_guid='" . $guid . "' order by request_email");
        
        return $result;
    }
}

class Files extends Model {
    
    function Files () {
        $this->table = $this->prefix . "files";
        parent::Model();
    }
    
    function save ($filename, $orignalname, $time = 0)
    {
        $guid = uniqid();
        
        $value = array (
            "file_name" => $filename,
            "file_orignalname" => $orignalname,
            "file_guid" => $guid,
            "file_created" => $time == 0 ? time() : $time
        );
        
        $id = $this->db->Insert ($value, $this->table);
        if (!empty ($id)) {
            return $guid;
        } else {
            return false;
        }
    }
    
    function get ($guid)
    {
        $result = $this->db->Select ($this->table, array ("file_guid" => $guid));
        return $result;
    }
    
    function getAll ()
    {
        $result = $this->db->Select ($this->table);
        return $result;
    }
}
?>
