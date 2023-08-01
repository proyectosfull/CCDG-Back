<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class LandPayroll extends Model
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
        return LandPayroll::paginate(50);
    }

    /**
     * Store
     */
    static function store(Request $request): LandPayroll
    {
        $land_payroll = new LandPayroll($request->all());
        $land_payroll->save();
        return $land_payroll;
    }

    /**
     * Show
     */
    function showModel(): LandPayroll
    {
        return LandPayroll::where('id', $this->id)
            ->first();
    }

    /**
     * Update 
     */
    function updateModel(Request $request): LandPayroll
    {
        $this->update($request->all());
        return $this;
    }

    /**
     * RELATIONSHIPS
     */
}
