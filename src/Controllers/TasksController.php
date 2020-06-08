<?php

namespace App\Controllers;

use App\Services\AuthServiceInterface;
use App\Services\TasksStorageInterface;

class TasksController
{
    private const TASKS_COUNT_PER_PAGE = 3;

    /**
     * @var TasksStorageInterface
     */
    private TasksStorageInterface $storageService;
    /**
     * @var AuthServiceInterface
     */
    private AuthServiceInterface $authService;

    /**
     * TasksController constructor.
     *
     * @param TasksStorageInterface $storageService
     * @param AuthServiceInterface  $authService
     */
    public function __construct(TasksStorageInterface $storageService, AuthServiceInterface $authService)
    {
        $this->storageService = $storageService;
        $this->authService = $authService;
    }

    /**
     * @param int         $page
     * @param string|null $orderBy
     * @param string|null $direction
     */
    public function getTasks(int $page = 1, ?string $orderBy = null, ?string $direction = null): void
    {
        if ($page == 0) {
            $page = 1;
        }
        $offset = ($page - 1) * self::TASKS_COUNT_PER_PAGE;
        $tasks = $this->storageService->getTasks($orderBy, $direction, $offset, self::TASKS_COUNT_PER_PAGE);
        $tasksCount = $this->storageService->getTasksCount();
        $pagesCount = intdiv($tasksCount, self::TASKS_COUNT_PER_PAGE);
        if ($tasksCount % self::TASKS_COUNT_PER_PAGE) {
            $pagesCount += 1;
        }
        $links = [];
        for ($i = 1; $i <= $pagesCount; $i++) {
            $getParams = [
                'page' => $i,
            ];
            if ($orderBy != null) {
                $getParams['sorting'] = $orderBy;
            }
            if ($direction != null) {
                $getParams['direction'] = $direction;
            }
            $links[] = [
                'url'     => sprintf(
                    '%s?%s',
                    $_SERVER['PATH_INFO'],
                    http_build_query($getParams)
                ),
                'current' => $i == $page,
            ];
        }
        $title = 'Todo';
        require_once __DIR__.'/../Views/tasks.php';
    }

    /**
     * @param array $request
     */
    public function createTask(array $request): void
    {
        if (empty($request)) {
            $title = 'Create Task';
            require_once __DIR__.'/../Views/createtask.php';

            return;
        }
        $username = trim($request['username']);
        $email = trim($request['email']);
        $text = trim($request['text']);

        if (empty($username) || empty($email) || empty($text)) {
            $message = 'Заполните все поля';
            require_once __DIR__.'/../Views/createtask.php';

            return;
        }

        if ($this->storageService->createTask($username, $email, $text)) {
            $message = 'Успешно сохранено';
        }
        require_once __DIR__.'/../Views/createtask.php';
    }
}
