<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientBankAccount extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [

        'client_id',

        'bank_name',

        'branch_name',

        'account_holder_name',

        'account_number',

        'ifsc_code',

        'micr_code',

        'account_type',

        'upi_id',

        'is_primary',

        'is_active',

        'remarks',
    ];

    protected $casts = [

        'is_primary'=>'boolean',

        'is_active'=>'boolean',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}