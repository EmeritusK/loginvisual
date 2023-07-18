<?php
session_start();

require_once '../../api/conexion.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../../../login.php");
    exit;
}
?>

<?php

require('./fpdf.php');

class PDF extends FPDF
{

   // Cabecera de página
   function Header()
   {
      $this->SetDrawColor(0, 10, 0); 
      $this->Rect(10, 10, 190, 25, 'D'); 
      $this->SetFont('Courier', 'B', 20); 
      $this->SetTextColor(0, 0, 0); 
      $this->Cell(190, 25, utf8_decode('REPORTES ESTUDIANTES COMPUTACION VISUAL'), 0, 1, 'C'); 
      $this->Ln(10); 
      $this->SetTextColor(103); 

      //Datos Personales
      $this->SetFont('Courier', 'B', 12);
      $this->Cell(54, 10, utf8_decode('CREADOR DEL REPORTE:'), 0, 0, 'L');
      $this->SetFont('Courier', '', 12);
      $this->Cell(30, 10, utf8_decode('JAIR PAREDES'), 0, 0, 'L');
      $this->Ln();
      $this->SetFont('Courier', 'B', 12);
      $this->Cell(24, 10, utf8_decode('CARRERA: '), 0, 0, 'L');
      $this->SetFont('Courier', '', 12);
      $this->Cell(30, 10, utf8_decode('SOFTWARE'), 0, 0, 'L');
      $this->Ln();
      $this->SetFont('Courier', 'B', 12);
      $this->Cell(20, 10, utf8_decode('CURSO: '), 0, 0, 'L');
      $this->SetFont('Courier', '', 12);
      $this->Cell(30, 10, utf8_decode('CUARTO "A"'), 0, 0, 'L');
      $this->Ln();
      $this->SetFont('Courier', 'B', 12);
      $this->Cell(20, 10, utf8_decode('FECHA: '), 0, 0, 'L');
      $this->SetFont('Courier', '', 12);
      $this->Cell(30, 10, utf8_decode(date('d-m-Y')), 0, 0, 'L');
      $this->Ln();
      $this->Ln();

      /* TITULO DE LA TABLA */
      $this->SetTextColor(0, 0, 0);
      $this->Cell(50); 
      $this->SetFont('Courier', 'B', 15);
      $this->Cell(100, 10, utf8_decode("REPORTE DE ESTUDIANTES"), 0, 1, 'C', 0);
      $this->Ln(7);

      /* CAMPOS DE LA TABLA */
      $this->SetFillColor(255,255, 255); 
      $this->SetTextColor(0, 0, 0); 
      $this->SetDrawColor(163, 163, 163);
      $this->SetFont('Courier', 'B', 11);
      $this->Cell(33, 10, utf8_decode('CEDULA'), 1, 0, 'C', 1);
      $this->Cell(40, 10, utf8_decode('NOMBRE'), 1, 0, 'C', 1);
      $this->Cell(40, 10, utf8_decode('APELLIDO'), 1, 0, 'C', 1);
      $this->Cell(25, 10, utf8_decode('EDAD'), 1, 0, 'C', 1);
      $this->Cell(50, 10, utf8_decode('TELEFONO'), 1, 1, 'C', 1);
   }

   // Pie de página
   function Footer()
   {
      $this->SetY(-15); 
      $this->SetFont('Courier', 'I', 8); 
      $this->Cell(0, 10, utf8_decode('') . $this->PageNo() . '/{nb}', 0, 0, 'C'); 
      $this->SetY(-15); 
   }
}

include '../../api/conexion.php';


$pdf = new PDF();
$pdf->AddPage(); 
$pdf->AliasNbPages(); 

$i = 0;
$pdf->SetFont('Courier', '', 12);
$pdf->SetDrawColor(163, 163, 163); 

$consulta_reporte = $conectar->query("SELECT * FROM ESTUDIANTES");

while ($datos_reporte = $consulta_reporte->fetch_object()) { 
   $i = $i + 1;
   $pdf->Cell(33, 10, utf8_decode($datos_reporte->CEDULA), 1, 0, 'C', 0);
   $pdf->Cell(40, 10, utf8_decode($datos_reporte->NOMBRE), 1, 0, 'C', 0);
   $pdf->Cell(40, 10, utf8_decode($datos_reporte->APELLIDO), 1, 0, 'C', 0);
   $pdf->Cell(25, 10, utf8_decode($datos_reporte->EDAD), 1, 0, 'C', 0);
   $pdf->Cell(50, 10, utf8_decode($datos_reporte->TELEFONO), 1, 0, 'C', 0);
   $pdf->Ln();
   }



$pdf->Output('Prueba.pdf', 'I');
