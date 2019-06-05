<?php

namespace Modules\Iact\Entities;

use Illuminate\Database\Eloquent\Model;

class ParticipantsTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];
    protected $table = 'iact__participants_translations';
}
