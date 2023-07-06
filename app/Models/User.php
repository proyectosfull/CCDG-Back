<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /** Index */
    static function index()
    {
        return User::with('roles')
            ->paginate(50);
    }

    /**
     * Se encarga de crear un nuevo registro en la base de datos
     */
    public static function store(Request $request)
    {
        $user = new User($request->except('password'));
        $user->password = Hash::make($request->password);
        $user->assignRole($request->role);
        $user->save();
        return $user;
    }

    /**
     * Muestra el elemento con sus relaciones
     */
    public function showModel()
    {
        return User::with('roles')
            ->where('id', $this->id)
            ->first();
    }

    /**
     * Actualiza el registro en la base de datos
     */
    public function updateModel(Request $request)
    {
        $this->update($request->except('password'));
        if ($request->has('password')) {
            $this->password = Hash::make($request->password);
            $this->save;
        }
        if ($request->has('role')) {
            //esta instruccion elimina los roles anteriores y activa solamente los del array
            $this->syncRoles([$request->role]);
        }
        return $this;
    }

    /**
     * Relationships
     */

    /**
     * Get all of the expenses for the User
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
