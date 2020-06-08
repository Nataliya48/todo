<?php

namespace App\Services;

use App\Models\Task;
use Dotenv\Dotenv;
use PDO;

class DBStorageService implements TasksStorageInterface
{
    private const TASKS_COLUMNS = ['id', 'username', 'email', 'text', 'state', 'edited'];
    private const DIRECTIONS = ['asc', 'desc'];
    private const DEFAULT_DIRECTION = 'asc';

    /**
     * @var DBStorageService|null
     */
    private static ?DBStorageService $instance = null;
    /**
     * @var PDO
     */
    private PDO $pdo;

    /**
     * @return DBStorageService
     */
    public static function getInstance(): DBStorageService
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    /**
     * DBStorageService constructor.
     */
    private function __construct()
    {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];
        $dotenv = Dotenv::createImmutable(__DIR__.'/../../');
        $dotenv->load();
        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=utf8',
            getenv('MYSQL_HOST'),
            getenv('MYSQL_PORT'),
            getenv('MYSQL_DATABASE')
        );
        $this->pdo = new PDO($dsn, 'root', getenv('MYSQL_ROOT_PASSWORD'), $options);
    }

    /**
     * @param string|null $orderBy
     * @param string|null $direction
     * @param int         $offset
     * @param int         $limit
     *
     * @return array
     */
    public function getTasks(?string $orderBy, ?string $direction, int $offset, int $limit): array
    {
        if (!in_array($direction, self::DIRECTIONS)) {
            $direction = self::DEFAULT_DIRECTION;
        }
        if (in_array($orderBy, self::TASKS_COLUMNS)) {
            $sql = sprintf(
                'SELECT * FROM tasks ORDER BY %s %s LIMIT %d, %d',
                $orderBy,
                $direction,
                $offset,
                $limit
            );
        } else {
            $sql = sprintf(
                'SELECT * FROM tasks ORDER BY id %s LIMIT %d, %d',
                $direction,
                $offset,
                $limit
            );
        }
        $stmt = $this->pdo->query($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Task::class);

        return $stmt->fetchAll();
    }

    /**
     * @return int
     */
    public function getTasksCount(): int
    {
        $stmt = $this->pdo->query('SELECT count(*) FROM tasks');

        return (int)$stmt->fetchColumn();
    }

    /**
     * @param string $username
     * @param string $email
     * @param string $text
     *
     * @return bool
     */
    public function createTask(string $username, string $email, string $text): bool
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO tasks(username, email, text, state, edited) 
                        VALUES(:username, :email, :text, :state, :edited)'
        );

        return $stmt->execute([
            'username' => $username,
            'email'    => $email,
            'text'     => $text,
            'state'    => Task::STATE_INCOMPLETE,
            'edited'   => 0,
        ]);
    }

    /**
     * @param int $taskId
     *
     * @return Task|null
     */
    public function getTaskById(int $taskId): ?Task
    {
        $stmt = $this->pdo->prepare('SELECT * FROM tasks WHERE id = :id');
        $stmt->execute(['id' => $taskId]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Task::class);

        return $stmt->fetch();
    }

    /**
     * @param int    $taskId
     * @param int    $state
     * @param string $username
     * @param string $email
     * @param string $text
     *
     * @return bool
     */
    public function editTask(int $taskId, int $state, string $username, string $email, string $text): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE tasks SET username = :username, email = :email, state = :state, text = :text, edited = :edited WHERE id = :id'
        );

        return $stmt->execute([
            'id'       => $taskId,
            'username' => $username,
            'email'    => $email,
            'text'     => $text,
            'state'    => $state,
            'edited'   => true,
        ]);
    }
}
