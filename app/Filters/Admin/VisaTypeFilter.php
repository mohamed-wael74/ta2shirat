<?php

namespace App\Filters\Admin;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class VisaTypeFilter extends QueryFilter
{
    public function search($keyword = ''): Builder
    {
        return $this->builder->search(['name'], $keyword);
    }

    public function sort($sort = 'asc'): Builder
    {
        return in_array(strtolower($sort), ['asc', 'desc']) ? $this->builder->orderBy('created_at', $sort) : $this->builder;
    }
}
