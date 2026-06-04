<?php
define('SNMP_MIBS_PATH', __DIR__ . '/mibs');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['mib_file'])) {
    $file = $_FILES['mib_file'];
    
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'error' => 'Error al subir el archivo (Código: ' . $file['error'] . ').']);
        exit;
    }
    
    $filename = basename($file['name']);
    $destination = SNMP_MIBS_PATH . '/' . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        echo json_encode(['success' => true, 'filename' => $filename]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No se pudo guardar el archivo en la carpeta mibs. Verifica los permisos.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'No se recibió ningún archivo.']);
}
