<?php
/*
    
    Дорогой Валерий!
    
    В этом файле содержится класс для очистки контента.
    Пожалуйста, не редактируйте код ниже без необходимости.
    
    Вот список всех методов для очистки контента, которые вы можете использовать:

        cleaner::iframe_to_end($string); // iframe видео изменяет код на embed и перемещается в конец поста
        cleaner::clean_scripts($string); // удаляет все скрипты
        cleaner::clean_css($string); // удаляет все стили
        cleaner::clean_elements($string,$ban_string); // удаляет указанные в настройках блоки
        cleaner::clean_html_styles($string); // удаляет стили, которые прописаны в html
        cleaner::clean_inputs($row['body']); // удаляет все инпуты
        cleaner::clean_buttons($row['body']); // удаляет все кнопки
        cleaner::clean_forms($row['body']); // удаляет все кнопки
        cleaner::clean_images($row['body']); // удаляет все картинки
        cleaner::clean_tag($row['body'],$tag); // имя тега, например i
        cleaner::remove_html_comments($row['body']); // удаляет все html комментарии <!--- --->
        cleaner::find_and_delete_text($string,$tag,$keywords); // ищем текст в блоках и удаляем
        cleaner::clean_tweets($string); // превращает твиты в специальный блок
        
        cleaner::full_body_clean($string); // удаляет сразу много ненужного
    
        
        Пишите мне в телеграм, если еще понадоблюсь: https://telegram.me/vlad_salabun
        
        
   
    #################################################################################
   
   
   
   
    
    Примеры:
    
    // Обязательная проверка:
    $header_block = $this->get_site_cfg('header_block',$siteId);
    $body_block = $this->get_site_cfg('body_block',$siteId);
    $ban_string = $this->get_site_cfg('ban_blocks',$siteId);
    
    if(strlen($header_block) == 0) {
        $this->consolemsg("Не указано с какого блока брать заголовок для сайта №".$siteId);
        return 0;
    }
    if(strlen($body_block) == 0) {
        $this->consolemsg("Не указано с какого блока брать контент для сайта №".$siteId);
        return 0;
    }
    
    
    
    // Очистка контента: 
    $row['body'] = cleaner::full_body_clean($row['body']);
    $row['body'] = cleaner::remove_html_comments($row['body']);
    $row['body'] = cleaner::clean_elements($row['body'],$ban_string);
    $row['body'] = cleaner::clean_tag($row['body'],'svg');
    $row['body'] = cleaner::clean_tag($row['body'],'figure');
    $row['body'] = cleaner::clean_tweets($row['body']);
    
    // Короткий путь: 
    $row['body'] = cleaner::full_body_clean($row['body']);
    $row['body'] = cleaner::clean_elements($row['body'],$ban_string);
   
   
   
*/
        
        
class cleaner 
{
    public static function full_body_clean($string) {
        
        $string = self::clean_html_styles($string);
        $string = self::clean_scripts($string);
        $string = self::iframe_to_end($string);
        $string = self::clean_forms($string);
        $string = self::clean_inputs($string);
        $string = self::clean_buttons($string);
        //$string = self::clean_images($string); // Удалять картинки из постов?
        
        return $string; 
    }
    
    
    public static function iframe_to_end($string) {

        // Парсим данные в строку:
        $new_string = str_get_html($string);
        $temp = '';
        
        // Ищем все элементы:        
        $elements = $new_string->find('iframe');
        
        if(count($elements) > 0) {
            for ($i = 0; $i < count($elements); $i++) {
                
                // Берем ресурс:
                $iframe_src = $new_string->find('iframe',$i)->src;
                
                // Добавляем в конец строки:
                $temp .= '<p><embed src="'.$iframe_src.'" width="100%" height="300"></embed></p>';
                
                // Удаляем элемент:
                $new_string->find('iframe',$i)->outertext = '';
            }

            $new_string .= $temp;
        }
        
        return $new_string;
 
    }
    
    public static function clean_scripts($string) {
        
        // Парсим данные в строку:
        $new_string = str_get_html($string);
        
        // Ищем все скрипты:        
        $scripts = $new_string->find('script');
        
        if(count($scripts) > 0) {
            // Удаляем все скрипты:
            for ($i = 0; $i < count($scripts); $i++) {
                $new_string->find('script',$i)->outertext = '';
            }
        }
        
        return $new_string;
    }
    
    public static function clean_css($string) {
        
        // Парсим данные в строку:
        $new_string = str_get_html($string);
        
        // Ищем все скрипты:        
        $scripts = $new_string->find('style');

        if(count($scripts) > 0) {
            // Удаляем все скрипты:
            for ($i = 0; $i < count($scripts); $i++) {
                $new_string->find('style',$i)->outertext = '';
            }
        }
        
        return $new_string;
    }
    
    /* 
        Clean_elements example:
        $ban_string = '.fisrt, .second a, #third'; 
    */
    public static function clean_elements($string,$ban_string = null) {
        
        // Парсим данные в строку:
        $new_string = str_get_html($string);
        
        if(strlen($ban_string) > 0) {
            
            $ban_array = explode(',',$ban_string);
            
            if(count($ban_array) > 0) {
                foreach ($ban_array as $key => $value) {

                    // Ищем все элементы:        
                    $elements = $new_string->find(trim($value));

                    if(count($elements) > 0) {
                        // Удаляем все элементы:
                        for ($i = 0; $i < count($elements); $i++) {
                            $new_string->find(trim($value),$i)->outertext = '';
                        }
                    }
                }
            }
            
        }
        
        return $new_string;
    }
    
    public static function clean_html_styles($string) {

        // Парсим данные в строку:
        $new_string = str_get_html($string);

        // Ищем все элементы:        
        $elements = $new_string->find('*[style]');
        
        if(count($elements) > 0) {
            // Удаляем все элементы:
            for ($i = 0; $i < count($elements); $i++) {
                $new_string->find('*[style]',$i)->style = '';
            }
        }

        return $new_string;
        
    }
    
    public static function clean_inputs($string) {

        // Парсим данные в строку:
        $new_string = str_get_html($string);

        // Ищем все элементы:        
        $elements = $new_string->find('input');
        
        if(count($elements) > 0) {
            // Удаляем все элементы:
            for ($i = 0; $i < count($elements); $i++) {
                $new_string->find('input',$i)->outertext = '';
            }
        }

        return $new_string;
        
    }
    
    public static function clean_buttons($string) {

        // Парсим данные в строку:
        $new_string = str_get_html($string);

        // Ищем все элементы:        
        $elements = $new_string->find('button');
        
        if(count($elements) > 0) {
            // Удаляем все элементы:
            for ($i = 0; $i < count($elements); $i++) {
                $new_string->find('button',$i)->outertext = '';
            }
        }

        return $new_string;
        
    }
    
    public static function clean_forms($string) {

        // Парсим данные в строку:
        $new_string = str_get_html($string);

        // Ищем все элементы:        
        $elements = $new_string->find('form');
        
        if(count($elements) > 0) {
            // Удаляем все элементы:
            for ($i = 0; $i < count($elements); $i++) {
                $new_string->find('form',$i)->outertext = '';
            }
        }

        return $new_string;
        
    }
    
    
    public static function clean_images($string) {

        // Парсим данные в строку:
        $new_string = str_get_html($string);

        // Ищем все элементы:        
        $elements = $new_string->find('img');
        
        if(count($elements) > 0) {
            // Удаляем все элементы:
            for ($i = 0; $i < count($elements); $i++) {
                $new_string->find('img',$i)->outertext = '';
            }
        }

        return $new_string;
        
    }
    
    public static function clean_tag($string,$tag) {

        // Парсим данные в строку:
        $new_string = str_get_html($string);

        // Ищем все элементы:        
        $elements = $new_string->find($tag);
        
        if(count($elements) > 0) {
            // Удаляем все элементы:
            for ($i = 0; $i < count($elements); $i++) {
                $new_string->find($tag,$i)->outertext = '';
            }
        }

        return $new_string;
        
    }
    
    public static function remove_html_comments($content = '') {
        return preg_replace('/<!--(.|\s)*?-->/', '', $content);
    }
    
    public static function find_and_delete_text($string,$tag,$keywords) {

        // Парсим данные в строку:
        $new_string = str_get_html($string);

        // Ищем все элементы:        
        $elements = $new_string->find($tag);
        
        if(count($elements) > 0) {
            // Проверяю каждый запрос:
            foreach ($keywords as $keyword) {
                // Проверяю каждый элемент:
                for ($i = 0; $i < count($elements); $i++) {
                    
                    // Беру элемент:
                    $temp_string = $new_string->find($tag,$i)->outertext;
                    $pos = strpos($temp_string, $keyword);

                    // Ищу:
                    if ($pos === false) {
                        //
                    } else {
                       // Удаляю все элементы, где содержится такое слово:
                       $new_string->find($tag,$i)->outertext = '';
                    }

                }
            }
        }

        return $new_string;
        
    }
    
    public static function clean_tweets($string) {

        // Парсим данные в строку:
        $new_string = str_get_html($string);

        // Ищем все элементы:        
        $elements = $new_string->find('blockquote.twitter-tweet');
        
        if(count($elements) > 0) {
            // Удаляем все элементы:
            for ($i = 0; $i < count($elements); $i++) {
                
                $add = $new_string->find('blockquote.twitter-tweet',$i)->outertext . ' <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>';
                
                $new_string->find('blockquote.twitter-tweet',$i)->outertext = $add;
                    
            }
        }

        return $new_string;
        
    }
    
    public static function fix_relative_links($string,$url) {
        
        // Парсим данные в строку:
        $new_string = str_get_html($string);

        // Ищем все изображения:        
        $elements = $new_string->find('img');
        
        if(count($elements) > 0) {
            // Если изображения есть:
            for ($i = 0; $i < count($elements); $i++) {
                
                // Узнаю их url:
                preg_match('@^([\D]+://)?([^/]+)@i', $elements[$i]->src, $matches);
                $domen = $matches[0];
                
                if($domen != $url) {
                    // Если домен не указан, значит путь относительный, исправляю:
                    $new_string->find('img',$i)->src = $url.$elements[$i]->src;
                }       
            }
        }

        return $new_string;
    }
    
    
} 