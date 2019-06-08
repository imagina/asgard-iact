<?php

namespace Modules\Iact\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Modules\Core\Traits\NamespacedEntity;

class Act extends Model
{
    use Translatable, PresentableTrait, NamespacedEntity;

    protected $table = 'iact__acts';
    public $translatedAttributes = ['title', 'activities', 'description'];
    protected $fillable = ['title', 'activities', 'description', 'options', 'city_id', 'address', 'email','user_id','address','phone','created_at'];
    protected $fakeColumns = ['options'];
    protected $casts = [
        'options' => 'array',
        'address'=>'array',
        'activities'=>'array',
    ];
    protected static $entityNamespace = 'asgardcms/act';

    public function user()
    {
        $driver = config('asgard.user.config.driver');
        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
    }

    public function city(){
        return $this->belongsTo("Modules\Ilocations\Entities\City");
    }

    public function participants(){
        return $this->belongsToMany(Participants::class,'iact__act_participant');
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


    public function getOptionsAttribute($value){
        return json_decode($value);
    }

    public function getAddressAttribute($value){
        if (isset($value)&& !empty($value)){
            return json_decode($value);
        }
    }

    public function getUrlAttribute() {


        return \URL::route('iacts.act.pdf', [$this->id]);

    }

    /**
     * Magic Method modification to allow dynamic relations to other entities.
     * @var $value
     * @var $destination_path
     * @return string
     */
    public function __call($method, $parameters)
    {
        #i: Convert array to dot notation
        $config = implode('.', ['asgard.iblog.config.relations', $method]);

        #i: Relation method resolver
        if (config()->has($config)) {
            $function = config()->get($config);

            return $function($this);
        }

        #i: No relation found, return the call to parent (Eloquent) to handle it.
        return parent::__call($method, $parameters);
    }

}
