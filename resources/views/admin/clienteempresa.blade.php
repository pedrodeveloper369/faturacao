
@extends('layouts.template')

@section('title', 'Clientes Empresa')


@section('content')

<div class="section__content section__content--p30">
    <div class="container-fluid">

        @if($errors->any())
              
                         @foreach($errors->all() as $erro)
                            <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                <span class="badge badge-pill badge-danger">Erro</span>
                                {{$erro}} 
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endforeach            
                    

                 @endif  

                 @if(isset($sms))

                 <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                     <span class="badge badge-pill badge-success">Success</span>
                     {{$sms}}
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
 
                 @endif


        <div class="row mb-3">
            <div class="col-md-12">
                <div class="overview-wrap">
                    <h2 class="title-1"> Clientes Empresa </h2>
                </div>
            </div>
        </div>
        <div class="myresponsivetable table-responsive table-responsive-data3 ">
        <table class="table " id="datatable">
            <thead class="table-dark">
           
                <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Nif</th>
                        <th>Morada</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>Tipo</th>
                        <th>Mensalidade</th>
                        <th>Serviço</th>
                        <th>PT</th>
                        <th>Acções</th>
                    </tr>
                
            </thead>
            <tbody>
                

                @php 
                //formatando o valor que vem da BD no formato de dinheiro
               // $valor = number_format($s->multa, 2,",",".");

                @endphp
            @if(isset($cliente))
                  @foreach($cliente as $c)
                <tr>
                    <td>{{ $c->id}}</td>
                    <td>{{ $c->nome}}</td>
                    <td>{{ $c->nif}}</td>
                    <td>{{ $c->morada}}</td>
                    <td>{{ $c->telefone}}</td>
                    <td>{{ $c->email}}</td>
                    <td>{{ $c->tipo}}</td>
                    <td>{{ $c->preco}}</td>
                    <td>{{ $c->servico}}</td>
                    <td>{{ $c->pt}}</td>
                    <td> 
                        <button class="btn btn-md btn-outline-primary editar" id="">
                            <a class="bnEditar" href="{{url("")}}">Alterar</a>
                        </button>
                    </td>
                   

                </tr>
                @endforeach
                   
            @endif 
            </tbody>
          </table>
        </div>
    </div>
</div>








<script>
    $(document).ready(function(){
        //mascaras com jmask
        $('#multa').mask('#.##0,00',{reverse: true});


    });

    
    $(document).on('click','.editar',function(){

        //$('#alterarServicoModal').modal('show');
    });   
    
    
    $(document).ready(function(){
        //codigo para inicializar a data table
       var table=$('#datatable').DataTable();
     
            
        });
</script>

@endsection