<?php

if (!empty($_POST)) {
    if (isset($_POST['s_val']) && isset($_POST['t_val'])) {
        try {
            $source_val = $_POST['s_val'];
            echo "Source in server : " . $source_val;
            $target_val = $_POST['t_val'];
            echo "Target in server : " . $target_val;
            writeSourceTargetToFile("SourceTarget.csv", $source_val, $target_val);
            echo "-= OK =-";
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

function writeSourceTargetToFile($filename, $source, $target) {

    $data = $source . "," . $target . "\n";
    file_put_contents('processed/' . $filename, $data, FILE_APPEND);
}

function readDuplicatedTo2DArray($filename) {
    try {
        ini_set("memory_limit", "128M");
        ini_set('auto_detect_line_endings', "TRUE");

        if (($fp = fopen($filename, 'r'))) {
            $duplicates_array = null;  //2D Array that holds duplicate values for one term.          
            while (!feof($fp) && ( $line_of_text = fgets($fp))) {
                /*
                 *  Need to add: Heb to Eng & Eng to Heb part.
                 *  $line_of_text = iconv('Windows-1255', 'UTF-8', $line_of_text);                 
                 */

                //Remove unecessary chars from read line.
                $line_of_text = str_replace('"', '', $line_of_text);
                $line_of_text = str_replace("\r\n", '', $line_of_text);
                $line_of_text = str_replace("\n", '', $line_of_text);


                $pieces = explode(",", $line_of_text); // Divide the line into two parts (source and target).                               
                $duplicates_array[$pieces[1]][] = $pieces[0]; // Append value of "Source" to the becoming "Target-Source" array.
            }
            ini_set('auto_detect_line_endings', "FALSE");
            fclose($fp);
            $fp = NULL;
            echo '<br>*The CSV file: ' . $filename . ' @ \'' . __FUNCTION__ . '\' READ SUCESSFULLY.<br/><br/>';
            return $duplicates_array;
        }
    } catch (Exception $ex) {
        echo '<br>An Error Occurred in function: \'readCSV\' , ' . $filename . ', at TransliterationHandler.php. ' . $ex->getMessage();
        return FALSE;
    }
}

function echoDuplicatesDropdown($duplicates_array) {
    try {

        if (!empty($duplicates_array)) {
            //echo "Source\tDuplicate Values";

            $echo_string = '<table style="border: 1px solid black"><tr><th>Source Name</th><th>Duplicate Values</th><th>Accept</th><th>Server Status</th></tr>';

            foreach ($duplicates_array as $source => $duplicate_value) {
                //echo "<br/>";

                $echo_string .= "<tr><td>" . $source . "</td>";


                //echo $source; //. "  |  Duplicate Values are: ";

                $option_menu = '<select id="sel_' . $source . '">';

                foreach ($duplicate_value as $duplicate_item) {
                    $option_menu = $option_menu . '<option value ="' . $duplicate_item . '">' . $duplicate_item . '</option>';
                }
                $option_menu = $option_menu . '</select>';

                $echo_string .= '<td>' . $option_menu . '</td>';
                $accept_button = '<input type="button" id="btn_' . $source . '" value="ACCEPT"/>';

                $echo_string .= '<td>' . $accept_button . '</td>';
                //echo $option_menu;
                //echo "&#9";
                //echo $accept_button;
                $echo_string .= '<td><label id="lbl_' . $source . '"></td></tr>';
                ////echo '<label id="lbl_'.$source.'"></label>';
                //$echo_string .= '<tr><td>'.$source.'</td></tr>';
                
            }
            $echo_string .= '</table>';
            echo $echo_string;
        }
    } catch (Exception $e) {
        echo '<font color=\red\"><br>duplicatesEngine.php: Function \'echoDuplicatesDropdown\' An Error Occurred.<br>' . $e->getMessage() . "</font>";
        // die();
    }
}

?>
