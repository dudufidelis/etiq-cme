<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$material = $_POST['material'] ?? '';
$lote = $_POST['lote'] ?? '';
$data_esterilizacao = $_POST['data_esterilizacao'] ?? '';
$validade = $_POST['validade'] ?? '';
$temperatura = $_POST['temperatura'] ?? '';
$responsavel = $_POST['responsavel'] ?? '';

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$dompdf = new Dompdf($options);

$imgData = base64_encode(file_get_contents('logo.png'));
$src = 'data:image/png;base64,' . $imgData;

$html = '
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <style>
    @page { size: 90mm 30mm; margin: 0; }
    body { margin: 0; padding: 0; font-family: sans-serif; font-size: 10px; }
    .etiqueta { padding: 1mm 2mm; display: flex; flex-direction: column; align-items: center; font-size: 12px; }
    .linha { margin: 0; line-height: 1.2; }
    .label { font-weight: bold; }
  </style>
</head>
<body>
  <div class="etiqueta">
    <p class="linha"><span class="label">Saine Health Complex</span>
    <p class="linha"><br></p>
    <p class="linha"><span class="label">Material:</span> ' . htmlspecialchars($material) . '</p>
    <p class="linha"><span class="label">Auto. Sercon - Lote:</span> ' . htmlspecialchars($lote) . '</p>
    <p class="linha"><span class="label">Data Esterilização:</span> ' . htmlspecialchars($data_esterilizacao) . '<span class="label">  Validade:</span> ' . htmlspecialchars($validade) . '</p>
    <p class="linha"><span class="label">Temperatura Ciclo:</span> ' . htmlspecialchars($temperatura) . '</p>
    <p class="linha"><span class="label">Resp. Esterilização:</span> ' . htmlspecialchars($responsavel) . '</p>
  </div>
</body>
</html>
';


$dompdf->loadHtml($html);
$dompdf->setPaper([0, 0, 255.12, 85.04]); // 90mm x 30mm
$dompdf->render();
$dompdf->stream('etiqueta.pdf', ['Attachment' => false]);
