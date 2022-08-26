<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XeroConnections extends Model
{
    use HasFactory;
    protected $table = "xero_tokens";

    protected $fillable = [
        'uuid',
        'id_token',
        'access_token',
        'expires_in',
        'token_type',
        'refresh_token',
        'scopes',
        'auth_event_id',
        'tenant_id',
        'tenant_type',
        'tenant_name',
        'created_date_utc',
        'updated_date_utc',
        'active'
    ];
}
