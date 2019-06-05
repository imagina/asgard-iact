<?php

namespace Modules\Iact\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Iact\Events\ActWasCreated;
use Modules\Iact\Events\ActWasDeleted;
use Modules\Iact\Repositories\ActRepository;
use Illuminate\Database\Eloquent\Builder;

class EloquentActRepository extends EloquentBaseRepository implements ActRepository
{
    public function getItemsBy($params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with(['user', 'city', 'participant','translations']);
        } else {//Especific relationships
            $includeDefault = ['translations','user', 'city'];//Default relationships
            if (isset($params->include))//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            $query->with($includeDefault);//Add Relationships to query
        }

        /*== FILTERS ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;//Short filter

            if(isset($filter->user)){
                $query->where('user_id',$filter->user);
            }
            if(isset($filter->city)){
                $query->where('city_id',$filter->city);
            }
            if(isset($filter->patticipant)){
                $participant=$filter->patticipant;
                $query->whereHas('participants', function (Builder $q) use($participant){
                    $q->where('participant_id',$participant);
                });
            }

            //Filter by date
            if (isset($filter->date)) {
                $date = $filter->date;//Short filter date
                $date->field = $date->field ?? 'created_at';
                if (isset($date->from))//From a date
                    $query->whereDate($date->field, '>=', $date->from);
                if (isset($date->to))//to a date
                    $query->whereDate($date->field, '<=', $date->to);
            }

            //Order by
            if (isset($filter->order)) {
                $orderByField = $filter->order->field ?? 'created_at';//Default field
                $orderWay = $filter->order->way ?? 'desc';//Default way
                $query->orderBy($orderByField, $orderWay);//Add order to query
            }
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields))
            $query->select($params->fields);

        /*== REQUEST ==*/
        if (isset($params->page) && $params->page) {
            return $query->paginate($params->take);
        } else {
            $params->take ? $query->take($params->take) : false;//Take
            return $query->get();
        }
    }

    public function getItem($criteria, $params = false)
    {
        //Initialize query
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with(['user', 'city', 'participant','translations']);
        } else {//Especific relationships
            $includeDefault = ['translations','user', 'city'];//Default relationships
            if (isset($params->include))//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            $query->with($includeDefault);//Add Relationships to query
        }

        /*== FILTER ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;

            if (isset($filter->field))//Filter by specific field
                $field = $filter->field;
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields))
            $query->select($params->fields);

        /*== REQUEST ==*/
        return $query->where($field ?? 'id', $criteria)->first();
    }


    public function create($data)
    {

        $act = $this->model->create($data);
        $act->participants()->sync(array_get($data, 'participants', []));
        event(new ActWasCreated($act, $data));

        return $this->find($act->id);
    }

}
