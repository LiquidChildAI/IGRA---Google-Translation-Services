<?php

define("apiKey", "YourAPI"); // API Key is used for Google Translation Services
define("GOOGLE_TRANSLATE_ENGLISH", "en");
define("GOOGLE_TRANSLATE_HEBREW", "iw");

function readAndSetWorkingFile($filename) {
    if (($fp = fopen('upload/'.$filename, 'r'))) {
        $row_num = 0;
        while (!feof($fp) && ( $line_of_text = fgets($fp))) {
            if ($row_num > 0) {
                $pieces = explode(",", $line_of_text);
                file_put_contents("upload/READY" . $filename, $pieces[0], FILE_APPEND);
            }
            $row_num++;
        }
        fclose($fp);
        rename('upload/'.$filename, 'originals/'.$filename);
    }
}

function readValueNPrintGTranslate($filename, $src_lang, $target_lang) {
    try {
        //echo "inside readValue";
        //echo $filename;
        $totalDocument = '<form action="/IGRA-11_2020-Transliteration/googleTranslateM" method="post">';
        $str_table = '<table style="border: 1px solid black"><tr><th>Source Name</th><th>Google Translate</th><th>Accept Google Value</th></tr>';
        $temp_bool = true;

        if (($fp = fopen($filename, 'r'))) {
            while (!feof($fp) && ( $line_of_text = fgets($fp))) {
                /* 
                if (strcmp($src_lang, GOOGLE_TRANSLATE_ENGLISH) === 0 && strcmp($target_lang, GOOGLE_TRANSLATE_HEBREW) === 0) {
                    $googleValue = askGoogle($line_of_text, GOOGLE_TRANSLATE_ENGLISH, GOOGLE_TRANSLATE_HEBREW);
                } else {
                    $googleValue = askGoogle($line_of_text, GOOGLE_TRANSLATE_HEBREW, GOOGLE_TRANSLATE_ENGLISH);
                }
                */
                // $googleValue = askGoogle($line_of_text, GOOGLE_TRANSLATE_ENGLISH, GOOGLE_TRANSLATE_HEBREW);
               $googleValue = 'TempValue'; //askGoogle($line_of_text, "en", "iw");  //;
                
                if (strpos($googleValue, ' ', 0) !== false) { // Omitting 2 words translation - (separated by space ' ').
                    continue;
                }

                $str_table .= '<tr><td>' . $line_of_text . '</td>'
                        . '<td>' . $googleValue . '</td>';

                $str_table .= '<td><input type="checkbox" id="chk_id_' . $line_of_text . '" name="' . $line_of_text . '" value="' . $googleValue . '"></td>'
                        . '</tr>'; // Create a checkbox for the Google Tranlation acceptance.
            }
        }
        $str_table .= '</table>';

        $totalDocument .= $str_table;
        $totalDocument .= '<br><button type="submit" formmethod="post">Accept</button></form>';

        echo $totalDocument;
    } catch (Exception $e) {
        
    }
}

function askGoogle($text, $src_lan, $target_lan) {
// For the Hebrew language use: iw 
// For English language use: en    
    //URL to apply on 'cURL' function in order to send to Google. 
    //The string includes the API Key, the text to translate, source & target languages.                 
    $url = 'https://www.googleapis.com/language/translate/v2?key=' . apiKey . '&q=' . rawurlencode($text) . '&source=' . $src_lan . "&target=" . $target_lan;
//$hebUrl = 'https://www.googleapis.com/language/translate/v2?key=' . $apiKey . '&q=' . rawurlencode($hebText) . '&source=iw&target=en';
//For self try the service in the web browser:  https://www.googleapis.com/language/translate/v2?key=AIzaSyBGCFPTYrIlXVB0rEe6DZ_8EF7wAfvtrLQ&q=hello&source=en&target=iw


    try {

        $ch = curl_init(); // Initialize handler variable for 'cURL'.
        if ($ch === false) {
            echo "@askGoogle function : Initializtion Failed";
            return;
        }

//Option parameters for handler varaible
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_AUTOREFERER => true,
            CURLOPT_CONNECTTIMEOUT => 300,
            CURLOPT_TIMEOUT => 300,
            CURLOPT_MAXREDIRS => 10,
        );
        curl_setopt_array($ch, $options);  // Apply options on '$ch' (handler variable).         
        $response = curl_exec($ch); // Execute & get response



        /* Debug:
         * 
          echo"<br/><br/>Response: ";
          var_dump($response);
         * 
         */

        $responseDecoded = json_decode($response, true); // Decode response to array
//print_r($responseDecoded);

        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // HTTP response code
        curl_close($ch); // Close handler

        if ($responseCode != 200) {
            echo 'Fetching translation failed! Server response code:' . $responseCode . '<br>';
            echo 'Error description: ' . $responseDecoded['error']['errors'][0]['message'];
            return false;
        } else {
//echo 'Source: ' . $text . '<br>';
//echo 'Translation: ' . $responseDecoded['data']['translations'][0]['translatedText'];
            return $responseDecoded['data']['translations'][0]['translatedText'];
        }
    } catch (Exception $e) {

        echo '<font color=\red\"><br>googleTranslate.php: Function \'askGoogle\' An Error Occurred.<br>' . $e->getMessage() . "</font>";
    }
}

?>
