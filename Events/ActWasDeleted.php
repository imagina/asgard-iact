<?php

namespace Modules\Iact\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Media\Contracts\StoringMedia;

class ActWasDeleted implements StoringMedia
{
    use SerializesModels;
    /**
     * @var Category
     */
    public $entity;

    /**
     * @var disk
     */
    public $disk;

    public function __construct($act)
    {

        $this->entity = $act;
        $this->disk='publicmedia';
    }

    /**
     * Return the entity
     * @return Category
     */
    public function getEntity()
    {
        return $this->entity;
    }
}
