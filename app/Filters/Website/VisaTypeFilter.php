<?php

namespace App\Filters\Website;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class VisaTypeFilter extends QueryFilter
{
    public function search($keyword = ''): Builder
    {
        return $this->builder->search(['name'], $keyword);
    }
}
