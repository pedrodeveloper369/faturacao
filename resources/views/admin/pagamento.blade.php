@extends('layouts.template')

@section('title', 'Pagamento')


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

                 @if(session()->has('sms_erro'))

                 <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                     <span class="badge badge-pill badge-danger">erro</span>
                 
                     {{ session()->get('sms_erro') }}
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
 
                 @endif


        <div class="row mb-3">
            <div class="col-md-12">
                <div class="text-center">
                    <h2 class="title-1">Pagamento</h2>
                </div>
            </div>
        </div>
        <div class="myresponsivetable table-responsive table-responsive-data3 ">
            
            <div class="container">
         
                <div class="row">
                  <div class="col-md-4">
                        
                        <h4 class="title-3">Dados do Cliente</h4><hr>
                        Nome: <label style="color:black" class="form-control-label">  {{$cliente->nome}}</label><br>
                        NIF: <label style="color:black" class=" form-control-label"> {{$cliente->nif}}</label><br>
                        Serviço: <label style="color:black" class=" form-control-label">  {{$cliente->servico}}</label><br>
                        Pt: <label style="color:black" class=" form-control-label">  {{$cliente->pt}} </label><br>
                        Multa: <label style="color:black" class=" form-control-label"> </label><br>
                        Dívida: <label style="color:black" class=" form-control-label"> </label><br>
                        Qtd Meses: <label style="color:black" class=" form-control-label"> </label><br>
                        Valor a Pagar:<label style="color:black" class=" form-control-label"> </label>
                        
                  
                  </div>
                  <div class="col-md-8">
                   <h4 class="title-3">Dados para o Pagamento</h4><hr>
                   
                   <div hidden class="sufee-alert alert with-close alert-danger alert-dismissible fade show" id="erro">
                  
                   </div>
                    <form action="/dashboard/pagamento" method="Post"  novalidate="novalidate" id="form_pag">
                        
                        
                        @csrf

                        <div class="row">
                            <div class="col-6">
                                <label for="modo_pagamento" class="control-label mb-1">Modo de Pagamento</label>
                                
                                <select name="modo_pagamento" id="modo_pagamento" class="form-control required">
                                    <option selected="selected">Selecione</option>
                                    <option value="TPA">TPA</option>
                                    <option value="Deposito">Depósito</option>
                                    <option value="Tranferencia">Transferência</option>
                                    <option value="Cash">Cash</option>
                                </select>
                            </div>
                            
                            
                            <div class="col-6">
                                <label for="banco" class="control-label mb-1">Banco</label>
                                <select name="banco" id="banco" class="form-control required">
                                    <option selected="selected">Selecione</option>
                                    <option value="BFA">BFA</option>
                                    <option value="BAI">BAI</option>
                                    <option value="BANC">BANC</option>
                                    <option value="BIC">BIC</option>
                                    <option value="BCA">BCA</option>
                                    <option value="BCI">BCI</option>
                                    <option value="BDA">BDA</option>
                                    <option value="Económico">Económico</option>
                                    <option value="BIR">BIR</option>
                                    <option value="Milenium Atlântico">Milenium Atlântico</option>
                                    <option value="Privado Atlântico">Privado Atlântico</option>
                                    <option value="BPC">BPC</option>
                                    <option value="BNI">BNI</option>
                                    <option value="KEVE">KEVE</option>
                                    <option value="Prestígio">Prestígio</option>
                                    <option value="SOL">SOL</option>
                                    <option value="Caixa Geral Angola">Caixa Geral Angola</option>
                                    <option value="Fini Banco">Fini Banco</option>
                                    <option value="Kwanza">Kwanza</option>
                                    <option value="BCH">BCH</option>
                                    <option value="STANDARD BANK">STANDARD BANK</option>
                                    <option value="Outro">Outro</option>
                                </select>
                            </div>
                        </div>


                        <div class="row">
                            
                            <div class="col-6">
                                <label for="morada" class="control-label mb-1">Qtd Meses</label>
                                <div class="input-group">

                                    <!--id do cliente-->
                                    <input hidden type="text" id="id_cliente" name="id_cliente" value="{{$cliente->id}}">
                                    <input id="qtd" name="qtd" type="number" class="form-control"  required>
                                </div>
                            </div>

                            <div class="col-6">
                                <label for="telefone" class="control-label mb-1">ID Documento Bancário</label>
                                <div class="input-group">
                                    <input id="id_documento" name="id_documento" type="text" class="form-control required"  required>
                                </div>
                            </div>
                        </div><br>

                        
                        <div class="">
                            <button type="submit" id="btne" class="btn col-12 btn-primary">Seguinte</button>
                        </div>
                    </form>
                    
                  </div>
              </div>
        </div>
    </div>
</div>

<script>
      $(document).ready(function(){
        $('#valor').mask('#.##0,00',{reverse: true});

       
      });

      function validar(){
      //form=document.getElementById("form_pag");
       // alert('ss');
      
         
      }

         btn=document.getElementById("btne");
         myform=document.getElementById("form_pag");
        btn.addEventListener('click', (event)=>{
            event.preventDefault();
           // event.preventDefault();
           
           var modo= document.getElementById("modo_pagamento").value;
           var banco= document.getElementById("banco").value;
           var qtd= document.getElementById("qtd").value;
           var id_documento= document.getElementById("id_documento").value;
           var erro= document.getElementById("erro");
          
           if(modo=="Selecione"){
            erro.innerHTML="Porfavor selecione uma opção do modo de pagamento";
            erro.removeAttribute('hidden');
            return false;
           }else{
            erro.setAttribute('hidden', true);
           }

           if(banco=="Selecione"){
            erro.innerHTML="Porfavor selecione um nome do Banco";
            erro.removeAttribute('hidden');
            return false;
           }else{
            erro.setAttribute('hidden', true);
           }

           if(qtd==""){
            erro.innerHTML="Porfavor digite a quantidade de mês a ser pago";
            erro.removeAttribute('hidden');
            return false;
           }else{
            erro.setAttribute('hidden', true);
           }

           if(id_documento==""){
            erro.innerHTML="Porfavor digite o ID do documento bancário";
            erro.removeAttribute('hidden');
            return false;
           }else{
            erro.setAttribute('hidden', true);
            myform.submit();
           }
           

           
           
            
        });

     
</script>

@endsection