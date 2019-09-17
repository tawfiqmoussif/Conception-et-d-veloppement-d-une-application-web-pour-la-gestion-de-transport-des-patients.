<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Hopital;
use Illuminate\Support\Facades\Hash;
use DB;

class HopitalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::select('select hopitals.id,
        hopitals.intitulé
        from hopitals
         ');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'intitulé' =>  'required|string|max:191',
            ]);
        
                   
        return Hopital::create([
            'intitulé' => $request['intitulé'],     
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $hop =Hopital::findOrFail($id);
        $this->validate($request, [
            'intitulé' =>  'required|string|max:191',

            ]);
            $hop->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hop =Hopital::findOrFail($id);

        //delete serv
        $hop->delete();

        return ['message' => 'hop deleted !'];
    }
}
