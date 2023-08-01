<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class CostCenterExpenseConcept extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cost_center_expense_concept';

    protected $fillable = [
        'cost_center_id',
        'expense_concept_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    static function index()
    {
        return CostCenterExpenseConcept::with('cost_center', 'expense_concept')->paginate(50);
    }

    /**
     * Store
     */
    static function store(Request $request): CostCenterExpenseConcept
    {
        $cost_center_expense_concept = new CostCenterExpenseConcept($request->all());
        $cost_center_expense_concept->save();
        return $cost_center_expense_concept;
    }

    /**
     * Show
     */
    function showModel(): CostCenterExpenseConcept
    {
        return CostCenterExpenseConcept::with('cost_center', 'expense_concept')
            ->where('id', $this->id)
            ->first();
    }

    /**
     * Update 
     */
    function updateModel(Request $request): CostCenterExpenseConcept
    {
        $this->update($request->all());
        return $this;
    }

    /**
     * RELATIONSHIPS
     */
    /**
     * Get the cost_center that owns the CostCenterExpenseConcept
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cost_center(): BelongsTo
    {
        return $this->belongsTo(CostCenter::class);
    }
    /**
     * Get the expense_concept that owns the CostCenterExpenseConcept
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function expense_concept(): BelongsTo
    {
        return $this->belongsTo(ExpenseConcept::class);
    }
}
