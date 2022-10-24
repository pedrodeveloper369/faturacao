@extends('layouts.main')

@section('title', 'SIGFAL-Usuários')


@section('content')
<div class="row m-t-30">
    <div class="col-md-12">
        <div class="text-left mt-3 mb-2 ">
            
            <a href="{{url('/dashboard')}}"> <button class="btn btn-primary btn-lg">HOME</button></a>
            <a href="{{url('/user/register')}}"> <button class="btn btn-primary btn-lg">Registar</button></a>
       
        </div>
        <!-- DATA TABLE-->
        <div class="table-responsive m-b-40">
            <div class="table-responsive table--no-card m-b-30">
                    <table class="table table-borderless table-striped table-earning">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Permissão</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            @php
                            //dd($user);
                            @endphp
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td class="process">{{$user->email}}</td>
                                <td class="process">{{$user->permicao}}</td>
                                <td>
                                <a href="{{$user->id}}"><button type="button" class="btn btn-primary ">Editar</button></a>
                                <a href="{{$user->id}}"><button type="button" class="btn btn-secondary ">Bloquear</button></a>
                                <a href="{{$user->id}}"> <button type="button" class="btn btn-danger ">Excluir</button> </a>
                                </td>
                                
                            </tr>
                            @endforeach
                            
                        </tbody>
                       </table>

                       <table class="table">
                        <thead class="table-dark">
                            <tr>
                                    <th>Id</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Permissão</th>
                                    <th>Ações</th>
                                </tr>
                          
                        </thead>
                        <tbody>
                          ...
                        </tbody>
                      </table>
                      



                    </div>  
        </div>
        <!-- END DATA TABLE-->
    </div>
</div>

@endsection