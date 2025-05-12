<?php
class ApiErrors {
    public const TABLE_NOT_FOUND = ['status' => 'TABLE_NOT_FOUND', 'error_code' => 1001];
    public const SERIAL_NOT_FOUND = ['status' => 'SERIAL_NOT_FOUND', 'error_code' => 1002];
    public const NO_DATA_FOUND   = ['status' => 'NO_DATA_FOUND',   'error_code' => 1003];

    public static function response(array $error): array {
        return ['status' => $error['status'], 'error_code' => $error['error_code']];
    }
}

?>