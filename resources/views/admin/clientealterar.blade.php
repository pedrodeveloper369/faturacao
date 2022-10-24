@extends('layouts.template')

@section('title', 'Clientes')


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
                    <h2 class="title-1">Clientes</h2>
                    <button class="au-btn au-btn-icon au-btn--blue" data-toggle="modal" data-target="#registarusuarioModal" >
                        <i class="zmdi zmdi-plus"></i>Registar</button>
                </div>
            </div>
        </div>
        <div class="myresponsivetable table-responsive table-responsive-data3 ">
        <table class="table" id="datatable">
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
                

               
            @if(isset($cliente))
                  @foreach($cliente as $c)

                  @php 
                  //  formatando o valor que vem da BD no formato de dinheiro
                   $valor = number_format($c->preco, 2,",",".");
    
                    @endphp
                <tr>
                    <td>{{ $c->id}}</td>
                    <td>{{ $c->nome}}</td>
                    <td>{{ $c->nif}}</td>
                    <td>{{ $c->morada}}</td>
                    <td>{{ $c->telefone}}</td>
                    <td>{{ $c->email}}</td>
                    <td>{{ $c->tipo}}</td>
                    <td>{{ $valor}}</td>
                    <td>{{ $c->servico}}</td>
                    <td>{{ $c->pt}}</td>
                    <td> 
                        <button class="mr-3 btn btn-md btn-outline-primary editar" id="">
                            <a class="bnEditar" href="{{url("/dashboard/clientes/update")}}">Alterar</a>
                        </button>

                        <button class="mr-3 btn btn-md btn btn-danger eliminar" id="{{$c->id}}" onclick="retornaid({{$c->id}})" data-toggle="modal"   data-target="#smallmodal">
                             Eliminar
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




<!-- modal registar Clientes -->
<div class="modal fade" id="registarusuarioModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediumModalLabel">Registar Clientes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{url('/dashboard/clientes/store')}}" method="Post" novalidate="novalidate">
                                    @csrf

                                    <div class="row">
                                        
                                        <div class="col-6">
                                            <label for="nome" class="control-label mb-1">Nome</label>
                                            <div class="input-group">
                                                <input id="nome" name="nome" type="text" class="form-control"  required>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label for="nif" class="control-label mb-1">Nif</label>
                                            <div class="input-group">
                                                <input id="nif" name="nif" type="text" class="form-control"  required>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        
                                        <div class="col-6">
                                            <label for="morada" class="control-label mb-1">Morada</label>
                                            <div class="input-group">
                                                <input id="morada" name="morada" type="text" class="form-control"  required>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label for="telefone" class="control-label mb-1">Telefone</label>
                                            <div class="input-group">
                                                <input id="telefone" name="telefone" type="text" class="form-control"  required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-6">
                                            <label for="email" class="control-label mb-1">Email</label>
                                            <div class="input-group">
                                                <input id=email" name="email" type="text" class="form-control"  required>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="row form-group">
                                                <div class="col col-md-12">
                                                    <label for="select" class=" form-control-label">Tipo</label>
                                                </div>
                                                <div class="col-12 col-md-12">
                                                    <select name="tipo" id="select" class="form-control">
                                                        <option selected="selected">Selecione</option>
                                                        <option value="Particular">Particular</option>
                                                        <option value="Empresa">Empresa</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        
                                    </div>


                                    <div class="row">
                                        
                                        <div class="col-6">
                                            <div class="row form-group">
                                                <div class="col col-md-12">
                                                    <label for="select" class=" form-control-label">Serviço</label>
                                                </div>
                                              
                                                <div class="col-12 col-md-12">
                                                    <select name="servico" id="select" class="form-control">
                                                        <option selected="selected">Selecione</option>
                                                        @foreach($servicos as $s)
                                                        <option value="{{$s->id}}">{{$s->descricao}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-6">
                                            <div class="row form-group">
                                                <div class="col col-md-12">
                                                    <label for="select" class=" form-control-label">PT</label>
                                                </div>
                                                <div class="col-12 col-md-12">
                                                    <select name="pt" id="select" class="form-control">
                                                        <option selected="selected">Selecione</option>
                                                        @foreach( $pt as $p)
                                                        <option value="{{$p->id}}">{{$p->localizacao}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="preco" class="control-label mb-1">Preço</label>
                                            <div class="input-group">
                                                <input id="preco" name="preco" type="text" class="form-control"  required>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="text-right">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Confirmar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- end modal medium -->




<!-- modal Alterar Clientes -->
<div class="modal fade" id="alterarclienteModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediumModalLabel">Alterar Clientes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{url('/dashboard/clientes/update')}}" method="Post" novalidate="novalidate">
                                    @csrf
                                    {{ method_field('PUT') }}
                                    @if(isset($c))
                                    <div class="row">
                                        
                                        <div class="col-6">
                                            <label for="nome" class="control-label mb-1">Nome</label>
                                            <div class="input-group">
                                                <input id="nome" name="nome" type="text" value="{{$c->nome}}"class="form-control"  required>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label for="nif" class="control-label mb-1">Nif</label>
                                            <div class="input-group">
                                                <input id="nif" name="nif" type="text" value="{{$c->nif}}" class="form-control"  required>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        
                                        <div class="col-6">
                                            <label for="morada" class="control-label mb-1">Morada</label>
                                            <div class="input-group">
                                                <input id="morada" name="morada" type="text" value="{{$c->morada}}" class="form-control"  required>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label for="telefone" class="control-label mb-1">Telefone</label>
                                            <div class="input-group">
                                                <input id="telefone" name="telefone" value="{{$c->telefone}}" type="text" class="form-control"  required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-6">
                                            <label for="email" class="control-label mb-1">Email</label>
                                            <div class="input-group">
                                                <input id=email" name="email" value="{{$c->email}}" type="text" class="form-control"  required>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="row form-group">
                                                <div class="col col-md-12">
                                                    <label for="select" class=" form-control-label">Tipo</label>
                                                </div>
                                                <div class="col-12 col-md-12">
                                                    <select name="tipo" id="select" class="form-control">
                                                        <option selected="{{$c->tipo}}">{{$c->tipo}}</option>
                                                        <option value="Particular">Particular</option>
                                                        <option value="Empresa">Empresa</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        
                                    </div>


                                    <div class="row">
                                        
                                        <div class="col-6">
                                            <div class="row form-group">
                                                <div class="col col-md-12">
                                                    <label for="select" class=" form-control-label">Serviço</label>
                                                </div>
                                              
                                                <div class="col-12 col-md-12">
                                                    <select name="servico" id="select" class="form-control">
                                                        <option value="{{$c->servico_id}}">{{$c->servico}}</option>
                                                        @foreach($servicos as $s)
                                                        <option value="{{$s->id}}">{{$s->descricao}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-6">
                                            <div class="row form-group">
                                                <div class="col col-md-12">
                                                    <label for="select" class=" form-control-label">PT</label>
                                                </div>
                                                <div class="col-12 col-md-12">
                                                    <select name="pt" id="select" class="form-control">
                                                        <option value ="{{$c->pt_id}}">{{$c->pt}}</option>
                                                        @foreach( $pt as $p)
                                                        <option value="{{$p->id}}">{{$p->localizacao}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label for="preco" class="control-label mb-1">Preço</label>
                                            <div class="input-group">
                                                @php
                                                $valor = number_format($c->preco, 2,",",".");
                                                @endphp
                                                <input id="precoalt" name="precoalt" value="{{number_format($c->preco, 2,",",".")}}" type="text" class="form-control"  required>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label for="observacao" class="control-label mb-1">Observação</label>
                                            <div class="input-group">
                                                <input id="observacao" value="{{$c->observacao}}" name="observacao" type="text" class="form-control"  required>
                                                <input id="id" value="{{$c->id}}" name="id" type="hidden" class="form-control"  required>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="text-right">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Confirmar</button>
                                    </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                  
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- end modal medium -->



<!-- modal small -->
<div class="modal fade" id="smallmodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="smallmodalLabel">Atenção</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-3">
                    Tem certeza que deseja eliminar este registo?
                </p>
                <form action="{{url("/dashboard/clientes/delete")}}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" value="" name="cliente_id" id="cliente_id">
                    <div class="float-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                        <button type="submit" class="btn btn-primary">Sim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end modal small -->

<script>
    $(document).ready(function(){
        //mascaras com jmask
        $('#preco').mask('#.##0,00',{reverse: true});
        $('#precoalt').mask('#.##0,00',{reverse: true});
        $('#alterarclienteModal').modal('show');
       

    });

    
    $(document).on('click','.editar',function(){
        //
    });   
    
    
    $(document).ready(function(){
        //codigo para inicializar a data table
       var table=$('#datatable').DataTable();
     
            
        });

        function retornaid(id){
            $('#cliente_id').val(id);
    }
</script>

@endsection