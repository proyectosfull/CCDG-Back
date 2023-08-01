<?php

namespace App\Models;

use App\Custom\ErrorRequest;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CostCenter extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'budget',
    ];

    protected $cast = [
        'budget' => 'decimal:2',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    static function index()
    {
        return CostCenter::paginate(50);
    }

    /**
     * Store
     */
    static function store(Request $request): CostCenter
    {
        $cost_center = new CostCenter($request->all());
        $cost_center->save();
        return $cost_center;
    }

    /**
     * Show
     */
    function showModel(): CostCenter
    {
        return CostCenter::where('id', $this->id)
            ->first();
    }

    /**
     * Update 
     */
    function updateModel(Request $request): CostCenter
    {
        $this->update($request->all());
        return $this;
    }

    /**
     * Queries / Methods
     */

    /**
     * En base al id, retornamos el nombre del centro, esto para comparar con los permisos de cada rol
     */
    public static function getNameById(int $cost_center_id): string
    {
        return CostCenter::find($cost_center_id)->name;
    }

    /**
     * Esta funcion recibe el centro de costos de origen y destino y el monto que sera trasladado
     * @param origin_cost_center_id
     * @param destiny_cost_center_id
     * @param amount
     * @return void for successful or abort if something wrong
     */
    public static function adjustBudget($origin_id, $destiny_id, $amount, $title): void
    {
        if ($origin_id == $destiny_id) {
            ErrorRequest::genericErrors(['Los centros de costos tienen que ser diferentes.'], $title);
        }
        $origin_cost_center = CostCenter::find($origin_id);
        $destiny_cost_center = CostCenter::find($destiny_id);
        $final_budget = $origin_cost_center->budget - $amount;
        if( $final_budget < 0){
            ErrorRequest::genericErrors(['El centro de costo de origen no tiene suficientes fondos para cumplir el movimiento.'], $title);
        }
        try {
            DB::beginTransaction();
            $origin_cost_center->update(['budget' => $final_budget]);
            $destiny_cost_center->update(['budget' => $destiny_cost_center->budget + $amount]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            ErrorRequest::genericErrors(['Error en ajustar el presupuesto '.$e->getMessage()], $title);
        }
    }

    /**
     * RELATIONSHIPS
     */
    /**
     * Get all of the account_statuses for the CostCenter
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function account_statuses(): HasMany
    {
        return $this->hasMany(CostCenter::class);
    }
    /**
     * Get all of the expense_concepts for the CostCenter
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expense_concepts(): HasMany
    {
        return $this->hasMany(ExpenseConcept::class);
    }
    /**
     * Get all of the transactions for the CostCenter
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function origin_transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'origin_cost_center_id');
    }
    /**
     * Get all of the transactions for the CostCenter
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function destiny_transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'destiny_cost_center_id');
    }

    /**
     * Get all of the cost_center_expense_concept for the CostCenter
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cost_center_expense_concept(): HasMany
    {
        return $this->hasMany(CostCenterExpenseConcept::class);
    }
}
