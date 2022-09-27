

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>    

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>  
    </head>
    <body>       

    <center>
        <h1>Upload CSV File</h1>
        <br/>
        <form id="frm_upload_csv" method="post" enctype="multipart/form-data">
            <br/>
            <label><b>Select file to upload:</b></label>
            <input type="file" name="csvFileUpload" id="fCsvFileUpload" size="50">
            <br/><br/>
            <label><b>Select Language of File:</b></label>
            <input type="radio" id="radio_csv_eng" name="csvInputLanguage" value="English">
            <label for="English">English</label>
            <input type="radio" id="radio_csv_heb" name="csvInputLanguage" value="Hebrew">
            <label for="Hebrew">Hebrew</label>
            <input type="button" onclick="uploadAndSubmitFunction()" id="bUploadCsvFile" value="Upload CSV File" name="submitCsvFile">
        </form>
        <br/><label id ="response" cols="70" rows="10" style="visibility: hidden"></label>


    </center>

    <script type="text/javascript">

        //Upload the CSV file to Server
        function uploadAndSubmitFunction() {

            jQuery(document).ready(function () {


                document.getElementById("response").style.visibility = "visible";
                $("#response").html("Uploading . ." + document.getElementById("fCsvFileUpload").name);
                document.getElementById('response').focus();
                //                    $("#uploadCsvform").slideUp();
                // create a FormData Object using your form dom element

                var form = new FormData(document.getElementById('frm_upload_csv'));
                //append files
                var file = document.getElementById('fCsvFileUpload').files[0];
                if (file) {
                    form.append('csvFileUpload', file);
                } else {
                    $("#response").text("Not File");
                }
                var fileLang = $("input[name='csvInputLanguage']:checked").val();
                form.append('fileLang', fileLang);
               // alert(fileLang);
                //call ajax 
                $.ajax({
                    //url: "googleTranslateM.php",
                    type: 'POST',
                    data: form,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        console.log(data);
                        $("#response").text("\n<br><br><hr>Success" + data + "<font color=\"blue\">Done.</font>");
                        document.getElementById("frm_upload_csv").reset();
                        document.getElementById("response").style.visibility = "visible";
                        //                            document.getElementById("orig").innerHTML("Original file: <a href=\"TransliterationCSV/" + file.toString() + "\">" + file + "</a>");
                    },
                    complete: function (XMLHttpRequest) {
                        var data = XMLHttpRequest.responseText;
                        console.log(data);
                        $("#response").text("\nComplete" + data + "<font color=\"blue\">Done.</font>");
                        document.getElementById("frm_upload_csv").reset();
                        document.getElementById("response").style.visibility = "visible";
                    },
                    error: function (data) {
                        alert("ERROR");
                        $("#response").text("\nerror" + data + "<font color=\"red\">Error.</font>");
                        document.getElementById("frm_upload_csv").reset();
                        document.getElementById("response").style.visibility = "visible";
                    }
                }).done(function () {
                    console.log('Done');
                    document.getElementById("frm_upload_csv").reset();
                    document.getElementById("response").style.visibility = "visible";
                }).fail(function () {
                    alert("fail!");
                    $("#response").text("\nFail<font color=\"red\">Error.</font>");
                    document.getElementById("uploadCsvform").reset();
                    document.getElementById("response").style.visibility = "visible";
                    //                        $("#uploadCsvform").show();
                    //                        $("#uploadCsvform").slideDown();

                });
            });
        }


    </script>

    <center> <a href="main_menu.php"><h3>Back to Main Menu</h3></a></center>
</body>
</html>
<?php
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