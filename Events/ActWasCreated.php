<?php

namespace Modules\Iact\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Media\Contracts\StoringMedia;
use Modules\Iact\Entities\Act;

class ActWasCreated implements StoringMedia
{
    use SerializesModels;

    /**
     * @var array
     */
    public $data;
    /**
     * @var Category
     */
    public $entity;

    public function __construct($category, array $data)
    {
        $this->data = $data;
        $this->entity = $category;
    }

    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->entity;
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
