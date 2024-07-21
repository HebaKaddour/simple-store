<?php
namespace App\Models;

use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'date_of_birth',
        'address',
        'user_ip',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class,'user_id');
    }

    public function userByIp()
     {
      return $this->hasOne(User::class,'user_ip');
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    protected static function boot()
    {
      parent::boot();

      static::creating(function ($user) {
        $user->address = $user->country . ', ' . $user->city . ', ' . $user->postal_code;

      });
    }
    public function hasPermission($permission)
    {
        return $this->roles()->whereHas('permissions', function ($query) use ($permission) {
            $query->where('name', $permission);
        })->exists();
    }
}
