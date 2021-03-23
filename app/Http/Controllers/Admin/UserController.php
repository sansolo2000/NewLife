<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\TipoJiraUser;
use App\TipoJira;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('can:create user', ['only' => ['create', 'store']]);
        $this->middleware('can:edit user', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete user', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        $UserShow = User::leftjoin('tipo_jiras_users', 'users.id', 'tipo_jiras_users.user_id')
                        ->leftjoin('tipo_jiras', 'tipo_jiras.tiji_id', '=', 'tipo_jiras_users.tiji_id')
                        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        ->select('users.id', 'users.name', 'users.email', 'roles.name as rol', DB::raw('CONCAT(tipo_jiras.tiji_sistema, "-", tipo_jiras.tiji_nombre) as tiji_nombre'))
                        ->orderBy('users.id', 'asc')
                        ->get()
                        ->toArray();
        $IdUsers = '';
        $UserNew = array();
        foreach ($UserShow as $User){
            if ($IdUsers <> $User['id']){
                if ($IdUsers <> ''){ 
                    $Users[] = $UserNew; 
                }
                $IdUsers = $User['id'];
                $UserNew['id'] = $User['id'];
                $UserNew['name'] = $User['name'];
                $UserNew['email'] = $User['email'];
                $UserNew['rol'] = $User['rol'];
                if (isset($User['tiji_nombre'])){
                    $UserNew['tiji_nombre'] = '<li>'.$User['tiji_nombre'].'</li>';
                }
                else{
                    $UserNew['tiji_nombre'] = '';
                }
            }
            else {
                if (isset($User['tiji_nombre'])){
                    $UserNew['tiji_nombre'] .= '<li>'.$User['tiji_nombre'].'</li>';
                }
                else{
                    $UserNew['tiji_nombre'] = '';
                }
            }
        }
        $Users[] = $UserNew; 
        return view('admin.user.index')->with(compact('Users'));
    }

    public function create()
    {
        $areas = ['' => 'Seleccionar', 'Interno' => 'Interno', 'Externo' => 'Externo'];
        $TiposJiras = TipoJira::select(DB::raw('tiji_id, CONCAT(tiji_sistema, "-", tiji_nombre) as tiji_nombre'))->where('tiji_activo', true)->get(); 
        $roles = Role::pluck('name', 'id')->prepend('Seleccionar', '');
        return view('admin.user.create')->with(compact('areas'))->with(compact('roles'))->with(compact('TiposJiras'));
    }

    public function store(Request $request)
    {
        $input = $request->only('name', 'email', 'password', 'area');
        $input['password'] = bcrypt($request->password);
        $user = User::create($input);
        $user->assignRole($request->role);

        foreach($request->tiji as $tiji){
            $TipoJiraUserSearch = TipoJiraUser::
                            where('user_id', $user->id)
                            ->where('tiji_id', intval($tiji))
                            ->first();

            if ($TipoJiraUserSearch === null) {
                $TipoJiraUser = new TipoJiraUser();
                $TipoJiraUser->user_id = $user->id;
                $TipoJiraUser->tiji_id = intval($tiji);
                $TipoJiraUser->save();
            }
        }
        return redirect()->route('admin.user.index')->with('success', 'A user was created.');
    }

    public function show($id)
    {
        $user = User::join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        ->where('users.id', '=', $id)
                        ->select('users.id', 'users.name', 'users.email', 'users.area', 'roles.id as role_id')
                        ->orderBy('users.id', 'asc')
                        //->toSql();
                        ->get()
                        ->first();      
        $areas = ['' => 'Seleccionar', 'Interno' => 'Interno', 'Externo' => 'Externo'];

        $TiposJiras = TipoJira::where('tiji_activo', true)->get(); 

        $roles = Role::pluck('name', 'id')->prepend('Seleccionar', '');

        $TiposJirasUsers = TipoJiraUser::where('tipo_jiras_users.user_id', $id)
                                    ->select('tiji_id')
                                    ->get()
                                    ->toArray();

        $TiposJirasUsersNew = TipoJira::CargarTiposJiras('String');                
        foreach ($TiposJirasUsers as $TipoJiraUser){
            $TiposJirasUsersNew[$TipoJiraUser['tiji_id']] = 'checked="checked"';
        }                        
        //print_f($user);  
        return view('admin.user.show')
            ->with(compact('user'))
            ->with(compact('TiposJiras'))
            ->with(compact('roles'))
            ->with(compact('TiposJirasUsersNew'))
            ->with(compact('areas'));
    }

    public function edit($id)
    {
        $user = User::join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        ->where('users.id', '=', $id)
                        ->select('users.id', 'users.name', 'users.email', 'users.area', 'roles.id as role_id')
                        ->orderBy('users.id', 'asc')
                        //->toSql();
                        ->get()
                        ->first();      
        $areas = ['' => 'Seleccionar', 'Interno' => 'Interno', 'Externo' => 'Externo'];

        $TiposJiras = TipoJira::select(DB::raw('tiji_id, CONCAT(tiji_sistema, "-", tiji_nombre) as tiji_nombre'))
                                ->where('tiji_activo', true)->get(); 

        $roles = Role::pluck('name', 'id')->prepend('Seleccionar', '');

        $TiposJirasUsers = TipoJiraUser::where('tipo_jiras_users.user_id', $id)
                                    ->select('tiji_id')
                                    ->get()
                                    ->toArray();

        $TiposJirasUsersNew = TipoJira::CargarTiposJiras('String');            
        foreach ($TiposJirasUsers as $TipoJiraUser){
            $TiposJirasUsersNew[$TipoJiraUser['tiji_id']] = 'checked="checked"';
        }                        

        return view('admin.user.edit')
                ->with(compact('user'))
                ->with(compact('TiposJiras'))
                ->with(compact('roles'))
                ->with(compact('TiposJirasUsersNew'))
                ->with(compact('areas'));
}

    public function update(Request $request, $id)
    {
        $input = $request->only('name', 'email', 'area');
        if($request->filled('password')) {
            $input['password'] = bcrypt('password');
        }
        $user = User::FindOrFail($id);
        $user->update($input);
        $user->syncRoles($request->role);
        $TiposJirasUsers = TipoJira::CargarTiposJiras('Boolean');
        foreach($request->tiji as $tiji){
            $TiposJirasUsers[intval($tiji)] = true;
        }
        foreach ($TiposJirasUsers as $Ind => $TipoJiraUser ){

            if ($TipoJiraUser){
                $TipoJiraUserSearch = TipoJiraUser::
                                    where('user_id', $id)
                                    ->where('tiji_id', $Ind)
                                    ->first();
                if ($TipoJiraUserSearch === null) {
                    $TipoJiraUserNew = new TipoJiraUser;
                    $TipoJiraUserNew->user_id = $id;
                    $TipoJiraUserNew->tiji_id = $Ind;
                    $TipoJiraUserNew->save();
                }

            }
            else{
                $TipoJiraUserDelete = TipoJiraUser::where('user_id', $id)
                                        ->where('tiji_id', $Ind);
                $TipoJiraUserDelete->delete();
            }
        }

        return redirect('admin/user')
        ->with('success', 'EL usuario ha sido actualizado.');
    }

    public function destroy(User $user)
    {
        if(auth()->id() === $user->id) {
            return back()->withErrors('You cannot delete current logged in user.');
        }
        $user->delete();
        return redirect()->route('admin.user.index')->with('success', 'A user was deleted.');
    }
}
