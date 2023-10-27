<?php

namespace App;

use App\Traits\EncryptTrait;
use Illuminate\Support\Facades\DB;

class Referral extends Model
{
    //
    use EncryptTrait;

    protected $fillable = [
        'country',
        'reference_no',
        'organisation',
        'province',
        'district',
        'city',
        'street_address',
        'gps_location',
        'facility_name',
        'facility_type',
        'provider_name',
        'position',
        'phone',
        'email',
        'website',
        'pills_available',
        'code_to_use',
        'type_of_service',
        'note',
        'womens_evaluation'
    ];

    protected $encryptable = [
        'country',
        'reference_no',
        'organisation',
        'province',
        'district',
        'city',
        'street_address',
        'gps_location',
        'facility_name',
        'facility_type',
        'provider_name',
        'position',
        'phone',
        'email',
        'website',
        'pills_available',
        'code_to_use',
        'type_of_service',
        'note',
        'womens_evaluation'
    ];

    public static function getCountries(){
    	return DB::table('referrals')->pluck('country')->unique();
    }

    public static function getCities($country){
    	return DB::table('referrals')->where("country", $country)->pluck('city')->unique();
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }
}
