<?php
declare(strict_types=1);

namespace App\Services;

use App\Collections\TaskCollection;
use App\Repositories\TaskRepository;

class IndexTaskService
{
    private TaskRepository $repository;

    public function __construct()
    {
        $this->repository = new TaskRepository();
    }

    public function execute(): TaskCollection
    {
        return $this->repository->getAll();
    }

    public function isEmpty(): bool
    {
        return $this->repository->isTableEmpty();
    }
}