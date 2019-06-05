<?php

namespace Modules\Iact\Http\Controllers\Api;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Iact\Http\Requests\CreateActRequest;
use Modules\Iact\Repositories\ActRepository;
use Modules\Iact\Transformers\ActTransformer;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\User\Transformers\UserProfileTransformer;
use Route;
use Illuminate\Support\Facades\Auth;

class ActApiController extends BaseApiController
{

    private $act;
    public  $auth;

    public function __construct(ActRepository $act)
    {
        $this->act = $act;
        $this->auth=app('Illuminate\Support\Facades\Auth');
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
            if(!$user->hasAccess('iact.acts.all')) {
            $params->filter->user=$user->id;
            }
            //Request to Repository
            $dataEntity = $this->act->getItemsBy($params);
            //Response
            $response = ["data" => ActTransformer::collection($dataEntity)];

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
            $dataEntity = $this->act->getItem($criteria, $params);

            //Break if no found item
            if (!$dataEntity) throw new Exception('Item not found', 204);
            if(!$user->hasAccess('iact.acts.all')&& $dataEntity->user_id!=$user->id) {
                throw new Exception('Unauthorized', 401);
            }
            //Response
            $response = ["data" => new ActTransformer($dataEntity)];

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
            $this->validateRequestApi(new CreateActRequest($data));

            //Create item
            $dataEntity = $this->act->create($data);

            //Response
            $response = ["data" => new ActTransformer($dataEntity)];
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
        \DB::beginTransaction(); //DB Transaction
        try {
            //Get data
            $data = $request->input('attributes') ?? [];//Get data
            $user=Auth::user();
            //Validate Request
            $this->validateRequestApi(new CreateActRequest($data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);
            //Request to Repository
            $dataEntity = $this->act->getItem($criteria, $params);
            //Request to Repository
            if(!$user->hasAccess('iact.acts.all')&& $dataEntity->user_id!=$user->id) {
                throw new Exception('Unauthorized', 401);
            }
            $this->act->update($dataEntity,$data);

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
            $dataEntity = $this->act->getItem($criteria, $params);
            //call Method delete
            if(!$user->hasAccess('iact.acts.all')&& $dataEntity->user_id!=$user->id) {
                throw new Exception('Unauthorized', 401);
            }
            $this->act->destroy($dataEntity);

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