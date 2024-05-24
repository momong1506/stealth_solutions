<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_roles_id',
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
        'email_verified_at' => 'datetime',
    ];

    /**
     * Model to update user
     *
     * @param string $id
     * @param array $payload
     * @return boolean
     */
    public function updateUser(string $id, array $payload): bool
    {
        $record = $this->find($id);

        $this->setFillableFields($record, $payload);

        return $record->save();
    }

    /**
     * Get all user with user roles
     *
     * @return Collection
     */
    public function getUserWithRole(): Collection
    {
        return $this->select([
            'users.id',
            'name',
            'email',
            'user_roles_id',
            'user_roles.role_name',
        ])
        ->leftJoin('user_roles', function($query) {
            $query->on('user_roles.id', 'users.user_roles_id');
        })
        ->get();
    }

    /**
     * This will set the fillable fields
     *
     * @param array $data
     * @return void
     */
    protected function setFillableFields($modelInstance, array $data)
    {
        if (empty($data)) {
            return;
        }

        foreach ($data as $field => $value) {
            if (in_array($field, $this->fillable)) {
                $modelInstance->$field = $value;
            }
        }
    }
}
