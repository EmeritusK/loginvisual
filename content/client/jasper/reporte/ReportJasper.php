<?php
session_start();

require_once '../../../api/conexion.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../../../../login.php");
    exit;
}
?>
<?php
include "main.php";

use simitsdk\phpjasperxml\PHPJasperXML;

$filename = __DIR__ . '/JasperReporte.jrxml';


$config = [
    'driver' => 'mysql',
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'name' => 'bd',
];

$report = new PHPJasperXML();
$report->load_xml_file($filename)
    ->setParameter(['reporttitle' => 'Database Report With Driver : ' . $config['driver']])
    ->setDataSource($config)
    ->export('Pdf');
?>