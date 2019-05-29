<?php
/*
    Этот класс наблюдает за состоянием парсинга и сохраняет плохие ссылки, чтобы больше на них не натыкаться.
*/

class exampleWPDB
{
    
    $table = 'table_name';
    
    // INSERT
    public static function lock($url)
    {
        global $wpdb;
        
        $wpdb->insert(
            $this->table, 
            array (
                'url' => $url,
            ),
            array ('%s', '%s')
        );
        
        return $wpdb->insert_id;
    }
    
    // UPDATE
    public static function flag($id,$name) 
    {
        global $wpdb;
        
        $wpdb->update(
            $this->table,
            array($name => 1),
            array('ID' => $id)
        );
    }
    
    // DELETE
    public static function unlock($id = 0) 
    {
        global $wpdb;
        
        $wpdb->delete(
            $this->table,
            array('ID' => $id)
        ); 
    }
    
    // SELECT
    public static function check($url) 
    {
        global $wpdb;
        
        if(strlen($url) > 0) {
        
            $table = $this->table;
            $sql = $wpdb->prepare("SELECT * FROM $table WHERE url = %s", $url);
            $wpdb->get_row($sql, ARRAY_A );
            
            if($wpdb->num_rows > 0) {
                return true;
            } 
        }
        
        return false;
    }
    
    // SELECT
    public static function lastLocked() 
    {
        global $wpdb;
        
        $table = $this->table;
        
        return $wpdb->get_results("SELECT * FROM $table ORDER BY ID DESC LIMIT 100", ARRAY_A); 

    }
    
    // TRUNCATE
    public static function clear()
    {
        global $wpdb;
        
        $table = $this->table;
        
        $delete = $wpdb->query("TRUNCATE TABLE $table");
        
    }
    
    
    
}
  