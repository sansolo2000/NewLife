<?php

namespace App\Http\Controllers\Admin;

use App\TipoEstado;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TipoEstadoRequest;


class TipoEstadoController extends Controller
{
    function __construct()
    {
        $this->middleware('can:create tipoestado', ['only' => ['create', 'store']]);
        $this->middleware('can:edit tipoestado', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete tipoestado', ['only' => ['destroy']]);
    }

    public function index()
    {
        $tipoestados = TipoEstado::when(request('search'), function($tipoestado) {
            return $tipoestado->where('ties_nombre', 'like', '%' . request('search') . '%');
        })->orderBy('ties_indice')->get();
        
        return view('admin.tipoestado.index', compact('tipoestados'));
    }

    public function create()
    {
        return view('admin.tipoestado.create');
    }

    public function store(TipoEstadoRequest $request)
    {
        $tipoestado = new TipoEstado();
        $tipoestado->ties_nombre = $request->ties_nombre;
        $tipoestado->ties_indice = $request->ties_indice;
        $tipoestado->ties_activo = ($request->ties_activo == 'S') ? 1 : 0;
        $tipoestado->save();
        return redirect('admin/tipoestado')
        ->with('Éxito', 'El tipos de estado ha sido creado.'); 
    }

    public function show($id)
    {
        $tipoestado = TipoEstado::findOrFail($id);
        return view('admin.tipoestado.show', compact('tipoestado'));
    }

    public function edit($id)
    {
        $tipoestado = TipoEstado::findOrFail($id);
        return view('admin.tipoestado.edit', compact('tipoestado'));
    }

    public function update(TipoEstadoRequest $request, $id)
    {
        $tipoestado = TipoEstado::findOrFail($id);
        $tipoestado->ties_nombre = $request->ties_nombre;
        $tipoestado->ties_indice = $request->ties_indice;
        $tipoestado->ties_activo = ($request->ties_activo == 'S') ? 1 : 0;
        $tipoestado->save();
        return redirect('admin/tipoestado')
            ->with('Éxito', 'El tipos de estado ha sido actualizado.'); 
    }

    public function destroy($id)
    {
        $tipoestado = TipoEstado::findOrFail($id);
        $tipoestado->delete();
        return redirect('admin/tipoestado')
            ->with('Éxito', 'El tipos de estado ha sido eliminado.'); 
    }
}
