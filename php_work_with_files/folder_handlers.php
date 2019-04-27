<?php 
	
    // Проверка существует ли папка:
    function v_folder($folder, $create = 0, $filename = null) {
        
        if(file_exists($folder)) {
            
            // Если существует, сообщаем:
            return true;
            
        } else {
            if($create == 1) {
                // Если флаг указан, создаю папку:
                mkdir("$folder", 0777);
            } else {
                // Если нет ни папки ни флага, показываю ошибку:
                die('Не существует папки <b>'.$folder.'</b>');
            }
        }
    }