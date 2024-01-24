<?php
declare(strict_types=1);

namespace App\Controllers;

use App\RedirectResponse;
use App\Response;
use App\Services\DeleteTaskService;
use App\Services\IndexTaskService;
use App\Services\StoreTaskService;
use App\ViewResponse;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator;

class TaskController
{
    public function index(): Response
    {

        $service = new IndexTaskService();
        if ($service->isEmpty()) {
            $tasks = null;
            return new ViewResponse('tasks/index', [
                'tasks' => $tasks
            ]);
        }
        $tasks = $service->execute();
        return new ViewResponse('tasks/index', [
            'tasks' => $tasks,
        ]);
    }

    public function create(): Response
    {
        return new ViewResponse('tasks/create');
    }

    public function store(): RedirectResponse
    {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $validName = Validator::notEmpty()
            ->not(Validator::space())
            ->setName('Name');
        try {
            $validName->assert($name);
        } catch (NestedValidationException $exception) {
            $this->handleValidationException($exception);
            return new RedirectResponse('/add');
        }

        $validDescription = Validator::notEmpty()
            ->not(Validator::space())
            ->setName('Description');
        try {
            $validDescription->assert($description);
        } catch (NestedValidationException $exception) {
            $this->handleValidationException($exception);
            return new RedirectResponse('/add');
        }

        $service = new StoreTaskService();
        $service->execute($name, $description);
        return new RedirectResponse('/');
    }

    public function delete(): RedirectResponse
    {
        $id = $_POST['delete-task'];
        $service = new DeleteTaskService();
        $service->execute($id);

        return new RedirectResponse('/');
    }

    private function handleValidationException(NestedValidationException $exception): void
    {
        $messages = $exception->getMessages();
        foreach ($messages as $validator => $message) {
            $_SESSION['flush']['error'][] = $message;
        }
    }
}