<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Catalog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    static function index()
    {
        return Catalog::with('subcatalogs')->paginate(50);
    }

    /**
     * Store
     */
    static function store(Request $request): Catalog
    {
        $catalog = new Catalog($request->all());
        $catalog->save();
        return $catalog;
    }

    /**
     * Show
     */
    function showModel(): Catalog
    {
        return $this->with('subcatalogs')
            ->where('id', $this->id)
            ->first();
    }

    /**
     * Update 
     */
    function updateModel(Request $request): Catalog
    {
        $this->update($request->all());
        return $this;
    }

    /**
     * RELATIONSHIPS
     */
    /**
     * Get all of the expenses for the Catalog
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
