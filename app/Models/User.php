<?php

namespace App\Models;

 use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
    use App\Notifications\VerificarEmailPersonalizado;
    use Illuminate\Database\Eloquent\Relations\BelongsToMany;



class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;


public function sendEmailVerificationNotification()
{
    $this->notify(new VerificarEmailPersonalizado());
}

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function createdGroups():HasMany
    {
        return $this->hasMany(Group::class, 'creator');
    }
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'groups_users')
                    ->withPivot('role')
                    ->withTimestamps();
    }
    public function groupUsers(): HasMany
    {
        return $this->hasMany(GroupUser::class);
    }
      public function routine()
    {
        return $this->hasOne(Routine::class);
    }
    public function progresses()
{
    return $this->hasMany(Progress::class);
}

}
