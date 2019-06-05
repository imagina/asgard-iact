<?php

namespace Modules\Iact\Http\Controllers\Api;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Iact\Http\Requests\CreateParticipantsRequest;
use Modules\Iact\Repositories\ParticipantsRepository;
use Modules\Iact\Transformers\ParticipantTransformer;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\User\Transformers\UserProfileTransformer;
use Route;
use Illuminate\Support\Facades\Auth;

class ParticipantApiController extends BaseApiController
{

    private $participant;
    public  $auth;

    public function __construct(ParticipantsRepository $participant)
    {
        $this->participant = $participant;
    }

    /**
     * GET ITEMS
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            $params = $this->getParamsRequest($request);
            //Get Parameters from URL.
            $user=Auth::user();
            if(!$user->hasAccess('iact.participants.all')) {
            $params->filter->user=$user->id;
            }
            //Request to Repository
            $dataEntity = $this->participant->getItemsBy($params);
            //Response
            $response = ["data" => ParticipantTransformer::collection($dataEntity)];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($dataEntity)] : false;
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    /**
     * GET A ITEM
     *
     * @param $criteria
     * @return mixed
     */
    public function show($criteria, Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);
            $user=Auth::user();
            //Request to Repository
            $dataEntity = $this->participant->getItem($criteria, $params);

            //Break if no found item
            if (!$dataEntity) throw new Exception('Item not found', 204);
            if(!$user->hasAccess('iact.participants.all')&& $dataEntity->user_id!=$user->id) {
                throw new Exception('Unauthorized', 401);
            }
            //Response
            $response = ["data" => new ParticipantTransformer($dataEntity)];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($dataEntity)] : false;
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    /**
     * CREATE A ITEM
     *
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        \DB::beginTransaction();
        try {
            $data = $request->input('attributes') ?? [];//Get data

            //Validate Request
            $this->validateRequestApi(new CreateParticipantsRequest($data));
            //Create item
            $dataEntity = $this->participant->create($data);

            //Response
            $response = ["data" => new ParticipantTransformer($dataEntity)];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }
        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    /**
     * UPDATE ITEM
     *
     * @param $criteria
     * @param Request $request
     * @return mixed
     */
    public function update($criteria, Request $request)
    {
        \DB::beginTransaction(); //DB Transparticipantion
        try {
            //Get data
            $data = $request->input('attributes') ?? [];//Get data
            $user=Auth::user();
            //Validate Request
            $this->validateRequestApi(new CreateParticipantsRequest($data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);
            //Request to Repository
            $dataEntity = $this->participant->getItem($criteria, $params);
            //Request to Repository
            if(!$user->hasAccess('iact.participants.all')&& $dataEntity->user_id!=$user->id) {
                throw new Exception('Unauthorized', 401);
            }
            $this->participant->update($dataEntity,$data);

            //Response
            $response = ["data" => 'Item Updated'];
            \DB::commit();//Commit to DataBase
        } catch (\Exception $e) {
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    /**
     * DELETE A ITEM
     *
     * @param $criteria
     * @return mixed
     */
    public function delete($criteria, Request $request)
    {
        \DB::beginTransaction();
        try {
            //Get params
            $params = $this->getParamsRequest($request);
            $user=Auth::user();
            $dataEntity = $this->participant->getItem($criteria, $params);
            //call Method delete
            if(!$user->hasAccess('iact.participants.all')&& $dataEntity->user_id!=$user->id) {
                throw new Exception('Unauthorized', 401);
            }
            $this->participant->destroy($dataEntity);

            //Response
            $response = ["data" => "Item deleted"];
            \DB::commit();//Commit to Data Base
        } catch (\Exception $e) {
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }
}