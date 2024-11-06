<?php

namespace JWebb\Unleash\Contracts\Feature\Resolver;

interface ContextItemResolverContract
{
    public static function setContextItemId(?int $id);

    public static function resolve();
}