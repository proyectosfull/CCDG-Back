<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class SubCatalog extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'subcatalogs';

    protected $fillable = ['name', 'description', 'catalog_id'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /** Index */
    static function index()
    {
        return SubCatalog::with('catalog')->paginate(50);
    }

    /**
     * Store
     */
    static function store(Request $request): SubCatalog
    {
        $subcatalog = new SubCatalog($request->all());
        $subcatalog->save();
        return $subcatalog;
    }

    /**
     * Show
     */
    function showModel(): SubCatalog
    {
        return $this->with('catalog')
            ->where('id', $this->id)
            ->first();
    }

    /**
     * Update 
     */
    function updateModel(Request $request): SubCatalog
    {
        $this->update($request->all());
        return $this;
    }

    /**
     * RELATIONSHIPS
     */
    /**
     * Get the catalog that owns the SubCatalog
     */
    public function catalog()
    {
        return $this->belongsTo(Catalog::class);
    }

    /**
     * Get all of the subcatalogs for the Catalog
     */
    public function subcatalogs()
    {
        return $this->hasMany(SubCatalog::class);
    }

    /**
     * Get all of the expenses for the subcost_center(subcatalog)
     */
    public function subcost_center_expenses()
    {
        return $this->hasMany(Expense::class, 'subcost_center_id', 'id');
    }

    /**
     * Get all of the expenses for the SubCatalog
     */
    public function subcatalog_expenses()
    {
        return $this->hasMany(Expense::class, 'subcatalog_id', 'id');
    }
}
