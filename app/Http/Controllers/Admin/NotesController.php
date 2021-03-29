<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jira;
use App\NotaJira;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\NotesNewRequest;
use App\Http\Requests\NotesRespondRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NotesController extends Controller
{
    public function index($id)
    {
        $Jira = Jira::FindOrFail($id);
        $NotasShow = NotaJira::join('users', 'notas_jiras.user_id', '=', 'users.id')
                            ->where('notas_jiras.jira_id', $id)
                            ->orderBy('notas_jiras.noji_padre', 'asc')
                            ->orderBy('notas_jiras.noji_id', 'asc');
//        print_f($NotasShow->toSql());
        $NotasShow = $NotasShow->get()
                            ->toArray();
        $Ind = 0;
        //$Nota = [''];                            
        foreach ($NotasShow as $NotaShow){
            if ($Ind == 0){
                $Ind = $NotaShow['noji_padre'];
            }
            if ($Ind <> $NotaShow['noji_padre']){
                $Ind = $NotaShow['noji_padre'];
            }
            if ($NotaShow['noji_id'] == $NotaShow['noji_padre']){
                $Cabeceras[$NotaShow['noji_id']] = ['noji_fecha' => Carbon::parse($NotaShow['noji_fecha'])->format('d-m-Y H:i'), 'noji_asunto' => $NotaShow['noji_asunto'], 'noji_descripcion' => $NotaShow['noji_descripcion'], 'noji_ruta' => $NotaShow['noji_ruta'], 'user_name' => $NotaShow['name']];
            }
            else{
                $Detalles[$NotaShow['noji_padre']][$NotaShow['noji_id']] = ['noji_fecha' => Carbon::parse($NotaShow['noji_fecha'])->format('d-m-Y H:i'), 'noji_asunto' => $NotaShow['noji_asunto'], 'noji_descripcion' => $NotaShow['noji_descripcion'], 'noji_ruta' => $NotaShow['noji_ruta'], 'user_name' => $NotaShow['name']];
            }
        }
    return view('admin.notes.index')
                            ->with(compact('Jira'))
                            ->with(compact('Cabeceras'))
                            ->with(compact('Detalles')); 
    }

    public function new_create($jira_id){
        $Jira = Jira::FindOrFail($jira_id);

        return view('admin.notes.create_new')
                ->with(compact('Jira'));
    }

    public function new_store(NotesNewRequest $request, $jira_id)
    {
        $user = User::findOrFail(Auth::id());

        $NotaJira = new NotaJira();
        $NotaJira->jira_id = $jira_id;
        $NotaJira->noji_asunto = $request->noji_asunto;
        $NotaJira->noji_descripcion = $request->noji_descripcion;
        $NotaJira->noji_fecha = Carbon::now();
        $NotaJira->user_id = $user->id;


        $NotaJira->save();


        if ($File = $request->file('noji_ruta')){

            $Jira = Jira::findOrFail($jira_id);
            $NewName = date("YmdHis").'_'.quitar_tildes($Jira->jira_codigo).'_'.$NotaJira->noji_id.'.'.$File->getClientOriginalExtension();

            $path = Storage::putFileAs(
                'evidencias/comentarios/'.$Jira->jira_codigo, $request->file('noji_ruta'), $NewName
            );

            $NotaJiraExt = NotaJira::findOrFail($NotaJira->noji_id);
            $NotaJiraExt->noji_ruta = $path;
            $NotaJiraExt->save();
        
        }
        
        $NotaJiraUpdate = NotaJira::findOrFail($NotaJira->noji_id);
        $NotaJiraUpdate->noji_padre = $NotaJira->noji_id;
        $NotaJiraUpdate->save();
/*
        $EnvioCorreo = new EnvioCorreoController();
        $datos = $EnvioCorreo->EnvioCorreoJira($request->jira_id, $request->tiaj_id);
*/
        return redirect('admin/notes/'.$jira_id)
            ->with('success', 'El comentario del jira ha sido creada.'); 
    }

    public function respond_create($noji_id){
        $Nota = NotaJira::FindOrFail($noji_id);
        $Jira = Jira::FindOrFail($Nota->jira_id);

        return view('admin.notes.create_respond')
                ->with(compact('Nota'))
                ->with(compact('Jira'));
    }

    public function respond_store(NotesRespondRequest $request, $noji_id)
    {
        $user = User::findOrFail(Auth::id());
        $NotaPrincipal = NotaJira::FindOrFail($noji_id);

        $NotaJira = new NotaJira();
        $NotaJira->jira_id = $NotaPrincipal->jira_id;
        $NotaJira->noji_asunto = $request->noji_asunto;
        $NotaJira->noji_descripcion = $request->noji_descripcion;
        $NotaJira->noji_fecha = Carbon::now();
        $NotaJira->user_id = $user->id;
        $NotaJira->noji_padre = $NotaPrincipal->noji_id;
        $NotaJira->save();

        if ($File = $request->file('noji_ruta')){

            $Jira = Jira::findOrFail($NotaPrincipal->jira_id);
            $NewName = date("YmdHis").'_'.quitar_tildes($Jira->jira_codigo).'_'.$NotaJira->noji_id.'.'.$File->getClientOriginalExtension();

            $path = Storage::putFileAs(
                'evidencias/comentarios/'.$Jira->jira_codigo, $request->file('noji_ruta'), $NewName
            );

            $NotaJiraExt = NotaJira::findOrFail($NotaJira->noji_id);
            $NotaJiraExt->noji_ruta = $path;
            $NotaJiraExt->save();
        
        }
        
/*
        $EnvioCorreo = new EnvioCorreoController();
        $datos = $EnvioCorreo->EnvioCorreoJira($request->jira_id, $request->tiaj_id);
*/
        return redirect('admin/notes/'.$NotaPrincipal->jira_id)
            ->with('success', 'La respuesta del comentario del jira ha sido creada.'); 
    }

    public function download($id)
    {
        $NotaJira = NotaJira::findOrFail($id);

    
        return Storage::download($NotaJira->noji_ruta);
    }


}
