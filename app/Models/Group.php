<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    protected $fillable = [
        'name',
        'creator', // o 'created_by', según tu base de datos
        'description',
        // agrega aquí cualquier otro campo que vayas a guardar al crear
    ];
      public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator');
    }
     public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'groups_users')
                    ->withPivot('role')
                    ->withTimestamps();
    }
     public function groupUsers(): HasMany
    {
        return $this->hasMany(GroupUser::class);
    }
    public function trainingDays()
    {
        return $this->hasMany(TrainingDay::class);
    }
}
