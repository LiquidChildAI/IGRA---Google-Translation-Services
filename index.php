<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8"/>        
        <title></title>
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

    </head>
    <body>



        <?php
        print strftime('%c');      

        require_once './duplicatesEngine.php';
        
        $duplicates_array = readDuplicatedTo2DArray('files/duplicates.csv');
        //var_dump($duplicates_array);
        echoDuplicatesDropdown($duplicates_array);


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
                            $(lblIDAjax).text("Done.");
                        }
                    });
                }
                );
            }
            );
            // alert("Idan after ajax");



        </script>

    </body>

</html>
