<?php

declare (strict_types=1);

function readFirstColumnOfCSVFile($filename) {
    try {
        ini_set("memory_limit", "128M");
        ini_set('auto_detect_line_endings', "TRUE");

        if (($fp = fopen($filename, 'r'))) {
            $firstColumn = array();
            while (!feof($fp) && ( $line_of_text = fgets($fp))) {

                $line_of_text = iconv('Windows-1255', 'UTF-8', $line_of_text);
                
                //$line_of_text = iconv("ISO-8859-8", "UTF-8", $line_of_text);
                //var_dump($line_of_text);
                $i = 0;
                $word = '';
                for (; ($c = $line_of_text[$i]) !== ','; $i++) {
                  if ( ($c === chr(0xFB4B) )){
                       $c = 'ו';
                   }
                    
                    $word = $word . $c;
                }
                array_push($firstColumn, $word);
            }
        }
        ini_set('auto_detect_line_endings', "FALSE");
        fclose($fp);
        $fp = NULL;
        echo '<br>*The CSV file: ' . $filename . ' @ \'' . __FUNCTION__ . '\' READ SUCESSFULLY.';
        array_shift($firstColumn);
        return $firstColumn;
    } catch (Exception $ex) {
        echo '<br>An Error Occurred in function: \'readCSV\' , ' . $filename . ', at TransliterationHandler.php. ' . $ex->getMessage();
        return FALSE;
    }
}

?>
