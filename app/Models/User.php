<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Mediable;
use App\Traits\Phonable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, LaratrustUserTrait, Notifiable, Mediable, Phonable, SoftDeletes, Filterable, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'country_id',
        'first_name',
        'middle_name',
        'last_name',
        'username',
        'birthdate',
        'email',
        'password',
        'is_blocked',
        'email_verified_at',
        'phone_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birthdate' => 'date',
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];

    public function scopeByCountry($query, $country = ''): Builder
    {
        return $query->whereHas('country', function ($q) use ($country) {
            $q->whereHas('translations', function ($q) use ($country) {
                $q->where('name', 'like', '%' . $country . '%');
            });
        });
    }

    public function scopeEmailVerified($query, $state = true): Builder
    {
        $state ? $query->whereNotNull('email_verified_at') : $query->whereNull('email_verified_at');

        return $query;
    }

    public function scopePhoneVerified($query, $state = true): Builder
    {
        $state ? $query->whereNotNull('phone_verified_at') : $query->whereNull('phone_verified_at');

        return $query;
    }

    public function scopeIsBlocked($query, $state = true)
    {
        return $query->where('is_blocked', $state);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function role()
    {
        return $this->hasOneThrough(Role::class,
            RoleUser::class,
            'user_id', 'id',
            'id',
            'role_id'
        );
    }

    public function emailToken()
    {
        return $this->hasOne(EmailToken::class);
    }

    public function sellingVisas()
    {
        return $this->hasMany(SellingVisa::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->id === 1;
    }

    public function createEmailToken($email): void
    {
        $this->emailToken()->create([
            'email' => $email,
            'token' => Hash::make(Str::random(20))
        ]);
    }

    public static function generateUsername(string $email): string
    {
        $baseUsername = explode('@', $email)[0];
        $username = $baseUsername . mt_rand(10000, 99999);
        $existingUsernames = User::withTrashed()->where('username', 'like', $baseUsername . '%')
            ->pluck('username')->toArray();

        $suffix = 1;
        while (in_array($username, $existingUsernames)) {
            $username = $baseUsername . $suffix;
            $suffix++;
        }

        return $username;
    }

    public function detachRolePermissions(Role $role)
    {
        $otherRoles = $this->roles->where('id', '!=', $role->id);
        if ($otherRoles->isNotEmpty()) {
            $otherPermissions = $otherRoles->flatMap(function ($role) {
                return $role->permissions;
            })->pluck('id');
            $thisRolePermissions = $this->permissions->pluck('id');
            $permissionsToDetach = $thisRolePermissions->diff($otherPermissions);
            $this->detachPermissions($permissionsToDetach);
        } else {
            $this->syncPermissions([]);
        }
    }

    public function removeRoleAndPermissions(Role $role)
    {
        DB::transaction(function () use ($role) {
            $this->detachRolePermissions($role);
            $this->detachRole($role);
        });
    }
}
