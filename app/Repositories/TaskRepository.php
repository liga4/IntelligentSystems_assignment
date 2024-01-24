<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Collections\TaskCollection;
use App\Models\Task;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Dotenv;

class TaskRepository
{
    protected Connection $database;

    public function __construct()
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
        $connectionParams = [
            'dbname' => 'task_manager',
            'user' => 'root',
            'password' => $_ENV['mysql_password'],
            'host' => 'localhost',
            'driver' => 'pdo_mysql'
        ];
        $this->database = DriverManager::getConnection($connectionParams);
    }

    public function getAll(): TaskCollection
    {
        $tasks = $this->database->createQueryBuilder()
            ->select('*')
            ->from('tasks')
            ->fetchAllAssociative();

        $taskCollection = new TaskCollection();

        foreach ($tasks as $data) {
            $taskCollection->add(
                $this->buildModel($data)
            );
        }
        return $taskCollection;
    }

    function isTableEmpty(): bool
    {
        $result = $this->database->createQueryBuilder()
            ->select('COUNT(*) as count')
            ->from('tasks')
            ->execute()
            ->fetchAssociative();

        return intval($result['count']) === 0;
    }

    private function buildModel(array $data): Task
    {
        return new Task(
            $data['task_name'],
            $data['task_description'],
            $data['created_at'],
            $data['id']
        );
    }

    public function save(Task $task): void
    {
        $this->insert($task);
    }

    private function insert(Task $task): void
    {
        $this->database->createQueryBuilder()
            ->insert('tasks')
            ->values(
                [
                    'id' => ':id',
                    'task_name' => ':task_name',
                    'task_description' => ':task_description',
                    'created_at' => ':created_at',
                ]
            )->setParameters([
                'id' => $task->getId(),
                'task_name' => $task->getName(),
                'task_description' => $task->getDescription(),
                'created_at' => $task->getCreatedAt()
            ])->executeQuery();
    }

    public function getById(string $id): ?Task
    {
        $data = $this->database->createQueryBuilder()
            ->select('*')
            ->from('tasks')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->fetchAssociative();
        if (empty($data)) {
            return null;
        }
        return $this->buildModel($data);
    }

    public function delete(Task $task): void
    {
        $this->database->createQueryBuilder()
            ->delete('tasks')
            ->where('id = :id')
            ->setParameter('id', $task->getId())
            ->executeQuery();
    }
}