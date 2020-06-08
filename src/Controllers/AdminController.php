<?php

namespace App\Controllers;

use App\Services\AuthService;
use App\Services\AuthServiceInterface;
use App\Services\TasksStorageInterface;

class AdminController
{
    /**
     * @var TasksStorageInterface
     */
    private TasksStorageInterface $storageService;
    /**
     * @var AuthServiceInterface
     */
    private AuthServiceInterface $authService;

    /**
     * AdminController constructor.
     *
     * @param TasksStorageInterface $storageService
     */
    public function __construct(TasksStorageInterface $storageService, AuthServiceInterface $authService)
    {
        $this->storageService = $storageService;
        $this->authService = $authService;
    }

    /**
     * @param array $request
     */
    public function login(array $request): void
    {
        if ($this->authService->isLoggedIn()) {
            header('Location: /tasks');

            return;
        }

        if (empty($request)) {
            $title = 'Login';
            require_once __DIR__.'/../Views/admin.php';

            return;
        }

        if ($this->authService->logIn($request['login'], $request['password'])) {
            header('Location: /tasks');

            return;
        }

        $message = 'Неверно введены логин или пароль';
        require_once __DIR__.'/../Views/admin.php';
    }

    /**
     *
     */
    public function logout(): void
    {
        $this->authService->logOut();
        header('Location: /tasks');
    }

    /**
     * @param int   $taskId
     * @param array $request
     */
    public function editTask(int $taskId, array $request): void
    {
        if (!$this->authService->isLoggedIn()) {
            header('Location: /admin/login');

            return;
        }

        if (empty($request)) {
            $title = 'Edit Task';
            $task = $this->storageService->getTaskById($taskId);
            require_once __DIR__.'/../Views/edittask.php';

            return;
        }

        $state = (int)$request['state'];
        $username = trim($request['username']);
        $email = trim($request['email']);
        $text = trim($request['text']);

        if (empty($username) || empty($email) || empty($text)) {
            $message = 'Заполните все поля';
            require_once __DIR__.'/../Views/edittask.php';

            return;
        }

        if ($this->storageService->editTask($taskId, $state, $username, $email, $text)) {
            $task = $this->storageService->getTaskById($taskId);
            $message = 'Успешно сохранено';
        }
        require_once __DIR__.'/../Views/edittask.php';
    }
}
