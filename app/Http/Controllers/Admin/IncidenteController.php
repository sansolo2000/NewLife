<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jira;
use Illuminate\Http\Request;
use App\WorkOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Incidente;

class IncidenteController extends Controller
{

    public function index($id)
    {
        $jira = Jira::findOrFail($id);

        $Incidentes = new Incidente();
        $IncidentesShow = $Incidentes->ObtenerIncidentes($jira);

        return view('admin.jira.obtener')
                ->with(compact('jira'))
                ->with(compact('IncidentesShow'));
    }


}
