<?php

namespace JWebb\Unleash\Contracts\Feature;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface FeatureRepositoryContract
{
    public function index();
    public function create();
    public function store(Request $request);
    public function show($id);
    public function edit($id);
    public function update(Model $item, $features);
    public function destroy($id);
}