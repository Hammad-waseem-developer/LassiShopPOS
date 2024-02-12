<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    protected $fillable = [
        'currency_id', 'email', 'CompanyName', 'CompanyPhone', 'CompanyAdress','default_sms_gateway','symbol_placement',
         'logo','footer','developed_by','client_id','warehouse_id','default_language','invoice_footer','app_name','on_register','on_register_ponit','ponit_value','on_purchase','on_purchase_point','on_purchase_value'
    ];

    protected $casts = [
        'currency_id' => 'integer',
        'client_id' => 'integer',
        'warehouse_id' => 'integer',
    ];

    public function Currency()
    {
        return $this->belongsTo('App\Models\Currency');
    }

}
