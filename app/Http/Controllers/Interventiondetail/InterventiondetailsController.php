<?php

namespace App\Http\Controllers\Interventiondetail;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Interventiondetail;
use Illuminate\Http\Request;

class InterventiondetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $interventiondetails = Interventiondetail::where('type', 'LIKE', "%$keyword%")
                ->orWhere('observation', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->orWhere('vehicle_id', 'LIKE', "%$keyword%")
                ->orWhere('intervention_id', 'LIKE', "%$keyword%")
                ->orWhere('created_by', 'LIKE', "%$keyword%")
                ->paginate($perPage);
        } else {
            $interventiondetails = Interventiondetail::paginate($perPage);
        }

        return view('interventiondetails.interventiondetails.index', compact('interventiondetails'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('interventiondetails.interventiondetails.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        $requestData = $request->all();

        Interventiondetail::create($requestData);

        return redirect('interventiondetails/interventiondetails')->with('flash_message', 'Interventiondetail added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $interventiondetail = Interventiondetail::findOrFail($id);

        return view('interventiondetails.interventiondetails.show', compact('interventiondetail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $interventiondetail = Interventiondetail::findOrFail($id);

        return view('interventiondetails.interventiondetails.edit', compact('interventiondetail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {

        $requestData = $request->all();

        $interventiondetail = Interventiondetail::findOrFail($id);
        $interventiondetail->update($requestData);

        return redirect('interventiondetails/interventiondetails')->with('flash_message', 'Interventiondetail updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Interventiondetail::destroy($id);

        return redirect('interventiondetails/interventiondetails')->with('flash_message', 'Interventiondetail deleted!');
    }
}
