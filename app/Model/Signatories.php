<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Signatories extends Model
{
    protected $table = 'signatories';
   
    public $fillable = ['type', 'signatory1', 'signatory2','signatory3','signatory4']; 
}
