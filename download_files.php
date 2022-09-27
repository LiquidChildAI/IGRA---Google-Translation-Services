<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
    <center>
        <h1>Download Processed Files</h1>
        <br/>
        <?php
        $file_in_dir = array_diff(scandir('processed'), array('..', '.'));
        if (!empty($file_in_dir)) {
            echo "<center><br/>";
            foreach ($file_in_dir as $file) {
                echo '<a href="processed/' . $file . '">' . $file . '</a><br/><br/>';
            }
            echo "</center>";
        } else {
            echo "No Files to Download";
        }
        ?>
        <a href="main_menu.php"><h3>Back to Main Menu</h3></a>
    </center>

</body>
</html>
