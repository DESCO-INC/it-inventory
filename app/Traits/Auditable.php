<?php
namespace App\Traits;

use App\Models\AuditTrail;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    protected static function bootAuditable()
    {
        static::created(function ($model) {
            AuditTrail::create([
                'user_id' => Auth::id(),
                'action' => 'created',
                'model' => class_basename($model),
                'model_id' => $model->id,
                'new_values' => $model->toArray(),
            ]);
        });

        static::updated(function ($model) {
            AuditTrail::create([
                'user_id' => Auth::id(),
                'action' => 'updated',
                'model' => class_basename($model),
                'model_id' => $model->id,
                'old_values' => $model->getOriginal(),
                'new_values' => $model->getChanges(),
            ]);
        });

        static::deleted(function ($model) {
            AuditTrail::create([
                'user_id' => Auth::id(),
                'action' => 'deleted',
                'model' => class_basename($model),
                'model_id' => $model->id,
                'old_values' => $model->toArray(),
            ]);
        });
    }
}