<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8"/>        
        <title></title>
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
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

        <h1>Display Duplicates</h1>
        <?php
        require_once './duplicatesEngine.php';

        $file_in_dir = array_diff(scandir('duplicates'), array('..', '.'));
        if (!empty($file_in_dir)) {
            echo "<center><br/>";
            $duplicates_array = readDuplicatedTo2DArray('duplicates/' . $file_in_dir[2]);
            echoDuplicatesDropdown($duplicates_array);
            echo "</center>";
        } else {
            echo "Please Upload File (No Files to in Duplicate Directory)";
        }
        ?>

        <script>
            $(document).ready(function () {
                $(document).on("click", "input", function () {
                    //alert(this.id);
                    var btnID = this.id;
                    var sourceName = btnID.replace("btn_", "");
                    var btnIDAjax = '#' + btnID;
                    // alert(sourceName);
                    $(btnIDAjax).prop("disabled", true);
                    var selectIDAjax = "#sel_" + sourceName + " option:selected";
                    //alert(selectIDAjax);
                    var targetName = $(selectIDAjax).val();
                    //alert(targetName);

                    var lblIDAjax = "#lbl_" + sourceName;
                    var send_data = {s_val: sourceName, t_val: targetName};
                    $.ajax({
                        type: "POST",
                        url: "duplicatesEngine.php",
                        data: send_data,
                        success: function (msg) {
                            // $(tmp).prop('value', 'Success');
                            //alert(msg);

                            $(lblIDAjax).text(msg);
                        },
                        error: function (fmsg) {
                            $(lblIDAjax).text("Error Occurred! " + fmsg.toString());
                        },
                        done: function (msg) {
                            $(lblIDAjax).text("Done." + msg.toString());
                        }
                    });
                }
                );
            }
            );
            // alert("Idan after ajax");



        </script>
    </center>
    <center> <a href="main_menu.php"><h3>Back to Main Menu</h3></a></center>
</body>

</html>
