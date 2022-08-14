<?php

namespace App\Filters;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class Filters
{
    protected Builder $builder;

    protected array $filters = [];

    public function __construct(protected Request $request)
    {
        //
    }

    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    protected function getFilters(): array
    {
        return $this->request
            ->collect()
            ->only($this->filters)
            ->filter()
            ->toArray();
    }
}
