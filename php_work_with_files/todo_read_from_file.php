<?php 
	
    $file_lines = file('usp_booksAndFilms.txt');
    
    
    $max = count($file_lines);
    
    for ($i = 17; $i < $max; $i++) {

        $parts = explode('|',$file_lines[$i]);
        var_dump($parts);
        die('');
    }
