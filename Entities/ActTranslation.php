<?php

namespace Modules\Iact\Entities;

use Illuminate\Database\Eloquent\Model;

class ActTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'activities', 'description'];
    protected $table = 'iact__act_translations';



    protected function setDescriptionAttribute($value){

        $this->attributes['description'] = $value;
    }

}
