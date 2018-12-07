<?php

namespace App\Http\Controllers\Installerproduct;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Installerproduct;
use Illuminate\Http\Request;

class InstallerproductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return Installerproduct::all();
        /*
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $installerproduct = Installerproduct::where('status', 'LIKE', "%$keyword%")
                ->orWhere('product_id', 'LIKE', "%$keyword%")
                ->orWhere('installer_id', 'LIKE', "%$keyword%")
                ->orWhere('created_by', 'LIKE', "%$keyword%")
                ->paginate($perPage);
        } else {
            $installerproduct = Installerproduct::paginate($perPage);
        }

        return view('installerproduct.installerproduct.index', compact('installerproduct'));*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('installerproduct.installerproduct.create');
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
        
       $installerProduct= Installerproduct::create($requestData);
        return response()->json($installerProduct, 201);

      //  return redirect('installerproduct/installerproduct')->with('flash_message', 'Installerproduct added!');
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
        $installerproduct = Installerproduct::findOrFail($id);
        return response()->json($installerproduct, 201);
       // return view('installerproduct.installerproduct.show', compact('installerproduct'));
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
        $installerproduct = Installerproduct::findOrFail($id);
        return response()->json($installerproduct, 201);
        //return view('installerproduct.installerproduct.edit', compact('installerproduct'));
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
        
        $installerproduct = Installerproduct::findOrFail($id);
        $installerproduct->update($requestData);

        return redirect('installerproduct/installerproduct')->with('flash_message', 'Installerproduct updated!');
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
        Installerproduct::destroy($id);

        return redirect('installerproduct/installerproduct')->with('flash_message', 'Installerproduct deleted!');
    }
}
