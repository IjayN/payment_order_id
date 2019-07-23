<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Callbackdata extends Model
{
  protected $fillable = ['MerchantRequestID' , 'CheckoutRequestID' , 'ResultCode' , 'ResultDesc' , 'amount','MpesaReceiptNumber','phone_no','order_id'];

}
