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
    static function store(Request $request, string $title): Transaction
    {
        $transaction = new Transaction($request->all());
        if ($transaction->transaction_type == 'Efectivo') {
            CostCenter::adjustBudget($transaction->origin_cost_center_id, $transaction->destiny_cost_center_id, $transaction->amount, $title);
        } else {
            //pendiente que hacer con activos o donde se guardan
        }
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
    function updateModel(Request $request, string $title): Transaction
    {
        $new_transaction = false;
        if ($request->has('origin_cost_center_id') || $request->has('destiny_cost_center_id') || $request->has('amount')) {
            // si se cambio el centro de costos o el monto se tiene que hacer un rollback de la accion en el store
            CostCenter::adjustBudget($this->destiny_cost_center_id, $this->origin_cost_center_id, $this->amount, $title);
            $new_transaction = true;
        }
        //valida si existe
        if ($request->has('user_id')) {
            $this->user_id = $request->user_id;
        }
        if ($request->has('origin_cost_center_id')) {
            $this->origin_cost_center_id = $request->origin_cost_center_id;
        }
        if ($request->has('destiny_cost_center_id')) {
            $this->destiny_cost_center_id = $request->destiny_cost_center_id;
        }
        if ($request->has('employee_id')) {
            $this->employee_id = $request->employee_id;
        }
        if ($request->has('expense_concept_id')) {
            $this->expense_concept_id = $request->expense_concept_id;
        }
        if ($request->has('amount')) {
            $this->amount = $request->amount;
        }
        if ($request->has('transaction_type')) {
            $this->transaction_type = $request->transaction_type;
        }
        if ($request->has('date_time')) {
            $this->date_time = $request->date_time;
        }
        if ($request->has('notes')) {
            $this->notes = $request->notes;
        }
        if ($new_transaction && $this->transaction_type == 'Efectivo') {
            CostCenter::adjustBudget($this->origin_cost_center_id, $this->destiny_cost_center_id, $this->amount, $title);
        } else {
            //pendiente que hacer con activos o donde se guardan
        }
        $this->save();
        return $this;
    }

    /** Delete */
    function deleteModel(string $title): void
    {
        //hacemos rollback de los presupuestos reasignados.
        CostCenter::adjustBudget($this->destiny_cost_center_id, $this->origin_cost_center_id, $this->amount, $title);
        $this->delete();
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
