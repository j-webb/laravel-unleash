<?php

namespace JWebb\Unleash\Interfaces\Api;

interface Feature
{
    /**
     * {@inheritdoc}
     */
    public function all();

    /**
     * {@inheritdoc}
     */
    public function getEnabled();

    /**
     * {@inheritdoc}
     */
    public function getActive();

    /**
     * {@inheritdoc}
     */
    public function isEnabled(string $name);

    /**
     * {@inheritdoc}
     */
    public function isActive(string $name, bool $enabledOnly = true);
}
