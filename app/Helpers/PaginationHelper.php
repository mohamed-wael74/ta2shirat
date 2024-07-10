<?php

if (! function_exists('pagination_length')) {
    function pagination_length(string $model): int
    {
        $length = match ($model) {
            'test' => 1,
            'user' => 12,
        };

        return $length;
    }
}
