<?php 
	
    // Проверка существует ли файл:
    function v_file($file, $create = 0, $filename = null) {
        
        if(file_exists($file)) {
            
            // Если существует, сообщаем:
            return true;
            
        } else {
            
            if($create == 1) { 
                // Если флаг указан, создаю файл:
                fopen($file, "w");
            } else {
                // Если нет ни папки ни флага, показываю ошибку:
                die('Не существует файл <b>'.$file.'</b>');
            }
            
        }
    }
    
    // Записать данные в файл:
    function v_fwrite($file, $content, $write = 'rewrite') {
        
        if($write == 'rewrite') {
            // Если указан флаг, то пересоздаю файл:
            $fd = fopen($file, 'w') or die("не удалось создать файл");
            fwrite($fd, $content);
            fclose($fd);
        } else if($write == 'append') {
            // Дописать в начало файла:
            $new_content = $content . PHP_EOL;
            $new_content .= file_get_contents($file); 
            file_put_contents($file, $new_content);
        }
        
        return true;
        
    }