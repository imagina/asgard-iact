<?php

namespace Modules\Iact\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Act extends Model
{
    use Translatable;

    protected $table = 'iact__acts';
    public $translatedAttributes = ['title', 'activities', 'description'];
    protected $fillable = ['title', 'activities', 'description', 'options', 'city_id', 'address', 'user_id','email','phone'];
    protected $fakeColumns = ['options'];
    protected $casts = [
        'options' => 'array',


    ];


    public function user()
    {
        $driver = config('asgard.user.config.driver');
        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
    }
    public function getMainimageAttribute(){

        $image=$this->options->mainimage ?? 'modules/iact/img/default.jpg';
        $v=strftime('%u%w%g%k%M%S', strtotime($this->updated_at));
        // dd($v) ;
        return url($image.'?v='.$v);
        //return ($this->options->mainimage ?? 'modules/iplace/img/place/default.jpg').'?v='.format_date($this->updated_at,'%u%w%g%k%M%S');
    }
    public function getMediumimageAttribute(){

        return url(str_replace('.jpg','_mediumThumb.jpg',$this->options->mainimage ?? 'modules/iact/img/default.jpg'));
    }
    public function getThumbailsAttribute(){

        return url(str_replace('.jpg','_smallThumb.jpg',$this->options->mainimage?? 'modules/iact/img/default.jpg'));
    }

    public function participant()
    {
        return $this->belongsTo(Participants::class, 'participant_id');
    }
}
