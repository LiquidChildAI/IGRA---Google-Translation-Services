<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>  
        <style>
            table, th, td {
                border: 1px solid black;
                padding: 5px;
                border-collapse: collapse;
            }
        </style>
    </head>
    <body>  
    <center>
        <h1>Translate with Google</h1>
        <br/>

        <?php
        require_once './googleTranslate.php';

        $file_in_dir = array_diff(scandir('upload'), array('..', '.'));
        if (!empty($file_in_dir)) {
            //$file_path = 'upload/'.$file_in_dir[2];
            echo 'File in dir: ' . 'upload/READY' . $file_in_dir[2];
            readAndSetWorkingFile($file_in_dir[2]);
            readValueNPrintGTranslate('upload/READY' . $file_in_dir[2], 'en', 'iw');
            rename('upload/READY' . $file_in_dir[2], 'processed/READY' . $file_in_dir[2]);
        } else {
            echo 'No Files in Directory';
        }
        ?>    
        <a href="main_menu.php"><h3>Back to Main Menu</h3></a>
    </center>
</body>
</html>
