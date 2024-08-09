<?php

declare(strict_types=1);

namespace App\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class HasMediaFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        if ($value == 1) {
            return $query->whereHas('media');
        }

        return $query;
    }
}
