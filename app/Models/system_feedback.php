<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class system_feedback extends Model
{
    protected $fillable = [
        'user_id',
        'username', 
        'title',
        'rating', 
        'feedback',
        'type',
        'priority',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isFromGovernment()
    {
        // First check if we have a user_id and relationship
        if ($this->user_id && $this->user) {
            return in_array($this->user->usertype, ['admin', 'staff']);
        }
        
        // Fallback: check username against users table
        if ($this->username) {
            $user = User::where('username', $this->username)->first();
            if ($user) {
                return in_array($user->usertype, ['admin', 'staff']);
            }
        }
        
        return false;
    }

    public function getUserInfo()
    {
        // First try with user_id relationship
        if ($this->user_id && $this->user) {
            return [
                'username' => $this->user->username,
                'usertype' => $this->user->usertype,
                'is_government' => in_array($this->user->usertype, ['admin', 'staff'])
            ];
        }

        // Fallback: lookup by username
        if ($this->username) {
            $user = User::where('username', $this->username)->first();
            if ($user) {
                return [
                    'username' => $user->username,
                    'usertype' => $user->usertype,
                    'is_government' => in_array($user->usertype, ['admin', 'staff'])
                ];
            }
        }

        // Default fallback
        return [
            'username' => $this->username ?? 'Unknown',
            'usertype' => 'citizen',
            'is_government' => false
        ];
    }
}