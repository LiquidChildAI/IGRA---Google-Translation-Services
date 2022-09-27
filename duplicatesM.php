<?php

if (!empty($_POST)) {
    if (isset($_POST['s_val']) && isset($_POST['t_val'])) {
        try {
            $source_val = $_POST['s_val'];
            echo "Source in server : " . $source_val;
            $target_val = $_POST['t_val'];
            echo "Target in server : " . $target_val;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
?>