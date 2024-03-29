<?php

namespace App\Models;

use Illuminate\Http\Request;
// use Illuminate\Database\Eloquent\Builder;

abstract class QueryFilter {

    protected $builder;

    protected $request;

    public function __construct(Request $request) {

        $this->request = $request;

    }

    public function apply($builder) {

        $this->builder = $builder;

        foreach ($this->filters() as $filter => $value) {

            if (method_exists($this, $filter)) {

                $this->$filter($value);

            }

        }

        return $this->builder;

    }


    public function filters(): array
    {

        return $this->request->all();

    }

}
