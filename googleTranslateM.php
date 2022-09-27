<?php

if (!empty($_POST)) {

    if (isset($_POST['fileLang'])) {
        echo '\nLanguage detected: ' . $_POST['fileLang'] . "\n";
    } else {

        foreach ($_POST as $key => $value) {
            $k_val = str_replace('"', '', $key);
            $k_val = str_replace("\r\n", '', $k_val);
            $k_val = str_replace("\n", '', $k_val);

            $v_val = str_replace('"', '', $value);
            $v_val = str_replace("\r\n", '', $v_val);
            $v_val = str_replace("\n", '', $v_val);


            $data = ($k_val . "," . $v_val . "\n");

            file_put_contents("processed/GoogleTranslated.csv", $data, FILE_APPEND);
            echo "Data Written to file: " . $data . '<br/>';
        }
        echo '<br/><br/><a href="main_menu.php"><h3>Back to Main Menu</h3></a>';
    }
}

if (!empty($_FILES)) {
    if ($_FILES["csvFileUpload"]["error"] > 0) {
        echo "Error: " . "File Error " . $_FILES["csvFileUpload"]["error"] . "<br>";
    } else {

        $file_name = $_FILES["csvFileUpload"]["name"];

        echo "-= File Upload Details: ";
        echo " *Filename: " . $file_name;
        echo " *Size: " . ($_FILES["csvFileUpload"]["size"] / 1024) . " kB";

        $file_src_path = "upload/" . $_FILES["csvFileUpload"]["name"];
        move_uploaded_file($_FILES["csvFileUpload"]["tmp_name"], $file_src_path);
        echo " *Moved to and Stored in: " . $file_src_path;
    }
}


?>