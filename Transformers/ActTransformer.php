<?php

namespace Modules\Iact\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Ilocations\Transformers\CityTransformer;
use Modules\Media\Image\Imagy;
use Modules\User\Transformers\UserProfileTransformer;

class ActTransformer extends Resource
{
    public function toArray($request)
    {
        $data = [
            'id'=>$this->when($this->id, $this->id),
            'title' => $this->when($this->title, $this->title),
            'activitie' => $this->when($this->activitie, $this->activitie),
            'description' => $this->when($this->description, $this->description),
            'address' => $this->when($this->address, $this->address),
            'phone' => $this->when($this->phone, $this->phone),
            'user' => new UserProfileTransformer($this->whenLoaded('user')),
            'participants' => ParticipantTransformer::collection($this->whenLoaded('participants')),
            'city' => new CityTransformer($this->whenLoaded('city')),
        ];

        $filter = json_decode($request->filter);

        // Return data with available translations
        if (isset($filter->allTranslations) && $filter->allTranslations) {
            // Get langs avaliables
            $languages = \LaravelLocalization::getSupportedLocales();
            foreach ($languages as $lang => $value) {
                $data[$lang]['title'] = $this->hasTranslation($lang) ?
                    $this->translate("$lang")['title'] : '';
                $data[$lang]['description'] = $this->hasTranslation($lang) ?
                    $this->translate("$lang")['description'] ?? '' : '';
                $data[$lang]['activitie'] = $this->hasTranslation($lang) ?
                    $this->translate("$lang")['activitie'] : '';
            }
        }

        return $data;
   }


}