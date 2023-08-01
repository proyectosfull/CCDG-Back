<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class ConceptExpenseByUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'expense_concept_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    static function index()
    {
        return ConceptExpenseByUser::with('user', 'expense_concept')->paginate(50);
    }

    /**
     * Store
     */
    static function store(Request $request): ConceptExpenseByUser
    {
        $concept_expense_by_user = new ConceptExpenseByUser($request->all());
        $concept_expense_by_user->save();
        return $concept_expense_by_user;
    }

    /**
     * Show
     */
    function showModel(): ConceptExpenseByUser
    {
        return ConceptExpenseByUser::with('user', 'expense_concept')
            ->where('id', $this->id)
            ->first();
    }

    /**
     * Update 
     */
    function updateModel(Request $request): ConceptExpenseByUser
    {
        $this->update($request->all());
        return $this;
    }

    /**
     * RELATIONSHIPS
     */
    /**
     * Get the user that owns the ConceptExpenseByUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the expense_concept that owns the ConceptExpenseByUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function expense_concept(): BelongsTo
    {
        return $this->belongsTo(ExpenseConcept::class);
    }
}
