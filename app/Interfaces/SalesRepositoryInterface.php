<?php

namespace App\Interfaces;

interface SalesRepositoryInterface
{
    public function all();
    public function get($id);
    public function delete($id);
    public function create($data);
}
