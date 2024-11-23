<?php

namespace App\Abstracts;

abstract class AModel
{
    protected array $fillable = [];

    public function __construct(array $data = [])
    {
        $this->fillable($data);
    }

    public function fillable(array $data): void
    {
        foreach ($this->fillable as $key => $method) 
        {
            if (isset($data[$key])) 
            {
                $this->$method($data[$key]);
            }
        }
    }
}
