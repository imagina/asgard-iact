<?php

namespace Modules\Iact\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Iact\Entities\Participants;
use Modules\Iact\Http\Requests\CreateParticipantsRequest;
use Modules\Iact\Http\Requests\UpdateParticipantsRequest;
use Modules\Iact\Repositories\ParticipantsRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ParticipantsController extends AdminBaseController
{
    /**
     * @var ParticipantsRepository
     */
    private $participants;

    public function __construct(ParticipantsRepository $participants)
    {
        parent::__construct();

        $this->participants = $participants;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $participants = $this->participants->paginate(20);

        return view('iact::admin.participants.index', compact('participants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('iact::admin.participants.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateParticipantsRequest $request
     * @return Response
     */
    public function store(CreateParticipantsRequest $request)
    {
        try{
            $this->participants->create($request->all());

            return redirect()->route('admin.iact.participants.index')
                ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iact::participants.title.participants')]));

        }catch (\Exception $e){
            Log::error ($e);
            return redirect()->route('admin.iact.participants.index')
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iact::participants.title.participants')]))->withInput($request->all());


        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Participants $participants
     * @return Response
     */
    public function edit(Participants $participants)
    {
        return view('iact::admin.participants.edit', compact('participants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Participants $participants
     * @param  UpdateParticipantsRequest $request
     * @return Response
     */
    public function update(Participants $participants, UpdateParticipantsRequest $request)
    {
        $this->participants->update($participants, $request->all());

        return redirect()->route('admin.iact.participants.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iact::participants.title.participants')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Participants $participants
     * @return Response
     */
    public function destroy(Participants $participants)
    {
        try{
            $this->participants->destroy($participants);

            return redirect()->route('admin.iact.participants.index')
                ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iact::participants.title.participants')]));

        }catch (\Exception $e){
            \Log::error ($e);

            return redirect()->route('admin.iact.participants.index')
                ->withError(trans('core::core.messages.resource deleted', ['name' => trans('iact::participants.title.participants')]));


        }

    }
}
