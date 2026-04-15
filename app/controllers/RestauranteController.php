<?php
require_once __DIR__ . '/../../config/database.php';

class RestauranteController {
    public function showPanel() {
        require __DIR__ . '/../views/restaurante/restaurante-panel.php';
    }
}