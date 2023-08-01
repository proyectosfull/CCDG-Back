<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'origin_cost_center_id',
        'destiny_cost_center_id',
        'employee_id',
        'expense_concept_id',
        'transaction_type',
        'amount',
        'date_time',
        'notes',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    static function index()
    {
        return Transaction::with('user', 'origin_cost_center', 'destiny_cost_center', 'employee', 'expense_concept')->paginate(50);
    }

    /**
     * Store
     */
    static function store(Request $request): Transaction
    {
        // hacer lo de sumar y restar de los centros de costos
        $transaction = new Transaction($request->all());
        $transaction->save();
        return $transaction;
    }

    /**
     * Show
     */
    function showModel(): Transaction
    {
        return Transaction::with('user', 'origin_cost_center', 'destiny_cost_center', 'employee', 'expense_concept')
            ->where('id', $this->id)
            ->first();
    }

    /**
     * Update 
     */
    function updateModel(Request $request): Transaction
    {
        $this->update($request->all());
        return $this;
    }

    /**
     * RELATIONSHIPS
     */
    /**
     * Get the user that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the origin_cost_center that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function origin_cost_center(): BelongsTo
    {
        return $this->belongsTo(CostCenter::class);
    }
    /**
     * Get the destiny_cost_center that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function destiny_cost_center(): BelongsTo
    {
        return $this->belongsTo(CostCenter::class);
    }
    /**
     * Get the employee that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
    /**
     * Get the expense_concept that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function expense_concept(): BelongsTo
    {
        return $this->belongsTo(ExpenseConcept::class);
    }
}
