<?php
require_once __DIR__ . '/../../config/database.php';

class AdminController {
    public function showPanel() {
        require __DIR__ . '/../views/admin/admin-panel.php';
    }
}