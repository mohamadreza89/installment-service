<?php


namespace App\Services\Lib;


use Illuminate\Database\Eloquent\Builder;

abstract class Creator
{
    /**
     * @var Builder
     */
    protected $builder;

    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }
}
