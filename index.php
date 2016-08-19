<?php

include('include/db/db_conn.php');

$result_set = db_query("SELECT * FROM users");
$result = $result_set->fetch_assoc();

var_dump($result);

