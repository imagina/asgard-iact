<?php

namespace Modules\Iact\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface ActRepository extends BaseRepository
{

    public function getItemsBy($params);

    public function getItem($criteria, $params);


}
