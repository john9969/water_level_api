<?php
// /api_project/controller/WaterLevelController.php

require_once __DIR__ . '/../model/WaterLevelModel.php';
require_once __DIR__ . '/../config/ApiErrors.php';
class WaterLevelController {
    private WaterLevelModel $model;

    public function __construct() {
        $this->model = new WaterLevelModel();
    }

    public function handleGet(array $params): array {
        $requiredSet1 = ['table_name','serial_number', 'date_begin', 'number_of_element'];
        $requiredSet2 = ['table_name','serial_number', 'date_begin', 'date_end'];

        // Check if either set of required parameters is present
        $isSet1Valid = true;
        foreach ($requiredSet1 as $key) {
            if (empty($params[$key])) {
                $isSet1Valid = false;
                break;
            }
        }

        $isSet2Valid = true;
        foreach ($requiredSet2 as $key) {
            if (empty($params[$key])) {
                $isSet2Valid = false;
                break;
            }
        }
        if (!$this->model->tableExists($params['table_name'])) {
            return ApiErrors::response(ApiErrors::TABLE_NOT_FOUND);
        }

        if (!$this->model->serialExists($params['table_name'],$params['serial_number'])) {
            return ApiErrors::response(ApiErrors::SERIAL_NOT_FOUND);
        }

        if (!$isSet1Valid && !$isSet2Valid) {
            return ['error' => 'Missing required parameters. Provide either: ' .
                implode(', ', $requiredSet1) . ' or ' . implode(', ', $requiredSet2)];
        }

        if ($isSet1Valid) {
            $result =  $this->model->getDataFollowNumber(
                $params['table_name'],
                $params['serial_number'],
                $params['date_begin'],
                (int)$params['number_of_element']
            );
            if (empty($result)) {
                return ApiErrors::response(ApiErrors::NO_DATA_FOUND);
            }
            return $result;
        }

        if ($isSet2Valid) {
            $result = $this->model->getDataFollowDate(
                $params['table_name'],
                $params['serial_number'],
                $params['date_begin'],
                $params['date_end']
            );
            if(empty($result)){
                return ApiErrors::response(ApiErrors::NO_DATA_FOUND);
            }
            return $result;
        }

    // Fallback (should not reach here)
    return ['error' => 'Unexpected error occurred.'];
}
    public function handlePost(array $data): array {
        return ['message' => 'POST handler not implemented yet.'];
    }
}
?>