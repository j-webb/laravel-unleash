<?php


namespace JWebb\Unleash\Repositories\Feature;

use JWebb\Unleash\Contracts\Feature\FeatureRepositoryContract;
use JWebb\Unleash\Models\Feature\Feature;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class FeatureRepository implements FeatureRepositoryContract
{
    public function index()
    {

    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
    }

    public function update(Model $item, $features)
    {
        // Store features in database
        Feature::updateOrCreate([
            'CONTEXT_ID' => $item->getKey(),
            'CONTEXT_TABLE' => $item->getTable(),
        ], [
            'CONTEXT_ID' => $item->getKey(),
            'CONTEXT_TABLE' => $item->getTable(),
            'JSON_VALUE' => $features,
        ]);
    }

    public function destroy($id)
    {
    }
}
