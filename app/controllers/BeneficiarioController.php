<?php
require_once __DIR__ . '/../../config/database.php';

class BeneficiarioController {
    public function showPanel() {
        require __DIR__ . '/../views/beneficiario/beneficiario-panel.php';
    }
}