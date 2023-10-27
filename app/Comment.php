<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $fillable = ['user_id','referral_id','comment'];

    public function users() {
        return $this->belongsTo(User::class);
    }

    // public function referrals() {
    //     return $this->belongsTo(Referral::class);
    // }

}
