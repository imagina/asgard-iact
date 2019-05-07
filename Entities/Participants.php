<?php

namespace Modules\Iact\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Participants extends Model
{
    use Translatable;

    protected $table = 'iact__participants';
    public $translatedAttributes = ['title'];
    protected $fillable = ['title'];


}
