<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'user_name', 'email', 'mobile_number', 'advertisement_number', 'advertisement_price', 'advertisement_commission', 'date', 'receipt_photo'];
}
