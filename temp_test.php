<form action="" method="post">
<input type="hidden" name="status_1" value="0" />
<input type="checkbox" id="status_1" name="status_1" value="1" />
<input type="hidden" name="status_2" value="0" />
<input type="checkbox" id="status_2" name="status_2" value="1" />
<input type="hidden" name="status_3" value="0" />
<input type="checkbox" id="status_3" name="status_3" value="1" />
<input type="submit" />
</form>
<?php
var_dump($_POST);
?>