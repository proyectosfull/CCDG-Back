<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class SubcostCenter extends Model
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
        return SubcostCenter::paginate(50);
    }

    /**
     * Store
     */
    static function store(Request $request): SubcostCenter
    {
        $subcost_center = new SubcostCenter($request->all());
        $subcost_center->save();
        return $subcost_center;
    }

    /**
     * Show
     */
    function showModel(): SubcostCenter
    {
        return SubcostCenter::where('id', $this->id)
            ->first();
    }

    /**
     * Update 
     */
    function updateModel(Request $request): SubcostCenter
    {
        $this->update($request->all());
        return $this;
    }

    /**
     * RELATIONSHIPS
     */

    /**
     * Get all of the employee_records for the SubcostCenter
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employee_records(): HasMany
    {
        return $this->hasMany(EmployeeRecord::class);
    }
}
