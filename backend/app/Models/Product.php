<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasUuids;
    public $incrementing = false;
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'product_parent_id',
        'product_name',
        'product_type',
    ];

    public function parent()
    {
        return $this->belongsTo(Product::class, 'product_parent_id');
    }

    public function children()
    {
        return $this->hasMany(Product::class, 'product_parent_id');
    }
}
