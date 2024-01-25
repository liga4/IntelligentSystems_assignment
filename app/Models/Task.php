<?php
declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;

class Task
{
    private string $name;
    private string $description;
    private Carbon $createdAt;
    private ?string $id;

    public function __construct(
        string  $name,
        string  $description,
        ?string $createdAt = null,
        ?string $id = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->createdAt = $createdAt == null ? Carbon::now()->setTimezone('Europe/Riga') : new Carbon($createdAt);
        $this->description = $description;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    public function getId(): ?string
    {
        return $this->id;
    }
}