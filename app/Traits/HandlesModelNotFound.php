<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;

trait HandlesModelNotFound
{
    /**
     * Handle a model not found exception and return a custom response.
     *
     * @param string $modelName
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleModelNotFound($modelName)
    {
        return response()->json([
            'message' => $modelName . ' not found',
        ], 404);
    }

    /**
     * Find a model by ID or return a custom response if not found.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param int|string $id
     * @param string $modelName
     * @return mixed
     */
    public function findModelOrFail($model, $id, $modelName)
    {
        try {
            return $model::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->handleModelNotFound($modelName);
        }
    }
}
