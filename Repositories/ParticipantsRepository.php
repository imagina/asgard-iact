<?php

namespace Modules\Iact\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface ParticipantsRepository extends BaseRepository
{
    public function getItemsBy($params);

    public function getItem($criteria, $params);
}
