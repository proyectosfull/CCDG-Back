<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'full_name',
        'phone_number',
        'email',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    static function index()
    {
        return Employee::paginate(50);
    }

    /**
     * Store
     */
    static function store(Request $request): Employee
    {
        $employee = new Employee($request->all());
        $employee->save();
        return $employee;
    }

    /**
     * Show
     */
    function showModel(): Employee
    {
        return Employee::where('id', $this->id)
            ->first();
    }

    /**
     * Update 
     */
    function updateModel(Request $request): Employee
    {
        $this->update($request->all());
        return $this;
    }

    /**
     * RELATIONSHIPS
     */
    /**
     * Get all of the transactions for the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
