<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

trait HasSort
{
    public function scopeApplySorts(Builder $Query, $sort)
    {
        if (is_null($sort)) {
            $sort = 'price';
        }
        $sortFields = Str::of($sort)->explode(',');

        foreach ($sortFields as $sortField) {
            $direction = 'asc';
            if (Str::of($sortField)->startsWith('-')) {
                $direction = 'desc';
                $sortField = Str::of($sortField)->substr(1);
            }

            if (!collect($this->allowedSorts)->contains($sortField)) {
                abort(400);
            }

            $Query->orderBy($sortField, $direction);
        }
    }
}
