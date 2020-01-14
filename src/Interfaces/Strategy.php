<?php

namespace JWebb\Unleash\Interfaces;

interface Strategy
{
    /**
     * {@inheritdoc}
     */
    public function isEnabled(array $params): bool;
}
