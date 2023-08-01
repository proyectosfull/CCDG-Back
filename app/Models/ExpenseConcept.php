<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class ExpenseConcept extends Model
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
        return ExpenseConcept::paginate(50);
    }

    /**
     * Store
     */
    static function store(Request $request): ExpenseConcept
    {
        $expense_concept = new ExpenseConcept($request->all());
        $expense_concept->save();
        return $expense_concept;
    }

    /**
     * Show
     */
    function showModel(): ExpenseConcept
    {
        return ExpenseConcept::where('id', $this->id)
            ->first();
    }

    /**
     * Update 
     */
    function updateModel(Request $request): ExpenseConcept
    {
        $this->update($request->all());
        return $this;
    }

    /**
     * RELATIONSHIPS
     */

    /**
     * Get all of the concept_expense_by_users for the ExpenseConcept
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function concept_expense_by_users(): HasMany
    {
        return $this->hasMany(ConceptExpenseByUser::class);
    }
    /**
     * Get all of the transactions for the ExpenseConcept
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
    /**
     * Get all of the cost_center_expense_concept for the ExpenseConcept
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cost_center_expense_concept(): HasMany
    {
        return $this->hasMany(CostCenterExpenseConcept::class);
    }
}
