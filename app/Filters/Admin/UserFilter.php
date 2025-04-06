<?php

namespace App\Filters\Admin;

use App\Filters\QueryFilter;
use App\Models\Country;
use Illuminate\Database\Eloquent\Builder;

class UserFilter extends QueryFilter
{
    public function emailVerified($state = true): Builder
    {
        return $this->builder->emailVerified($state);
    }

    public function phoneVerified($state = true): Builder
    {
        return $this->builder->phoneVerified($state);
    }

    public function verified($state = true): Builder
    {
        return $this->builder->emailVerified($state)->phoneVerified($state);
    }

    public function blocked($state = true): Builder
    {
        return $this->builder->isBlocked($state);
    }

    public function country($country = ''): Builder
    {
        return $this->builder->byCountry($country);
    }

    public function deleted($state = true): Builder
    {
        return $state ? $this->builder->onlyTrashed() : $this->builder;
    }

    public function withDeleted($state = true): Builder
    {
        return $state ? $this->builder->withTrashed() : $this->builder;
    }

    public function order($order = 'asc'): Builder
    {
        return $this->builder->orderBy('created_at', $order);
    }

    public function search($keyword = ''): Builder
    {
        return $this->builder->search([
            'first_name',
            'middle_name',
            'last_name',
            'username',
            'email'
        ], $keyword);
    }
}
