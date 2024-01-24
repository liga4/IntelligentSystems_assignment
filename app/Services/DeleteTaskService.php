<?php
declare(strict_types=1);

namespace App\Services;


use App\Repositories\TaskRepository;

class DeleteTaskService
{
    private TaskRepository $repository;

    public function __construct()
    {
        $this->repository = new TaskRepository();
    }

    public function execute(string $id): void
    {
        $task = $this->repository->getById($id);
        $this->repository->delete($task);
    }
}