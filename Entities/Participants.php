<?php

namespace Modules\Iact\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Modules\Core\Traits\NamespacedEntity;

class Participants extends Model
{
    use Translatable, PresentableTrait, NamespacedEntity;

    protected $table = 'iact__participants';
    public $translatedAttributes = ['name'];
    protected $fillable = ['name','user_id'];

    public function user()
    {
        $driver = config('asgard.user.config.driver');
        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
    }

    public function acts(){
        return $this->belongsToMany(Act::class,'iact__act_participant');
    }

}
