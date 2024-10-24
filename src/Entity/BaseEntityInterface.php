<?php

namespace App\Entity;

use Ramsey\Uuid\UuidInterface;

interface BaseEntityInterface
{
    public function getId(): string|null|UuidInterface;
}
