<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentConfirmation extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_REJECTED = 'rejected';

    protected $primaryKey = "payment_confirmation_id";

    public function getBankAccountNameAttribute()
    {
        return $this->bank_account ? $this->bank_account->bank_name : null;
    }

    public function getBankAccountNoAttribute()
    {
        return $this->bank_account ? $this->bank_account->account_no : null;
    }

    public function getBankAccountOwnerAttribute()
    {
        return $this->bank_account ? $this->bank_account->account_owner : null;
    }

    public function getUrlPaymentProofAttribute()
    {
        return asset('uploads/payment-confirmations/' . $this->payment_proof);
    }

    public function order()
    {
        return $this->hasOne(Order::class, 'order_id', 'order_id');
    }

    public function bank_account()
    {
        return $this->hasOne(BankAccount::class, 'bank_account_id', 'bank_account_id');
    }
}
