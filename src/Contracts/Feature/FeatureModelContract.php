<?php

namespace JWebb\Unleash\Contracts\Feature;

interface FeatureModelContract
{
    public function getStringIdentifier(): ?string;
}