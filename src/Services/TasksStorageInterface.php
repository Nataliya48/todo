<?php

namespace App\Services;

use App\Models\Task;

interface TasksStorageInterface
{
    /**
     * @param string|null $orderBy
     * @param string|null $direction
     * @param int         $offset
     * @param int         $limit
     *
     * @return array
     */
    public function getTasks(?string $orderBy, ?string $direction, int $offset, int $limit): array;

    /**
     * @return int
     */
    public function getTasksCount(): int;

    /**
     * @param string $username
     * @param string $email
     * @param string $text
     *
     * @return bool
     */
    public function createTask(string $username, string $email, string $text): bool;

    /**
     * @param int $taskId
     *
     * @return Task|null
     */
    public function getTaskById(int $taskId): ?Task;

    /**
     * @param int    $taskId
     * @param int    $state
     * @param string $username
     * @param string $email
     * @param string $text
     *
     * @return bool
     */
    public function editTask(int $taskId, int $state, string $username, string $email, string $text): bool;
}
