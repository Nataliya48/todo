<?php

use App\Controllers\AdminController;
use App\Controllers\TasksController;
use App\Services\AuthService;
use App\Services\DBStorageService;

require_once __DIR__.'/../vendor/autoload.php';

try {
    $storageService = DBStorageService::getInstance();
    $authService = new AuthService();
    $taskController = new TasksController($storageService, $authService);
    $adminController = new AdminController($storageService, $authService);
    $uri = $_SERVER['REQUEST_URI'];

    if (preg_match('/\/tasks\/create/i', $uri)) {
        $taskController->createTask($_POST);

        return;
    }

    if (preg_match('/\/tasks\/edit\/(\d+)/i', $uri, $matches)) {
        $taskId = (int)$matches[1];
        $adminController->editTask($taskId, $_POST);

        return;
    }

    if (preg_match('/\/tasks/i', $uri)) {
        $page = (int)$_GET['page'];
        $orderBy = (string)$_GET['sorting'];
        $direction = (string)$_GET['direction'];
        $taskController->getTasks($page, $orderBy, $direction);

        return;
    }

    if (preg_match('/\/admin\/login/i', $uri)) {
        $adminController->login($_POST);

        return;
    }

    if (preg_match('/\/admin\/logout/i', $uri)) {
        $adminController->logout();

        return;
    }

    header('Location: /tasks');
} catch (Throwable $e) {
    echo $e->getMessage();
}
