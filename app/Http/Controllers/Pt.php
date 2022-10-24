<?php

namespace App\Http\Controllers;

use App\Models\Pt as ModelsPt;
use Illuminate\Http\Request;



class Pt extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pt=ModelsPt::all();
       return view('admin.pts',['pt'=> $pt]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pt=new ModelsPt();
        $pt->localizacao=$request->localizacao;
        $pt->save();
        $pt=ModelsPt::all();
        $sms="Registo efectuado com sucesso";
        return view('admin.pts',['pt'=> $pt, 'sms'=>$sms]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $p=ModelsPt::findOrFail($id);
        $pt=ModelsPt::all();
        return view('admin.ptalterar',['pt'=> $pt,'p'=>$p]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request)
    {
       
        $s=['id'=>$request->id,'localizacao'=>$request->localizacao];
        ModelsPt::findOrFail($request->id)->update($s);
        $pt=ModelsPt::all();
        return view('admin.pts',['pt'=> $pt, 'sms'=>'Registo alterado com sucesso']);

    }

    public function destroy(Request $request)
    {
   
        ModelsPt::findOrFail($request->pt_id)->delete();
        $pt=ModelsPt::all();
        return view('admin.pts',['pt'=> $pt, 'sms'=>'Registo eliminado com sucesso']);
        
    }
}
