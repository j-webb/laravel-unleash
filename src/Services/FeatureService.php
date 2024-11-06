<?php

namespace JWebb\Unleash\Services;

use JWebb\Unleash\Contracts\Feature\ContextItemRepositoryContract;
use JWebb\Unleash\Contracts\Feature\FeatureRepositoryContract;
use JWebb\Unleash\Contracts\Feature\FeatureServiceContract;
use JWebb\Unleash\Contracts\Feature\Resolver\ContextItemResolverContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use JWebb\Unleash\Facades\Unleash;

class FeatureService implements FeatureServiceContract
{
    private FeatureRepositoryContract $repository;
    private string $projectName = '';

    public function __construct(FeatureRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function getFeatures(): string
    {
        $toggles = collect(Unleash::getFeatures()['toggles']);

        $toggles = $toggles->filter(function ($toggle) {
            return Str::startsWith($toggle['name'], $this->projectName);
        })->toArray();

        return json_encode(['toggles' => $toggles]);
    }

    public function cacheDatabase(bool $debug = false): void
    {
        foreach (config('unleash.context_items') as $contextItem) {
            if (!isset($contextItem['repository']) || !isset($contextItem['resolver'])){
                throw new \Exception('Context item should have \'repository\' and \'resolver\' keys.');
            }

            $contextRepository = app()->make($contextItem['repository']);
            $contextResolver = app()->make($contextItem['resolver']);

            $contextRepository->getAllContextItems()->each(function (Model $item) use ($contextRepository, $contextResolver) {
                // Set current partnerId for feature context
                $contextResolver::setContextItemId($item->getKey());

                // Get features from unleash
                $features = $this->getFeatures();

                $this->repository->update($item, $features);

                // Check if model has getStringIdentifier method
                if (!method_exists($item, 'getStringIdentifier'))
                    throw new \Exception('Model ' . get_class($item) . ' should implement getStringIdentifier method.');

                // Log
                Log::info("Features for contextItem {$item->getStringIdentifier()} cached.");
            });
        }
    }

    /**
     * @param string|null $projectName
     * @param bool $debug false
     *
     * @return string
     */
    public function filterFeatures(string $projectName = null, bool $debug = false): string
    {
        $features = Unleash::getFeatures();
        if (isset($projectName)) {
            $filteredToggles = array_filter($features['toggles'], function ($toggle) use ($projectName) {
                return strpos($toggle['name'], $projectName) === 0;
            });
            $features = ['toggles' => $filteredToggles];
        }

        if ($debug)
            dump($features);

        return json_encode($features);
    }

    public function getProjectName(): string
    {
        return $this->projectName;
    }

    public function setProjectName(string $projectName): void
    {
        $this->projectName = $projectName;
    }
}
