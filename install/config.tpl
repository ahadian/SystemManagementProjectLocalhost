<?php
    
    define('DATABASE_HOST', '<DB_HOST>');           // Database host
    define('DATABASE_NAME', '<DB_NAME>');           // Name of the database to be used
    define('DATABASE_USERNAME', '<DB_USER>');       // User name for access to database
    define('DATABASE_PASSWORD', '<DB_PASSWORD>');   // Password for access to database
    
    $manage = mysqli_connect(DATABASE_HOST,DATABASE_USERNAME,DATABASE_PASSWORD,DATABASE_NAME);
    
?>