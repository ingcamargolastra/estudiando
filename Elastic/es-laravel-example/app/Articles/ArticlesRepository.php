<?php

namespace App\Articles;

use Illuminate\Database\Eloquent\Collection;

interface ArticlesRepository
{

    public function index();

    public function search(string $query = ''): Collection;

    public function save($array);

    public function update($array, $id);
}