<?php 
	
    class f {
        private $a_private = 'a_private';
        public $b_public = 1;
        public $c_public;
        private $d_private;
        static $e_static;

        public function test() {
            var_dump(get_object_vars($this));
        }
    }

    $test = new f;

    
    
    $a = array(
        1 => 36,
        2 => 45
    );
    
	v_v($test);
	v_r($test);
    
    // TODO: 
    /*
        Як генерувати код для копіювання? Наприклад if (is_object($var)) { echo $var->name; }
        Потрібно дізнатись список усіх властивостей обєкту get_object_vars()
    */
    

    
    /*******************************/
    
    /* ПРОГРАМА:
    
        v_v($a);
        v_r($a);
        objectUsage($obj);
        
    */
    
     
   
    
    
    
    // Красивий вардамп:    
    function v_v($var) {
        
        echo '
<style>
    pre {
        margin-left: 35px;
    }
    .dump_workspace {
        padding: 10px;
        margin: 10px;
        background-color: #f5f5e9;
        color: #160000;
        font-size: 13px;
    }
</style>

';
        echo '<div class="dump_workspace"><p><b>var_dump:</b></p><pre>';
        var_dump($var);
        echo '</pre><p>date: <b>'.date('Y/m/d H:i:s').'</b></p></div>';
    }
    
    // Красивий прінтер:    
    function v_r($var) {
        
        echo '
<style>
    pre {
        margin-left: 35px;
    }
    .dump_workspace {
        padding: 10px;
        margin: 10px;
        background-color: #f5f5e9;
        color: #160000;
        font-size: 13px;
    }
</style>

';
        echo '<div class="dump_workspace"><p><b>print_r:</b></p><pre>';
        print_r($var);
        echo '</pre>';
        
        if(is_object($var)) {
            objectUsage($var);
        }
        
        echo '<p>date: <b>'.date('Y/m/d H:i:s').'</b></p></div>';
    }
    
    // Приклад використання обєкта:
    function objectUsage($obj) {
        
        echo '<p><b>Object usage:</b></p>';
        
        $array = (array)$obj;
        foreach ($array as $key => $value) {
            echo '$obj->'.$key.'<br>';
        }
    }