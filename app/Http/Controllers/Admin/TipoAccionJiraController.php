<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TipoAccionJiraRequest;
use Illuminate\Http\Request;
use App\TipoAccionJira;
use App\TipoEstado;
use Illuminate\Support\Facades\DB;

class TipoAccionJiraController extends Controller
{
    function __construct()
    {
        $this->middleware('can:create tipoaccionjira', ['only' => ['create', 'store']]);
        $this->middleware('can:edit tipoaccionjira', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete tipoaccionjira', ['only' => ['destroy']]);
    }
    public function index()
    {
        $TiposAccionesJirasOld = TipoAccionJira::
            join('tipo_estados', 'tipo_acciones_jiras.ties_id', '=', 'tipo_estados.ties_id')
            ->select('tipo_acciones_jiras.tiaj_id', 'tipo_acciones_jiras.ties_id', 
                'tipo_estados.ties_nombre', 'tipo_acciones_jiras.tiaj_nombre', 
                'tipo_acciones_jiras.tiaj_indice', 'tipo_acciones_jiras.tiaj_activo', 
                'tipo_acciones_jiras.tiaj_responsable_actual', 
                'tipo_acciones_jiras.tiaj_responsable_siguiente', 
                'tipo_acciones_jiras.tiaj_tipo', 'tipo_acciones_jiras.tiaj_sucesor', 
                'tipo_acciones_jiras.tiaj_estado', 'tipo_acciones_jiras.tiaj_codigo')
        ->orderBy('tipo_acciones_jiras.tiaj_indice', 'ASC')->get();
        foreach ($TiposAccionesJirasOld as $TipoAccionJiraOld){
            $TipoAccionJiraNew['tiaj_id'] = $TipoAccionJiraOld['tiaj_id'];
            $TipoAccionJiraNew['ties_nombre'] = $TipoAccionJiraOld['ties_nombre'];
            $TipoAccionJiraNew['tiaj_nombre'] = $TipoAccionJiraOld['tiaj_nombre'];
            $TipoAccionJiraNew['tiaj_indice'] = $TipoAccionJiraOld['tiaj_indice'];
            $TipoAccionJiraNew['tiaj_activo'] = ($TipoAccionJiraOld['tiaj_activo']) ? 'Si' : 'No';
            $TipoAccionJiraNew['tiaj_responsable_actual'] = ($TipoAccionJiraOld['tiaj_responsable_actual'] == 'Interno') ? 'Indra': 'HLF';
            $TipoAccionJiraNew['tiaj_responsable_siguiente'] = ($TipoAccionJiraOld['tiaj_responsable_siguiente'] == 'Interno') ? 'Indra': 'HLF';
            $TipoAccionJiraNew['tiaj_tipo'] = $TipoAccionJiraOld['tiaj_tipo'];
            $tiaj_sucesores = explode('|', $TipoAccionJiraOld['tiaj_sucesor']);
            $cantidad = count($tiaj_sucesores);
            $TipoAccionJiraNew['tiaj_sucesor'] = '<ul>';
            foreach($tiaj_sucesores as $tiaj_sucesor){
                $TipoAccionJiraNew['tiaj_sucesor'] .= '<li>'.$tiaj_sucesor.'</li>';
            }
            $TipoAccionJiraNew['tiaj_sucesor'] = $TipoAccionJiraNew['tiaj_sucesor'].'</ul>';
            //$TipoAccionJiraNew['tiaj_sucesor'] = substr($TipoAccionJiraNew['tiaj_sucesor'], strlen($TipoAccionJiraNew['tiaj_sucesor']), -4);
            $TipoAccionJiraNew['tiaj_estado'] = $TipoAccionJiraOld['tiaj_estado'];
            $TipoAccionJiraNew['tiaj_codigo'] = $TipoAccionJiraOld['tiaj_codigo'];
            $TiposAccionesJiras[] = $TipoAccionJiraNew;
        }
        return view('admin.tipoaccionjira.index', compact('TiposAccionesJiras'));
    }

    public function create()
    {
        $TipoEstado = TipoEstado::where('ties_activo', true)
                            ->select('ties_id', 'ties_nombre')
                            ->pluck('ties_nombre', 'ties_id')
                            ->prepend('Seleccionar', '')
                            ->toArray();    
        $ties_id = old('ties_nombre');
        $class_ties_nombre = array('class' => 'custom-select', 'id' => 'ties_nombre');  
        $class_tiaj_sucesor = array('class' => 'custom-select', 'id' => 'tiaj_sucesor', 'multiple'=>true);  
        $tiaj_indices = TipoAccionJira::select('tiaj_indice as tiaj_indice', 'tiaj_indice as tiaj_nombre')
                        ->where('tiaj_activo', true)
                        ->pluck('tiaj_nombre', 'tiaj_indice')
                        ->toArray();
        //print_f($tiaj_indices);
        $tiaj_sucesor = old('tiaj_sucesor');  
//        print_f($tiaj_sucesor);
        return view('admin.tipoaccionjira.create')
                    ->with(compact('TipoEstado'))
                    ->with(compact('ties_id'))
                    ->with(compact('class_ties_nombre'))
                    ->with(compact('class_tiaj_sucesor'))
                    ->with(compact('tiaj_sucesor'))
                    ->with(compact('tiaj_indices'));
    }

    public function store(TipoAccionJiraRequest $request)
    {
        $TipoAccionJira = new TipoAccionJira();
        $TipoAccionJira->tiaj_nombre = $request->tiaj_nombre;
        $TipoAccionJira->ties_id = $request->ties_nombre;
        $TipoAccionJira->tiaj_activo = ($request->tiaj_activo == 'S') ? 1 : 0;
        $TipoAccionJira->tiaj_responsable_actual = $request->tiaj_responsable_actual;
        $TipoAccionJira->tiaj_responsable_siguiente = $request->tiaj_responsable_siguiente;
        $TipoAccionJira->tiaj_tipo = $request->tiaj_tipo;
        $TipoAccionJira->tiaj_codigo = $request->tiaj_codigo;
        $TipoAccionJira->tiaj_indice = $request->tiaj_indice;
        $TipoAccionJira->tiaj_estado = $request->tiaj_estado;
        $TipoAccionJira->tiaj_sucesor = '';
        foreach($request->tiaj_sucesores as $tiaj_sucesor){
            $TipoAccionJira->tiaj_sucesor .= $tiaj_sucesor.'|';
        }
        $TipoAccionJira->tiaj_sucesor = substr($TipoAccionJira->tiaj_sucesor, 0, -1);
        $TipoAccionJira->save();
        return redirect('admin/tipoaccionjira')
        ->with('Éxito', 'El tipos de acción jira ha sido creado.'); 
    }

    public function show($id)
    {
        $TipoAccionJira = TipoAccionJira::join('tipo_estados', 'tipo_estados.ties_id', 'tipo_acciones_jiras.ties_id')
                ->select('tipo_acciones_jiras.tiaj_nombre', 'ties_nombre',
                    DB::raw("IF (tiaj_activo = 1, 'Si', 'No') AS tiaj_activo"),
                    'tipo_acciones_jiras.tiaj_responsable_actual', 'tipo_acciones_jiras.tiaj_responsable_siguiente', 
                    'tipo_acciones_jiras.tiaj_tipo', 'tipo_acciones_jiras.tiaj_codigo', 
                    'tiaj_indice', 'tiaj_sucesor', 'tiaj_estado')
                ->where('tipo_acciones_jiras.tiaj_id', $id)
                ->get()
                ->first();

        $tiaj_sucesor = explode('|', $TipoAccionJira->tiaj_sucesor);

        $class_tiaj_sucesor = array('class' => 'custom-select', 'id' => 'tiaj_sucesor', 'multiple'=>true, 'disabled' => 'disabled');  
        $tiaj_indices = TipoAccionJira::select('tiaj_indice as tiaj_indice', 'tiaj_indice as tiaj_nombre')
                        ->where('tiaj_activo', true)
                        ->pluck('tiaj_nombre', 'tiaj_indice')
                        ->toArray();




        return view('admin.tipoaccionjira.show')
                    ->with(compact('TipoAccionJira'))
                    ->with(compact('class_tiaj_sucesor'))
                    ->with(compact('tiaj_sucesor'))
                    ->with(compact('tiaj_indices'));


    }


    public function edit($id)
    {
        $TipoAccionJira = TipoAccionJira::join('tipo_estados', 'tipo_estados.ties_id', 'tipo_acciones_jiras.ties_id')
                ->select('tipo_acciones_jiras.tiaj_id', 'tipo_acciones_jiras.tiaj_nombre', 'tipo_acciones_jiras.ties_id',
                    DB::raw("IF (tiaj_activo = 1, 'S', 'N') AS tiaj_activo"),
                    'tipo_acciones_jiras.tiaj_responsable_actual', 'tipo_acciones_jiras.tiaj_responsable_siguiente', 
                    'tipo_acciones_jiras.tiaj_tipo', 'tipo_acciones_jiras.tiaj_codigo', 
                    'tiaj_indice', 'tiaj_sucesor', 'tiaj_estado')
                ->where('tipo_acciones_jiras.tiaj_id', $id)
                ->get()
                ->first();

        $class_ties_nombre = array('class' => 'custom-select', 'id' => 'ties_nombre');  

        $TipoEstado = TipoEstado::where('ties_activo', true)
                            ->select('ties_id', 'ties_nombre')
                            ->pluck('ties_nombre', 'ties_id')
                            ->prepend('Seleccionar', '')
                            ->toArray();    

        $tiaj_sucesor = explode('|', $TipoAccionJira->tiaj_sucesor);

        $class_tiaj_sucesor = array('class' => 'custom-select', 'id' => 'tiaj_sucesor', 'multiple'=>true);  
        $tiaj_indices = TipoAccionJira::select('tiaj_indice as tiaj_indice', 'tiaj_indice as tiaj_nombre')
                        ->where('tiaj_activo', true)
                        ->pluck('tiaj_nombre', 'tiaj_indice')
                        ->toArray();

        return view('admin.tipoaccionjira.edit')
                    ->with(compact('TipoAccionJira'))
                    ->with(compact('class_tiaj_sucesor'))
                    ->with(compact('tiaj_sucesor'))
                    ->with(compact('TipoEstado'))
                    ->with(compact('class_ties_nombre'))
                    ->with(compact('tiaj_indices'));

    }

    public function update(TipoAccionJiraRequest $request, $id)
    {
        $TipoAccionJira = TipoAccionJira::findOrFail($id);
        $TipoAccionJira->tiaj_nombre = $request->tiaj_nombre;
        $TipoAccionJira->ties_id = $request->ties_nombre;
        $TipoAccionJira->tiaj_activo = ($request->tiaj_activo == 'S') ? 1 : 0;
        $TipoAccionJira->tiaj_responsable_actual = $request->tiaj_responsable_actual;
        $TipoAccionJira->tiaj_responsable_siguiente = $request->tiaj_responsable_siguiente;
        $TipoAccionJira->tiaj_tipo = $request->tiaj_tipo;
        $TipoAccionJira->tiaj_codigo = $request->tiaj_codigo;
        $TipoAccionJira->tiaj_indice = $request->tiaj_indice;
        $TipoAccionJira->tiaj_estado = $request->tiaj_estado;
        $TipoAccionJira->tiaj_sucesor = '';
        foreach($request->tiaj_sucesores as $tiaj_sucesor){
            $TipoAccionJira->tiaj_sucesor .= $tiaj_sucesor.'|';
        }
        $TipoAccionJira->tiaj_sucesor = substr($TipoAccionJira->tiaj_sucesor, 0, -1);
        $TipoAccionJira->save();
        
        return redirect('admin/tipoaccionjira')
            ->with('Éxito', 'El tipos de acción jira ha sido actualizado.'); 
    }

    public function destroy($id)
    {
        $TipoAccionJira = TipoAccionJira::findOrFail($id);
        $TipoAccionJira->delete();
        return redirect('admin/tipoaccionjira')
            ->with('Éxito', 'El tipos de acción jira ha sido eliminado.'); 
    }

}
