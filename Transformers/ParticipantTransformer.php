<?php

namespace Modules\Iact\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\User\Transformers\UserProfileTransformer;

class ParticipantTransformer extends Resource
{
    public function toArray($request)
    {
        $data = [
            'id'=>$this->when($this->id, $this->id),
            'name' => $this->when($this->name, $this->name),
            'user' => new UserProfileTransformer($this->whenLoaded('user')),
        ];

        $filter = json_decode($request->filter);

        // Return data with available translations
        if (isset($filter->allTranslations) && $filter->allTranslations) {
            // Get langs avaliables
            $languages = \LaravelLocalization::getSupportedLocales();
            foreach ($languages as $lang => $value) {
                $data[$lang]['name'] = $this->hasTranslation($lang) ?
                    $this->translate("$lang")['name'] : '';
            }
        }

        return $data;
   }


}