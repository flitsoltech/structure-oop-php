<?php

require_once __DIR__ . '/controllers/StudentController.php';

$controller = new StudentController();
$action     = $_GET['action'] ?? 'index';

// Simple Front Router
match ($action) {
    'index'  => $controller->index(),
    'create' => $controller->create(),
    'store'  => $controller->store(),
    'edit'   => $controller->edit(),
    'update' => $controller->update(),
    'delete' => $controller->delete(),
    default  => $controller->index(),
};
