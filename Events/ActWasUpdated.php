<?php

namespace Modules\Iact\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Iact\Entities\Act;
use Modules\Media\Contracts\StoringMedia;

class ActWasUpdated implements StoringMedia
{
    use SerializesModels;
    
    public $data;
    /**
     * @var Category
     */
    public $act;

    public function __construct(Act $act, array $data)
    {
        $this->data = $data;
        $this->act = $act;
    }

    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->act;
    }

    /**
     * Return the ALL data sent
     * @return array
     */
    public function getSubmissionData()
    {
        return $this->data;
    }
}
