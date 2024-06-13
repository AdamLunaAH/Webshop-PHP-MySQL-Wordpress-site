<?php
session_start();

define('DBSERVER', 'localhost'); // servername.
define('DBUSERNAME', 'ebutikMain'); // database username.
define('DBPASSWORD', 'ebutikMainPassword'); //  database password.
define('DBNAME', 'ebutik'); // database name.

// destroy session after 30 miniutes of inactivity
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
// update session if its longer than 30 minutes
if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} elseif (time() - $_SESSION['CREATED'] > 1800) {
    // session started more than 30 minutes ago
    session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
    $_SESSION['CREATED'] = time();  // update creation time
}

try {
    $conn = new PDO("mysql:host=" . DBSERVER . ";dbname=" . DBNAME, DBUSERNAME, DBPASSWORD);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>