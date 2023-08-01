<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class ConceptAsset extends Model
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
        return ConceptAsset::paginate(50);
    }

    /**
     * Store
     */
    static function store(Request $request): ConceptAsset
    {
        $concept_asset = new ConceptAsset($request->all());
        $concept_asset->save();
        return $concept_asset;
    }

    /**
     * Show
     */
    function showModel(): ConceptAsset
    {
        return ConceptAsset::where('id', $this->id)
            ->first();
    }

    /**
     * Update 
     */
    function updateModel(Request $request): ConceptAsset
    {
        $this->update($request->all());
        return $this;
    }

    /**
     * RELATIONSHIPS
     */
    /**
     * Get all of the account_statuses for the concept_asset
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function account_statuses(): HasMany
    {
        return $this->hasMany(AccountStatus::class);
    }
}
