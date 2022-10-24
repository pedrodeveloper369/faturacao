<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servico;
use Illuminate\Database\QueryException;

class ServicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servicos=Servico::all();
       return view('admin.servicos',['servicos'=>$servicos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('registerservico');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $servico=new Servico;
        $servico->descricao=$request->descricao;
        $servico->multa=$this->moeda($request->multa);

        $servico->save();
        $servicos=Servico::all();
        $sms='registado com sucesso';

        return view('admin.servicos',['servicos'=>$servicos,'sms'=>$sms]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $servicos=Servico::all();
        $se=Servico::findOrfail($id);
        return  view('admin.alterarservico',['servicos'=>$servicos,'se'=>$se]);
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
    public function update(Request $request, $id)
    {
        $valor=$this->moeda($request->multa);
        $s=['multa'=>$valor,'descricao'=>$request->descricao,'id'=>$request->id];
      
       /* $s->multa=$valor;
        $s->descricao=$request->descricao;
        $s->id=$request->id;
        $request->multa=$valor;*/
       // dd($request);
        //dd($request->multa);
        try{
        Servico::findOrFail($request->id)->update($s);
        $servicos=Servico::all();
        $mensagem='registo alterado com sucesso';
        }catch(QueryException $e){
            $erro="Erro ao alterar";
            $servicos=Servico::all();
            return view('admin.alterarservico',['servicos'=>$servicos],['erro'=>$erro]);
        }
        return view('admin.alterarservico',['servicos'=>$servicos,'mensagem'=> $mensagem]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //

        $s=new Servico;
        $s=Servico::findOrFail($request->servico_id);
       
        if($s->delete()):
            $servicos=Servico::all();  
            return view('admin.servicos',['servicos'=>$servicos,'sms'=> 'registo eliminado com sucesso']);
        else:
            $servicos=Servico::all();  
            return view('admin.servicos',['servicos'=>$servicos,'erro'=> 'erro ao eliminar o registo']);
        endif;

        return 'removido com sucesso';
    }

    public function moeda($v){
		$source=array('.',',');
		$replace=array('','.');
		$valor=str_replace($source, $replace, $v);
		return $valor;
		
	}
}
