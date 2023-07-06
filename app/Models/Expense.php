<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Expense extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'cost_center_id',
        'subcost_center_id',
        'subcatalog_id',
        'amount',
        'observations',
        'date',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'date' => 'date:Y-m-d'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /** Index */
    static function indexModel(Request $request)
    {
        $query = (new Expense)->newQuery();
        //for subcost_center_id
        if ($request->has('subcost_center_id')) {
            $query->where('subcost_center_id', $request->subcost_center_id);
        }
        //for user_id
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        //for subcatalog_id
        if ($request->has('subcatalog_id')) {
            $query->where('subcatalog_id', $request->subcatalog_id);
        }
        //for dates
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        } else if ($request->has('start_date')) {
            $query->where('date', '>=', $request->start_date);
        } else if ($request->has('end_date')) {
            $query->where('date', '<=', $request->end_date);
        }

        return $query->with('user', 'user.roles', 'cost_center', 'subcost_center', 'subcatalog', 'subcatalog.catalog')
            ->paginate(50);
    }

    /**
     * Se encarga de crear un nuevo registro en la base de datos
     */
    public static function store(Request $request)
    {
        $expense = new Expense($request->all());
        $expense->save();
        return $expense;
    }

    /**
     * Muestra el elemento con sus relaciones
     */
    public function showModel()
    {
        return Expense::with('user', 'user.roles', 'cost_center', 'subcost_center', 'subcatalog', 'subcatalog.catalog')
            ->where('id', $this->id)
            ->first();
    }

    /**
     * Actualiza el registro en la base de datos
     */
    public function updateModel(Request $request)
    {
        $this->update($request->all());
        return $this;
    }

    /**
     * Relationships
     */

    /**
     * Get the user that owns the Expense
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the cost_center that owns the Expense
     */
    public function cost_center()
    {
        return $this->belongsTo(Catalog::class);
    }

    /**
     * Get the subcost_center that owns the Expense
     */
    public function subcost_center()
    {
        return $this->belongsTo(SubCatalog::class);
    }

    /**
     * Get the subcatalog that owns the Expense
     */
    public function subcatalog()
    {
        return $this->belongsTo(SubCatalog::class);
    }
}
