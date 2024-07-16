<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ManagesModelsTrait
{
    protected $model;
    protected $resource;
    protected $policy;
    protected $request;

    public function create(Request $request)
    {
        $this->authorize($this->policy);

        // Validate incoming request using RoleRequest
        $validatedData = $request->validate($this->request::rules());

        // Create new model instance with validated data
        $model = $this->model::create($validatedData);
        $model->save();

        return response()->json([
            'data' => new $this->resource($model),
            'message' => class_basename($this->model) . " Created Successfully."
        ]);
    }

    public function edit(Request $request, string $id)
    {
        $this->authorize($this->policy);
        $model = $this->model::find($id);

        if (!$model) {
            return response()->json([
                'message' => class_basename($this->model) . " not found."
            ], 404);
        }

        // Validate and update the model instance
        $validatedData = $request->validate($this->request::rules());

        $model->fill($validatedData);
        $model->save();

        return response()->json([
            'data' => new $this->resource($model),
            'message' => class_basename($this->model) . " Updated Successfully."
        ]);
    }

    public function update(Request $request, string $id)
    {
        $this->authorize($this->policy);
        $model = $this->model::findOrFail($id);

        if (!$model) {
            return response()->json([
                'message' => class_basename($this->model) . " not found."
            ], 404);
        }

        // Validate and update the model instance
        $validatedData = $request->validate($this->request::rules());

        $model->fill($validatedData);
        $model->save();

        return response()->json([
            'data' => new $this->resource($model),
            'message' => class_basename($this->model) . " Updated Successfully."
        ]);
    }

    public function destroyModel(string $id)
    {
        $this->authorize($this->policy);
        $model = $this->model::find($id);

        if (!$model) {
            return response()->json([
                'message' => class_basename($this->model) . " not found."
            ], 404);
        }

        $model->delete();

        return response()->json([
            'data' => new $this->resource($model),
            'message' => "Soft Delete " . class_basename($this->model) . " By Id Successfully."
        ]);
    }

    public function restoreModel(string $id)
    {
        $this->authorize($this->policy);
        $model = $this->model::withTrashed()->find($id);

        if (!$model) {
            return response()->json([
                'message' => class_basename($this->model) . " not found."
            ], 404);
        }

        $model->restore();

        return response()->json([
            'message' => "Restore " . class_basename($this->model) . " By Id Successfully."
        ]);
    }

    public function forceDeleteModel(string $id)
    {
        $this->authorize($this->policy);
        $model = $this->model::withTrashed()->find($id);

        if (!$model) {
            return response()->json([
                'message' => class_basename($this->model) . " not found."
            ], 404);
        }

        $model->forceDelete();

        return response()->json([
            'message' => "Force Delete " . class_basename($this->model) . " By Id Successfully."
        ]);
    }

    public function showDeletedModels()
    {
        $this->authorize($this->policy);
        $models = $this->model::onlyTrashed()->get();

        return response()->json([
            'data' => $this->resource::collection($models),
            'message' => "Show Deleted " . class_basename($this->model) . " Successfully."
        ]);
    }
}
