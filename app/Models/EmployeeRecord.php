<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class EmployeeRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'full_name',
        'monthly_salary',
        'area_id',
        'subcost_center_id',
    ];

    protected $cast = [
        'monthly_salary' => 'decimal:2',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    static function index()
    {
        return EmployeeRecord::with('area', 'subcost_center')->paginate(50);
    }

    /**
     * Store
     */
    static function store(Request $request): EmployeeRecord
    {
        $employee_record = new EmployeeRecord($request->all());
        $employee_record->save();
        return $employee_record;
    }

    /**
     * Show
     */
    function showModel(): EmployeeRecord
    {
        return EmployeeRecord::with('area', 'subcost_center')
            ->where('id', $this->id)
            ->first();
    }

    /**
     * Update 
     */
    function updateModel(Request $request): EmployeeRecord
    {
        $this->update($request->all());
        return $this;
    }

    /**
     * RELATIONSHIPS
     */
    /**
     * Get the area that owns the EmployeeRecord
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }
    /**
     * Get the subcenter_cost that owns the EmployeeRecord
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subcost_center(): BelongsTo
    {
        return $this->belongsTo(SubcostCenter::class);
    }
}
