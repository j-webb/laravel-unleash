<?php

namespace JWebb\Unleash\Contracts\Feature;

use JWebb\Unleash\Contracts\Feature\Resolver\ContextItemResolverContract;

interface FeatureServiceContract
{
    public function __construct(FeatureRepositoryContract $contract);

    public function cacheDatabase(bool $debug = false): void;

    public function filterFeatures(string $projectName = null, bool $debug = false): string;

    public function getFeatures(): string;

    public function setProjectName(string $projectName): void;
}