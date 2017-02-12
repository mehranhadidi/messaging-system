<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * All conversations related to the user
     *
     * @return mixed
     */
    public function conversations()
    {
        return $this->belongsTo(Conversation::class)->whereNull('parent_id')->orderBy('last_reply', 'desc');
    }

    /**
     * Check if a user is in a given conversation or not
     *
     * @param Conversation $conversation
     * @return mixed
     */
    public function isInConversation(Conversation $conversation)
    {
        return $this->conversations->contains($conversation);
    }

    /**
     * Get user's avatar
     *
     * @param int $size
     * @return string
     * @link http://en.gravatar.com/support/what-is-gravatar/
     */
    public function avatar($size = 45)
    {
        return 'https://www.gravatar.com/avatar/' . md5($this->email) . '?size=' . $size . '&d=mm';
    }
}
