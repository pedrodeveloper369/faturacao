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
                        <button class="mb-2 btn btn-md btn-outline-primary editar" id="">
                            <a class="bnEditar" href="{{url("/dashboard/clientes/show/$c->id")}}">Alterar</a>
                        </button>

                        <button class="btn btn-md btn btn-danger eliminar" id="{{$c->id}}" onclick="retornaid({{$c->id}})" data-toggle="modal"   data-target="#smallmodal">
                            <ion-icon name="trash-outline"></ion-icon> Eliminar
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
                                <form id="formulario" action="{{url('/dashboard/clientes/store')}}" method="Post" novalidate="novalidate">
                                    @csrf

                                    <div class="row">
                                        
                                        <div class="col-6 ">
                                            <label for="nome" class="control-label mb-1">Nome*</label>
                                            <div class="input-group">
                                                <input  id="nome" name="nome" type="text" class="form-control"  required><br>
                                                <small class="vermelho" id="small"></small>
                                            </div><br>
                                        </div>

                                        <div class="col-6">
                                            <label for="nif" class="control-label mb-1">Nif*</label>
                                            <div class="input-group">
                                                <input id="nif" name="nif" type="text" class="form-control"  required>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        
                                        <div class="col-6">
                                            <label for="morada" class="control-label mb-1">Morada*</label>
                                            <div class="input-group">
                                                <input id="morada" name="morada" type="text" class="form-control"  required>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label for="telefone" class="control-label mb-1">Telefone*</label>
                                            <div class="input-group">
                                                <input id="telefone" name="telefone" type="text" class="form-control"  required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-6">
                                            <label for="email" class="control-label mb-1">Email*</label>
                                            <div class="input-group">
                                                <input id="email" name="email" type="text" class="form-control"  required>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col col-md-12">
                                                    <label for="select" class=" form-control-label">Tipo*</label>
                                                </div>
                                                <div class="col-12 col-md-12 input-group">
                                                    <select name="tipo" id="tipo" class="form-control">
                                                        <option selected=" ">Selecione</option>
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
                                                    <label for="select" class=" form-control-label">Serviço*</label>
                                                </div>
                                              
                                                <div class="col-12 col-md-12 input-group">
                                                    <select name="servico" id="servico" class="form-control">
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
                                                    <label for="select" class=" form-control-label">PT*</label>
                                                </div>
                                                <div class="col-12 col-md-12">
                                                    <select name="pt" id="pt" class="form-control">
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
                                        <div class="col-6">
                                            <label for="preco" class="control-label mb-1">Preço*</label>
                                            <div class="input-group">
                                                <input id="preco" name="preco" type="text" class="form-control"  required>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label for="observacao" class="control-label mb-1">Observação</label>
                                            <div class="input-group">
                                                <input id="observacao" name="observacao" type="text" class="form-control"  required>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="text-right">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" onclick="validar()" class="btn btn-primary">Confirmar</button>
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
    });

    
    $(document).on('click','.editar',function(){
        //$('#alterarServicoModal').modal('show');
    });   
    
    
    $(document).ready(function(){
        //codigo para inicializar a data table
     //  var table=$('#datatable').DataTable();
     
            
        });

        function retornaid(id){
            $('#cliente_id').val(id);
    }

    function validar(){
        
        var form = document.getElementById('formulario');
        
        form.addEventListener('submit', (event)=>{
            event.preventDefault();

            var nome=document.getElementById('nome');
            var nif=document.getElementById('nif');
            var morada=document.getElementById('morada');
            var telefone=document.getElementById('telefone');
            var email=document.getElementById('email');
            var tipo=document.getElementById('tipo');
            var servico=document.getElementById('servico');
            var pt=document.getElementById('pt');
            var preco=document.getElementById('preco');

            if(controladora(nome, nif, morada, telefone, email, tipo, servico, pt, preco)<=0){
                form.submit();
            }

        });
    }

    function erroValidacao(elemento, sms){
        var novo_elemento = elemento.parentElement;
        var small = novo_elemento.querySelector('small');
        
        novo_elemento.className = 'input-group erro';

    }
    function inputValidado(elemento){
        var novo_elemento = elemento.parentElement;
        novo_elemento.className = 'input-group sucesso';  
    }

    function controladora(nome, nif, morada, telefone, email, tipo, servico, pt, preco){
        var cont = 0;
        const nif_valido = /^[0-9]{9}(bo|BO|Bo|bO |ba|BA|Ba|bA |be|BE|Be|bE |ca|CA|Ca|cA |cc|CC|Cc|cC |cn|CN|Cn|cN |cs|CS|Cs|cS |ce|CE|Ce|cE |ho|HO|Ho|hO |ha|HA|Ha|hA |la|LA|La|lA |ln|LN|Ln|lN |ls|LS|Ls|lS |me|ME|Me|mE |mo|MO|Mo|mO |na|NA|Na|nA |ue|UE|Ue|uE |za|ZA|Za|zA)[0-9]{3}$/;

        if(nome.value ==""){
                cont = cont+1;
                erroValidacao(nome, 'Este campo é Obrigatório');
            }else{
                cont = cont-1;
                inputValidado(nome);
            }

            if(nif.value ==""){
                cont = cont+1;
                erroValidacao(nif, 'Este campo é Obrigatório');
            }else if(!nif_valido.test(nif.value)){
                cont = cont+1;
                erroValidacao(nif, 'NIF Invalido');
            }else{
                cont = cont-1;
                inputValidado(nif);
            }

            if(morada.value ==""){
                cont = cont+1;
                erroValidacao(morada, 'Este campo é Obrigatório');
            }else{
                cont = cont-1;
                inputValidado(morada);
            }

            if(telefone.value ==""){
                cont = cont+1;
                erroValidacao(telefone, 'Este campo é Obrigatório');
            }else{
                cont = cont-1;
                inputValidado(telefone);
            }
            if(email.value ==""){
                cont = cont+1;
                erroValidacao(email, 'Este campo é Obrigatório');
            }else{
                cont = cont-1;
                inputValidado(email);
            }
            if(tipo.value =="Selecione"){
                cont = cont+1;
                erroValidacao(tipo, 'Este campo é Obrigatório');
            }else{
                cont = cont-1;
                inputValidado(tipo);
            }
            if(servico.value =="Selecione"){
                cont = cont+1;
                erroValidacao(servico, 'Este campo é Obrigatório');
            }else{
                cont = cont-1;
                inputValidado(servico);
            }
            if(pt.value =="Selecione"){
                cont = cont+1;
                erroValidacao(pt, 'Este campo é Obrigatório');
            }else{
                cont = cont-1;
                inputValidado(pt);
            }
            if(preco.value ==""){
                cont = cont+1;
                erroValidacao(preco, 'Este campo é Obrigatório');
            }else{
                cont = cont-1;
                inputValidado(preco);
            }
            return cont;
    }
    
</script>

@endsection