<?php

require_once('db_cred.php');

/**
 * Connects to the database.
 */
function connect() {
  global $con;

  if ($con != NULL) {
    return;
  }

  $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  if ($con->connect_error) {
    echo 'Database connection failed: ' . $con->connect_error;
  }
}

/**
 * Sanitizes any given input.
 *
 * Specifically, removes all excess whitespace and slashes, converts special
 * HTML chars into UTF format, escapes apostrophes
 *
 * @param $data
 *
 * @return string|null
 *   The sanitized string or null.
 */
function sanitize($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = str_replace("'", "\'", $data);

  return $data;
}

/**
 * Perform a db query and close the connection afterwards.
 *
 * @param $sql
 *   The statement to make.
 * @param bool $KEEP_OPEN
 *   A flag to specify if the connection should stay open.
 *
 * @return mysqli_stmt|bool
 *   FALSE if an error occurs, mysqli statement otherwise.
 */
function db_query($sql, $KEEP_OPEN = false) {
  global $con;

  connect();

  // Execute the query, check for a well formed query, and return the result set or false.
  $rsltSet = $con->query($sql);
  if ($rsltSet === FALSE) {
    echo 'Error -> Query executed: ' . $sql . ' Message: ' . $con->error;

    return FALSE;
  }

  if (!$KEEP_OPEN) {
    close_con();
  }

  return $rsltSet;
}

function close_con() {
  global $con;

  if ($con != NULL) {
    $con->close();
  }
}
