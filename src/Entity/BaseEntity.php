<?php

namespace App\Entity;

class BaseEntity implements BaseEntityInterface
{
    public function getId(): int|string|null
    {
        return null;
    }
}
