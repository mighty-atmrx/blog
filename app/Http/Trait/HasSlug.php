<?php

declare(strict_types=1);

namespace App\Http\Trait;

use Illuminate\Support\Str;

trait HasSlug
{
    public function resolveRouteBindingQuery($query, $value, $field = null)
    {
        $id = explode( '-', $value)[0];
        return $query->where($field ?? $this->getRouteKeyName(), $id);
    }

    public function getRouteKeyName(): string
    {
        return Str::slug($this->title . '-' . $this->id);
    }
}
