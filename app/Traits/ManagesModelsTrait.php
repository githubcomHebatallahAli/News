<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ManagesModelsTrait
{

    // public function showAll(string $modelClass, string $resourceClass)
    // {
    //     $this->authorize('manage_users');

    //     $models = $modelClass::get();
    //     return response()->json([
    //         'data' => $resourceClass::collection($models),
    //         'message' => "Show All " . class_basename($modelClass) . "s Successfully."
    //     ]);
    // }

    public function create(Request $request, string $modelClass, string $resourceClass)
    {
        // Optionally authorize here if needed
        $this->authorize('manage_users');

        $model = $modelClass::create($request->all());
        return response()->json([
            'data' => new $resourceClass($model),
            'message' => class_basename($modelClass) . " Created Successfully."
        ]);
    }

    public function edit(string $modelClass, string $resourceClass, string $id)
    {
        $this->authorize('manage_users');
        $model = $modelClass::find($id);

        if (!$model) {
            return response()->json([
                'message' => class_basename($modelClass) . " not found."
            ], 404);
        }

        return response()->json([
            'data' => new $resourceClass($model),
            'message' => "Edit " . class_basename($modelClass) . " By ID Successfully."
        ]);
    }

    public function update(Request $request, string $modelClass, string $resourceClass, string $id)
    {
        $this->authorize('manage_users');
        $model = $modelClass::findOrFail($id);

        if (!$model) {
            return response()->json([
                'message' => class_basename($modelClass) . " not found."
            ], 404);
        }

        $model->update($request->all());
        return response()->json([
            'data' => new $resourceClass($model),
            'message' => " Update " . class_basename($modelClass) . " By Id Successfully."
        ]);
    }
    public function destroyModel(string $modelClass, string $resourceClass, string $id){
        $this->authorize('manage_users');
        $modelInstance = $modelClass::find($id);
        if (!$modelInstance) {
            return response()->json([
                'message' => class_basename($modelClass) . " not found."
            ], 404);
        }

        $modelInstance->delete();
        return response()->json([
            'data' => new $resourceClass($modelInstance),
            'message' => "Soft Delete " . class_basename($modelClass) . " By Id Successfully."
        ]);
    }

    public function showDeletedModels(string $modelClass, string $resourceClass){
        $this->authorize('manage_users');
        $models = $modelClass::onlyTrashed()->get();
        return response()->json([
            'data' => $resourceClass::collection($models),
            'message' => "Show Deleted " . class_basename($modelClass) . " Successfully."
        ]);
    }

    public function restoreModel(string $modelClass, string $id){
        $this->authorize('manage_users');
        $modelInstance = $modelClass::withTrashed()->where('id', $id)->first();
        if (!$modelInstance) {
            return response()->json([
                'message' => class_basename($modelClass) . " not found."
            ], 404);
        }

        $modelInstance->restore();
        return response()->json([
            'message' => "Restore " . class_basename($modelClass) . " By Id Successfully."
        ]);
    }

    public function forceDeleteModel(string $modelClass, string $id){
        $this->authorize('manage_users');
        $modelInstance = $modelClass::withTrashed()->where('id', $id)->first();
        if (!$modelInstance) {
            return response()->json([
                'message' => class_basename($modelClass) . " not found."
            ], 404);
        }

        $modelInstance->forceDelete();
        return response()->json([
            'message' => "Force Delete " . class_basename($modelClass) . " By Id Successfully."
        ]);
    }
}
