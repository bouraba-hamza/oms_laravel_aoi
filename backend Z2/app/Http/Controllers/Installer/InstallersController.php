<?php

namespace App\Http\Controllers\Installer;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Personal;
use Illuminate\Http\Request;

class InstallersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return Personal::all();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('installer.installers.create');
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
        
       $installer= Installer::create($requestData);
       return response()->json($installer, 201);

  //       $this->validate($request, [
		// 	'fisrt_name' => 'required'
		// ]);
  //       $requestData = $request->all();
        
  //       Installer::create($requestData);

  //       return redirect('installer/installers')->with('flash_message', 'Installer added!');
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
        $installer = Installer::findOrFail($id);

        return view('installer.installers.show', compact('installer'));
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
        $installer = Installer::findOrFail($id);

        return view('installer.installers.edit', compact('installer'));
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
        $this->validate($request, [
			'fisrt_name' => 'required'
		]);
        $requestData = $request->all();
        
        $installer = Installer::findOrFail($id);
        $installer->update($requestData);

        return redirect('installer/installers')->with('flash_message', 'Installer updated!');
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
        Installer::destroy($id);

        return redirect('installer/installers')->with('flash_message', 'Installer deleted!');
    }
}
