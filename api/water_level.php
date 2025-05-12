<?php
// /api_project/api/water_level.php
require_once __DIR__ . '/../controller/WaterLevelController.php';

header("Content-Type: application/json");

$controller = new WaterLevelController();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $response = $controller->handleGet($_GET);
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $response = $controller->handlePost($input);
        break;

    default:
        $response = ApiErrors::response([
            'status'     => 'UNSUPPORTED_METHOD',
            'error_code' => 1005
        ]);
        break;
}


echo json_encode($response);
?>