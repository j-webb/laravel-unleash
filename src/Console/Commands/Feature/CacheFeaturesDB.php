<?php

namespace JWebb\Unleash\Console\Commands\Feature;

use JWebb\Unleash\Contracts\Feature\FeatureServiceContract;
use Illuminate\Console\Command;

class CacheFeaturesDB extends Command
{
    protected $signature = 'cache:features-d-b ';

    protected $description = 'Will cache all features from Unleash to the database';

    public function handle()
    {
        $service = app()->make(FeatureServiceContract::class);
        $service->setProjectName(config('unleash.project_name'));
        $service->setContextItemRepository(app()->make(config('unleash.context_item_repository')));
        $service->setContextItemResolver(app()->make(config('unleash.context_item_resolver')));
        $service->cacheDatabase();
    }
}
