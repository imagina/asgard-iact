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

    public function getItemsBy($params)
    {
        return $this->remember(function () use ($params) {
            return $this->repository->getItemsBy($params);
        });
    }

    public function getItem($criteria, $params)
    {
        return $this->remember(function () use ($criteria, $params) {
            return $this->repository->getItem($criteria, $params);
        });
    }

}
