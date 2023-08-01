<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Area extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    static function index()
    {
        return Area::paginate(50);
    }

    /**
     * Store
     */
    static function store(Request $request): Area
    {
        $area = new Area($request->all());
        $area->save();
        return $area;
    }

    /**
     * Show
     */
    function showModel(): Area
    {
        return Area::where('id', $this->id)
            ->first();
    }

    /**
     * Update 
     */
    function updateModel(Request $request): Area
    {
        $this->update($request->all());
        return $this;
    }

    /**
     * RELATIONSHIPS
     */
    /**
     * Get all of the employee_records for the Area
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employee_records(): HasMany
    {
        return $this->hasMany(EmployeeRecord::class);
    }
}
