<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
    protected array $filters = [];
    protected Request $request;
    protected $builder;

    /**
     * ThreadFilters constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $builder
     * @return Request
     */
    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    private function filters()
    {
        return $this->request->only($this->filters);
    }
}
