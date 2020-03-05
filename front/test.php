<?php
session_start();
$old_session_id = session_id();
session_regenerate_id(true);

$new_session_id = session_id();

echo "<p>old_id:{$old_session_id}</p>";
echo "<p>new_id:{$new_session_id}</p>";
?>