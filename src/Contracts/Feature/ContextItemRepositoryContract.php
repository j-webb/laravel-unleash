<?php

namespace JWebb\Unleash\Contracts\Feature;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface ContextItemRepositoryContract
{
    public function getAllContextItems(): Collection;

    public function getContextItemModel(): Model;

}