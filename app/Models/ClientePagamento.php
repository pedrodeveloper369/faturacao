<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientePagamento extends Model
{
    use HasFactory;
    protected $table='clientepagamentos';
    protected $guarded=[];
}
