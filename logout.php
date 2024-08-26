<?php
session_start();
session_unset();
echo"
<script>
alert('Dear user you have Logged Out!');
location.assign('index.php');
</script>
";
?>