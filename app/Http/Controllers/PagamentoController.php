<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pagamento;
use App\Models\Cliente;
use App\Models\Servico;
use App\Models\Pt;
use App\Models\ClientePagamento;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;

    session_start();

class PagamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pg=DB::table('clientepagamentos')
        ->join('clientes','clientepagamentos.cliente_id','=','clientes.id')
        ->join('pagamentos','clientepagamentos.pagamento_id','=','pagamentos.id')
        ->select('clientes.nome as cliente','clientes.nif as nif', 'clientepagamentos.mes','pagamentos.datapagamento as data','pagamentos.estado as estado','pagamentos.datapagamento as data','pagamentos.modopagamento as modo','pagamentos.id as id','clientepagamentos.id as idpagamento')
        ->orderBy('clientes.id','desc')
        ->get();
      
       
        return view('admin.pagamentos',['pg'=>$pg]);
    }

    public function buscarCliente(Request $request){
        
        $nif = $request->get('nif');
        
        if(!($clientes = Cliente::where('nif',$nif)->first())){  
            return redirect()->back()
            ->with('sms_erro', 'Falha na Busca, não existe nos Registos um Cliente com este NIF');
        }
        
        /*$servico = Servico::where('id',$cliente->servico_id)->first();
        $pt = Pt::where('id',$cliente->servico_id)->first();
*/
        $cliente=DB::table('clientes')->where('nif',$nif)
        ->join('servicos','clientes.servico_id','=','servicos.id')
        ->join('pts','clientes.pt_id','=','pts.id')
        ->select('clientes.*', 'servicos.descricao as servico','pts.localizacao as pt')->first();

        return view("admin.pagamento", [
            'cliente' => $cliente
            
        ]); 
 
    }

    public function pagamento(Request $request){

        $_SESSION['modo']=$request->modo_pagamento;
        $_SESSION['banco']=$request->banco;
        $_SESSION['qtd']=$request->qtd;
        $_SESSION['id_cliente']=$request->id_cliente;
        $_SESSION['valor_total']=$request->valor_total; 
        $_SESSION['id_documento']=$request->id_documento;
       
       return view('admin.dados_pagamento', [
            'qtd' => $_SESSION['qtd']
       ]);
    }


    public function retornaMes($mes){
        switch ($mes){
            case "01":
                return "Janeiro";
            
            case "02":
                return "Fevereiro";
            case "03":
                return "Março";
                
            case "04":
                return "Abril";
            case "05":
                return "Maio";
                    
            case "06":
                return "Junho";
            case "07":
                    return "Julho";
                
            case "08":
                return "Agosto";
            case "09":
                return "Setembro";
                    
            case "10":
                return "Outubro";
            case "11":
                return "Novembro";
                       
            case "12":
                return "Dezembro";
        }
    }



    public function numeroMes($mes){
        switch ($mes){
            case "Janeiro":
                return 1;
            
            case "Fevereiro":
                return 2;
            case "Março":
                return 3;
                
            case "Abril":
                return 4;
            case "Maio":
                return 5;
                    
            case "Junho":
                return 6;
            case "Julho":
                    return 7;
                
            case "Agosto":
                return 8;
            case "Setembro":
                return 9;
                    
            case "Outubro":
                return 10;
            case "Novembro":
                return 11;
                       
            case "Dezembro":
                return 12;
        }
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
       
      
        $erros=array();

        $p=new Pagamento();
        $cp=ClientePagamento::where('cliente_id',$_SESSION['id_cliente'])->first();
        //verificar se é o primeiro pagamento
        if(is_null($cp)){
            $p->modopagamento=$_SESSION['modo'];
            $p->nomebanco=$_SESSION['banco'];
            $p->id_docpagamento=$_SESSION['id_documento'];
            $p->estado='não verficicado';
            $p->qtd= $_SESSION['qtd'];
            $p->user_id=Auth::user()->id;
            $p->datapagamento = date('y-m-d');
            $p->save();
            $qtd=$p->qtd;
            
            for($i=0; $i<$qtd; $i++){
                $c=new ClientePagamento();
                $cont=$i+1;
                $ano= explode('-', $request["data".$cont]);
                $c->ano = $ano[0];
                $c->mes = $this->retornaMes($ano[1]);
                
                $c->multa=$request["valor_multa".$cont];
              
                $c->cliente_id = $_SESSION['id_cliente'];
                $c->pagamento_id = $p->id;
                $c->valor =$request["preco".$cont];
                
                $c->save();
                
            }
        }else{
            //não é o primeiro pagamento
            //visto que não é o primeiro pagamento, so devemos cadastrar quer o pagamento como o clientepagamento caso as verificações a seguir sejam confirmadas
            $qtd= $_SESSION['qtd'];

            for($i=0; $i<$qtd; $i++){
                $cont=$i+1;
                $ano_request= explode('-', $request["data".$cont]);
                $ano=$ano_request[0];
                $mes= $this->retornaMes($ano_request[1]);
                $cp=ClientePagamento::where('cliente_id',$_SESSION['id_cliente'])//vereificar se o pagamento ja
                ->where('ano',$ano)
                ->get();

                $size=count($cp);

                if( $size==0){
                    //pagamento do inicio do ano (janeiro) logo verifico se não há divida nos meses do ano passado
                    
                    $ano=$ano-1;
                    $cp=ClientePagamento::where('cliente_id',$_SESSION['id_cliente'])//vereificar se o pagamento ja
                    ->where('ano',$ano)
                    ->get();
                    foreach($cp as $c){
                        $meses[]=$this->numeroMes($c->mes);
                    }
                    sort($meses);
                    if(count($meses)<>12){
                        //possui dividas nos meses do ano anterior
                        $erros[]=" não é possivel efectuar o pagamento do mês de: $mes, pois o cliente possui divida no ano passado";

                    }

                }else{
                    //
                foreach($cp as $c){
                    $meses[]=$this->numeroMes($c->mes);
                }
                sort($meses);
                $ultimo_mes=$meses[count($meses)-1];
                //verificar se o mes a ser pago 
               
                if($this->numeroMes($mes)==($ultimo_mes+1)){
                    
                    //registar o pagamento
                    $p->modopagamento=$_SESSION['modo'];
                    $p->nomebanco=$_SESSION['banco'];
                    $p->id_docpagamento=$_SESSION['id_documento'];
                    $p->estado='não verficicado';
                    $p->qtd= $_SESSION['qtd'];
                    $p->user_id=Auth::user()->id;
                    $p->datapagamento = date('y-m-d');
                    $p->save();
                    $qtd=$_SESSION['qtd'];

                    //registar clientepagamento
                    $c=new ClientePagamento();
                    $cont=$i+1;
                    $ano= explode('-', $request["data".$cont]);
                    $c->ano = $ano[0];
                    $c->mes = $this->retornaMes($ano[1]);
                    $c->multa=$request["valor_multa".$cont];
                    $c->cliente_id = $_SESSION['id_cliente'];
                    $c->pagamento_id = $p->id;
                    $c->valor =$request["preco".$cont];
                    $c->save();

                }else{
                    $mes_seguinte=$this->retornaMes($ultimo_mes+1);
                    $erros[]="o mês de:$mes, não deve ser pago, sem pagar o mês de:  $mes_seguinte";
                }
                //
                }
               

                
            }
          
            $pg=DB::table('clientepagamentos')
            ->join('clientes','clientepagamentos.cliente_id','=','clientes.id')
            ->join('pagamentos','clientepagamentos.pagamento_id','=','pagamentos.id')
            ->select('clientes.nome as cliente','clientes.nif as nif', 'clientepagamentos.mes','pagamentos.datapagamento as data','pagamentos.estado as estado','pagamentos.datapagamento as data','pagamentos.modopagamento as modo','pagamentos.id as id')
            ->orderBy('clientes.id','desc')
            ->get();
           
            return view('admin.pagamentos',['erros'=>$erros,'pagamentos'=>$pg]);

          
        }
       /*
        */
        session_unset();
        session_destroy();

       
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function pagamentoefetuado ($cliente_id, $mes,$ano){
        $cp=ClientePagamento::where('cliente_id',$cliente_id)//vereificar se o pagamento ja
        ->where('ano',$ano)
        ->where('mes',$mes)
        ->get();
        return is_null($cp);
    }
}
