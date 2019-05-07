<?php

namespace Modules\Iact\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Iact\Entities\Act;
use Modules\Iact\Http\Requests\CreateActRequest;
use Modules\Iact\Http\Requests\UpdateActRequest;
use Modules\Iact\Repositories\ActRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\User\Repositories\UserRepository;
use Modules\Ilocations\Repositories\CityRepository;
use Modules\Ilocations\Repositories\ProvinceRepository;
use Modules\Ilocations\Repositories\EloquentCityRepository;
use Modules\Ilocations\Repositories\CountryRepository;

use Modules\Iact\Repositories\ParticipantsRepository;


class ActController extends AdminBaseController
{
    /**
     * @var ActRepository
     */
    private $act;
    private $user;
    private $city;
    private $participant_id;

    public function __construct(ActRepository $act, UserRepository $user, CityRepository $city, ParticipantsRepository $participants)
    {
        parent::__construct();

        $this->act = $act;
        $this->user =$user;
        $this->city =$city;
        $this->participant_id=$participants;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $acts = $this->act->paginate(20);

        return view('iact::admin.acts.index', compact('acts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $users =  $this->user->all();
        $participants = $this->participant_id->all();
      /*  $filter=json_decode(json_encode(['country_id'=>48]));
        $provinces = $this->province->index(null,null,$filter,[],[]);
*/


        return view('iact::admin.acts.create', compact('users','participants','cities','provinces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateActRequest $request
     * @return Response
     */
    public function store(CreateActRequest $request)
    {
        try{
        $this->act->create($request->all());

        return redirect()->route('admin.iact.act.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iact::acts.title.acts')]));
     }catch (\Exception $e){

            \Log::error($e);
            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iact::acts.title.acts')]))->withInput($request->all());
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Act $act
     * @return Response
     */
    public function edit(Act $act)
    {
        $users =  $this->user->all();
        $participants = $this->participant->all();
       /* $filter=json_decode(json_encode(['country_id'=>48]));
        $provinces = $this->province->index(null,null,$filter,[],[]);
        $filter_city = json_decode(json_encode(['province_id'=>$act->province_id]));
        $cities=$this->city->index(null,null,$filter_city,[],[]);
*/
        return view('iact::admin.acts.edit', compact('act','users','participants','provinces','cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Act $act
     * @param  UpdateActRequest $request
     * @return Response
     */
    public function update(Act $act, UpdateActRequest $request)
    {
        $this->act->update($act, $request->all());

        return redirect()->route('admin.iact.act.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iact::acts.title.acts')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Act $act
     * @return Response
     */
    public function destroy(Act $act)
    {
        try{

        $this->act->destroy($act);

        return redirect()->route('admin.iact.act.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iact::acts.title.acts')]));
    }catch (\Exception $e){
            \Log::error($e);
            return redirect()->route('admin.iact.act.index')
                ->withError(trans('core::core.messages.resource deleted', ['name' => trans('iact::acts.title.acts')]));

        }
    }
}
