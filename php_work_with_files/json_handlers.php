<?php 
	
    // Читать файл json из файла:
    function v_file_to_string($file,$to_array = 0) {
        
        if($to_array == 1){
            // Если флаг указан, то возвращаю массив:
            return json_decode(file_get_contents($file),true);
        } else {
            return file_get_contents($file);
        }
        
    }