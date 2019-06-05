<?php

namespace Modules\Iact\Repositories\Cache;

use Modules\Iact\Repositories\ActRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheActDecorator extends BaseCacheDecorator implements ActRepository
{
    public function __construct(ActRepository $act)
    {
        parent::__construct();
        $this->entityName = 'iact.acts';
        $this->repository = $act;
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
