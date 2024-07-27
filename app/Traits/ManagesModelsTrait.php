<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ManagesModelsTrait
{
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

    // public function forceDeleteModel(string $modelClass, string $id){
    //     $this->authorize('manage_users');
    //     $modelInstance = $modelClass::withTrashed()->where('id', $id)->first();
    //     if (!$modelInstance) {
    //         return response()->json([
    //             'message' => class_basename($modelClass) . " not found."
    //         ], 404);
    //     }

    //     $modelInstance->forceDelete();
    //     return response()->json([
    //         'message' => "Force Delete " . class_basename($modelClass) . " By Id Successfully."
    //     ]);
    // }

    public function forceDeleteModel(string $modelClass, string $id)
{
    $this->authorize('manage_users');

    $modelInstance = $modelClass::withTrashed()->where('id', $id)->first();

    if (!$modelInstance) {
        return response()->json([
            'message' => class_basename($modelClass) . " not found."
        ], 404);
    }

    // Check if there are related records that might prevent deletion
    if ($modelInstance->news()->withTrashed()->exists()) {
        return response()->json([
            'message' => 'Cannot force delete ' . class_basename($modelClass) . ' because related news records exist.'
        ], 400);
    }

    // Add debugging information
    try {
        $modelInstance->forceDelete();
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error: ' . $e->getMessage(),
        ], 500);
    }

    return response()->json([
        'message' => "Force Delete " . class_basename($modelClass) . " By Id Successfully."
    ]);
}

}
