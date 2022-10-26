<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\Models\ModelPermission;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
      

        $user = User::create([
            
            'name' => $request->name, 
            'email' => $request->email,
            'password' => Hash::make($request->password),
            
        ])->givePermissionTo($request->permission);

        
        
       event(new Registered($user));

       // Auth::login($user);
       $users=DB::table('model_has_permissions')
       ->join('permissions','permission_id','=','permissions.id')
       ->join('users','model_id','=','users.id')
       ->select('users.*', 'permissions.name as permicao')
       ->orderBy('users.id','asc')
       ->get();
       //return $exp;
       $sms="Registo efectuado com sucesso";
       return view('admin.usuario',['users'=>$users, 'sms'=>$sms]);
       

       // return redirect(RouteServiceProvider::HOME);
    }
}
