<?php
// Database configuration -> localhost
//$db_host = "localhost";  // Tu host de InfinityFree
//$db_name = "ayi_bs_admin";  // Tu nombre de base de datos en InfinityFree
//$db_user = "root";  // Tu usuario de base de datos
//$db_pass = "";  // Tu contraseña de base de datos

// Database configuration -> Railway
//$db_host = "autorack.proxy.rlwy.net";  // Tu host de Railway
//$db_port = 18602; // Puerto público asignado
//$db_name = "ayi-bs-php";  // Tu nombre de base de datos en Railway
//$db_user = "root";  // Tu usuario de base de datos
//$db_pass = "Ayi2024*";  // Tu contraseña de base de datos

// Database configuration -> Railway
// Railway Public URL
$url = getenv("MYSQL_PUBLIC_URL");

// Parsear la URL
$db_info = parse_url($url);

// Extraer credenciales
$db_host = $db_info['host'];
$db_port = $db_info['port'];
$db_user = $db_info['user'];
$db_pass = $db_info['pass'];
$db_name = ltrim($db_info['path'], '/'); // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name, (int)$db_port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8mb4
$conn->set_charset("utf8mb4");

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS " . $db_name;
if ($conn->query($sql) === FALSE) {
    die("Error creating database: " . $conn->error);
}

$conn->select_db($db_name);

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === FALSE) {
    die("Error creating users table: " . $conn->error);
}

// Create pages table
$sql = "CREATE TABLE IF NOT EXISTS pages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    content LONGTEXT,
    slug VARCHAR(255) UNIQUE NOT NULL,
    last_modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === FALSE) {
    die("Error creating pages table: " . $conn->error);
}

// Create images table
$sql = "CREATE TABLE IF NOT EXISTS images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    filename VARCHAR(255) NOT NULL,
    path VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255),
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === FALSE) {
    die("Error creating images table: " . $conn->error);
}
?>
