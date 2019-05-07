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
}
