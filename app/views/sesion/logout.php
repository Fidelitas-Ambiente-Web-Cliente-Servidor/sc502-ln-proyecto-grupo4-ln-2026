<?php
session_start();
session_destroy();
header("Location: /sc502-ln-proyecto-grupo4-ln-2026/index.php?page=login");
exit;