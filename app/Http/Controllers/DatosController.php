<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Indicadores;
use Yajra\Datatables\Datatables;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Illuminate\Support\Facades\DB;

class DatosController extends Controller
{
    //Función que solicita el token de acceso vía POST y lo retorna
    public function tokn()
    {
        $response = Http::post('https://postulaciones.solutoria.cl/api/acceso', [
            'userName' => 'sebastianalejandrorodriguvbe28_jr4@indeedemail.com',
            'flagJson' => true
        ]);
        $data = json_decode($response->getBody());
        $tokn = $data->token;
        return $tokn;
        echo $tokn;    
    }

    //Función que carga la información obtenida a la tabla en la base de datos
    public function cargar()
    {   
        Indicadores::truncate();
        $token = $this->tokn();
        $response = Http::withHeaders(['Authorization' => 'Bearer '.$token])->get('https://postulaciones.solutoria.cl/api/indicadores');
        $datos = collect($response->json());
        $filtrados = $datos->whereIn('codigoIndicador', 'UF');
        foreach ($filtrados as $filtrado) {
            Indicadores::create($filtrado);
        }
        return view('datos')->with('successMsg','Property is updated .');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Indicadores::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('fechaIndicador', function($row)
                {
                return $row->fechaIndicador->format('Y-m-d');
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editIndicador">Editar</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteIndicador">Eliminar</a>';
                    return $btn;
                })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('crud');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Indicadores::updateOrCreate([
                    'id' => $request->id
                ],
                [
                    'nombreIndicador' => $request->nombreIndicador, 
                    'codigoIndicador' => $request->codigoIndicador,
                    'unidadMedidaIndicador' => $request->unidadMedidaIndicador,
                    'valorIndicador' => $request->valorIndicador,
                    'fechaIndicador' => $request->fechaIndicador
                ]);        
     
        return response()->json(['success'=>'Indicador guardado correctamente.']);
    }


    public function edit($id)
    {
        $indicadores = Indicadores::find($id);
        return response()->json($indicadores);
    }


    public function destroy($id)
    {
        Indicadores::find($id)->delete();
        return response()->json(['success'=>'Indicador borrado exitosamente.']);
    }

    public function mostrarGrafico(Request $request)
    {
        // Obtener los datos de la tabla "indicadores" según el rango de fechas seleccionado
        $desde = $request->input('desde');
        $hasta = $request->input('hasta');
        $indicadores = DB::table('indicadores')
            ->whereBetween('fechaIndicador', [$desde, $hasta])
            ->orderBy('fechaIndicador')
            ->get();

        // Enviar los datos a la vista
        return view('grafico', ['indicadores' => $indicadores]);
    }
}
