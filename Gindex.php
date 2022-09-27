<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
                padding: 5px;
            }
        </style>

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>  
    </head>
    <body>
        <!-- 
        </*?php
            $fp = fopen("word.txt","r");
            $line = fgets($fp);
            for ($i=0; $i<strlen($line); $i++)
            {
                echo hebrev($line[$i]) . " = " . ord($line[$i])." , ";
            }
            //echo $line;
            fclose($fp);
        
        ?*/>
        comment -->
        
        <?php
        require_once './googleTranslate.php';

        define("GOOGLE_EN_FILE", "SHORT.csv");
        define("GOOGLE_HEB_FILE", "SHORT_HEBREW.csv");
        define("BEFORE_ENG_FILE", "1963_Haifa A-R MISSING (513) SENT TO IDAN (1).csv");
        define("BEFORE_HEB_FILE", "Haredy_Engagements (87) SENT TO IDAN.csv");
        //readValueNPrintGTranslate(GOOGLE_EN_FILE,GOOGLE_TRANSLATE_ENGLISH,GOOGLE_TRANSLATE_HEBREW); // ENG -> HEB
        //readValueNPrintGTranslate(GOOGLE_HEB_FILE,GOOGLE_TRANSLATE_HEBREW,GOOGLE_TRANSLATE_ENGLISH); // HEB -> ENG
        readAndSetWorkingFile(BEFORE_HEB_FILE);
        ?>

        <form id="frm_upload_csv" method="post" enctype="multipart/form-data">
            <label><b>Select file to upload:</b></label>
            <input type="file" name="csvFileUpload" id="fCsvFileUpload" size="50">
            <input type="button" onclick="uploadAndSubmitFunction()" id="bUploadCsvFile" value="Upload CSV File" name="submitCsvFile">
        </form>
        <br/><label id ="response" cols="70" rows="10" style="visibility: hidden"></label>
        

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
                    }
                    else{
                        $("#response").text("Not File");
                    }
                    //call ajax 
                    $.ajax({
                        url: "googleTranslateM.php",
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

                            clearInterval();

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

    </body>
</html>
