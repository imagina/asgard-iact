<?php

namespace Modules\Iact\Repositories\Cache;

use Modules\Iact\Repositories\ParticipantsRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheParticipantsDecorator extends BaseCacheDecorator implements ParticipantsRepository
{
    public function __construct(ParticipantsRepository $participants)
    {
        parent::__construct();
        $this->entityName = 'iact.participants';
        $this->repository = $participants;
    }
}
