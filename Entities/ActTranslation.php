<?php

namespace Modules\Iact\Entities;

use Illuminate\Database\Eloquent\Model;

class ActTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'activities', 'description'];
    protected $table = 'iact__act_translations';

    protected $casts = [
        'activities'=>'array',
    ];

    public function getActivitiesAttribute($value){
        if(isset($value)&&!empty($value)){
            return json_decode($value);
        }
        return null;
    }

}
