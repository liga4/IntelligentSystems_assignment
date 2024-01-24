<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Task;
use App\Repositories\TaskRepository;

class StoreTaskService
{
    private TaskRepository $repository;

    public function __construct()
    {
        $this->repository = new TaskRepository();
    }

    public function execute(string $name, string $description): void
    {
        $product = new Task($name, $description);
        $this->repository->save($product);
    }
}