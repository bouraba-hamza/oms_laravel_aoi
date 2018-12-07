<?php

namespace App\Http\Controllers\Interventiondetailsproduct;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Interventiondetailsproduct;
use Illuminate\Http\Request;

class InterventiondetailsproductController extends Controller
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
            $interventiondetailsproduct = Interventiondetailsproduct::where('intervention__detail_id', 'LIKE', "%$keyword%")
                ->orWhere('installer_product_id', 'LIKE', "%$keyword%")
                ->orWhere('created_by', 'LIKE', "%$keyword%")
                ->paginate($perPage);
        } else {
            $interventiondetailsproduct = Interventiondetailsproduct::paginate($perPage);
        }

        return view('Interventiondetailsproduct.interventiondetailsproduct.index', compact('interventiondetailsproduct'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('Interventiondetailsproduct.interventiondetailsproduct.create');
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

        Interventiondetailsproduct::create($requestData);

        return redirect('interventiondetailsproduct/interventiondetailsproduct')->with('flash_message', 'Interventiondetailsproduct added!');
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
        $interventiondetailsproduct = Interventiondetailsproduct::findOrFail($id);

        return view('Interventiondetailsproduct.interventiondetailsproduct.show', compact('interventiondetailsproduct'));
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
        $interventiondetailsproduct = Interventiondetailsproduct::findOrFail($id);

        return view('Interventiondetailsproduct.interventiondetailsproduct.edit', compact('interventiondetailsproduct'));
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

        $interventiondetailsproduct = Interventiondetailsproduct::findOrFail($id);
        $interventiondetailsproduct->update($requestData);

        return redirect('interventiondetailsproduct/interventiondetailsproduct')->with('flash_message', 'Interventiondetailsproduct updated!');
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
        Interventiondetailsproduct::destroy($id);

        return redirect('interventiondetailsproduct/interventiondetailsproduct')->with('flash_message', 'Interventiondetailsproduct deleted!');
    }
}
