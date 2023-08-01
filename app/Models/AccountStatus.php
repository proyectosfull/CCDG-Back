<?php

namespace App\Models;

use App\Custom\ErrorRequest;
use App\Http\Controllers\AuthController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class AccountStatus extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cost_center_id',
        'current_stock',
        'concept_asset_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Extraemos el rol del usuario logeado, comparamos con la tabla de centro de costos para que solamente muestre
     * sus gastos pertenecientes.
     */
    static function index(Request $request, string $title)
    {
        $role = AuthController::getRoleName($request, $title);
        $baseQuery = (new AccountStatus)->newQuery();
        $baseQuery->join('cost_centers', 'cost_centers.id', '=', 'account_statuses.cost_center_id');
        if ($role != 'Administración') {
            $baseQuery->where('cost_centers.name', $role);
        }
        return $baseQuery->with('cost_center', 'concept_asset')->paginate(50);
    }

    /**
     * Store
     */
    static function store(Request $request, string $title): AccountStatus
    {
        $account_status = new AccountStatus($request->all());
        //validacion de permisos.
        ErrorRequest::assertPermission($request->user(), $account_status->cost_center->name, $title);
        $account_status->save();
        //ocultamos la relacion
        unset($account_status['cost_center']);
        return $account_status;
    }

    /**
     * Show
     */
    function showModel(Request $request, $title): ?AccountStatus
    {
        ErrorRequest::assertPermission($request->user(), $this->cost_center->name, $title);
        $role = AuthController::getRoleName($request, $title);
        $baseQuery = (new AccountStatus)->newQuery();
        $baseQuery->join('cost_centers', 'cost_centers.id', '=', 'account_statuses.cost_center_id');
        if ($role != 'Administración') {
            $baseQuery->where('cost_centers.name', $role);
        }
        return $baseQuery->where('account_statuses.id', $this->id)->first();
    }

    /**
     * Update 
     */
    function updateModel(Request $request, $title): AccountStatus
    {
        if ($request->has('cost_center_id')) {
            ErrorRequest::assertPermission($request->user(), CostCenter::getNameById($request->cost_center_id), $title);
        }
        $this->update($request->all());
        return $this;
    }

    /**
     * RELATIONSHIPS
     */
    /**
     * Get the cost_center that owns the AccountStatus
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cost_center(): BelongsTo
    {
        return $this->belongsTo(CostCenter::class);
    }
    /**
     * Get the concept_asset that owns the AccountStatus
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function concept_asset(): BelongsTo
    {
        return $this->belongsTo(ConceptAsset::class);
    }
}
