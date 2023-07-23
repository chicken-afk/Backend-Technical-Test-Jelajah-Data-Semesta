<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SlugGenerator
{
    protected $id = 1;
    protected $table;
    protected $column;
    protected $slug;

    public function __construct($table, $column = 'slug', $string)
    {
        $this->table = $table;
        $this->column = $column;
        $this->slug = Str::slug($string);
    }

    public function getSlug()
    {
        if (
            DB::table($this->table)
            ->where($this->column, $this->slug)
            ->count() != 0
        ) {
            $this->slug = $this->slug . "-" . $this->id;
            $this->id++;
            $this->getSlug();
        }
        return $this->slug;
    }
}
