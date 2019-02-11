<?php

namespace App\Http\Controllers\Actividad\Servicio;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Actividad\Servicio;
use App\Models\Clasificacion\Especialidad;
use App\Models\Clasificacion\Categoria;
use App\Models\Dato_basico\Medida;
use App\Models\Dato_basico\Tipo_medida;
use Illuminate\Support\Facades\Validator;
Use SweetAlert;

class ServicioController extends Controller
{
    protected $redirectTo = '/login';
    
    public function __construct()
    {
     $this->middleware('auth');
    }
 /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
        $servicios = Servicio::all();
        return View::make('actividad.servicios.index')->with(compact('servicios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
        $servicio = new Servicio; 
        $servicio->medida()->associate(new Medida);
        $servicio->categoria()->associate(new Categoria);
        $tipos_medidas = Tipo_medida::all();
        $especialidades = Especialidad::all();   
        $editar = false;
        return View::make('actividad.servicios.create')->with(compact('servicio','editar','tipos_medidas','especialidades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
        $rules = array(
            'nombre'                   => 'required|max:50',
            'valor_unitario'                   => 'numeric|required|digits_between:1,12',
            'medida_id'                   => 'required',
            'categoria_id'                   => 'required',
            'descripcion'                => 'required|max:1000'
        );

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            SweetAlert::error('Error','Errores en el formulario.');
            return Redirect::to('servicios/create')
                ->withErrors($validator);
        } else {
            $servicio = new Servicio;
            $servicio->nombre = $request->nombre; 
            $servicio->valor_unitario = $request->valor_unitario; 
            $servicio->descripcion = $request->descripcion; 
            $servicio->categoria()->associate(Categoria::findOrFail($request->categoria_id));      
            $servicio->medida()->associate(Medida::findOrFail($request->medida_id));
           $servicio->save();        

            SweetAlert::success('Exito','El servicio "'.$servicio->nombre.'" ha sido registrada.');
            return Redirect::to('servicios');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {  
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
        $servicio = Servicio::findOrFail($id);
        return View::make('actividad.servicios.show')->with(compact('servicio'));
        
        }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
        $servicio = Servicio::findOrFail($id);
        $tipos_medidas = Tipo_medida::all();
        $especialidades = Especialidad::all();  
        $editar = true;
        return View::make('actividad.servicios.edit')->with(compact('servicio','editar','tipos_medidas','especialidades'));
   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id,Request $request)
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
       $rules = array(
            'nombre'                   => 'required|max:50',
            'valor_unitario'                   => 'numeric|required|digits_between:1,12',
            'medida_id'                   => 'required',
            'categoria_id'                   => 'required',
            'descripcion'                => 'required|max:1000'
        );

    $validator = Validator::make($request->all(), $rules);


    if ($validator->fails()) {
        SweetAlert::error('Error','Errores en el formulario.');
        return Redirect::to('servicios/'+$id+'/edit')
            ->withErrors($validator);
    } else {
        $servicio = Servicio::findOrFail($request->id);
        $servicio->nombre = $request->nombre; 
        $servicio->valor_unitario = $request->valor_unitario; 
        $servicio->descripcion = $request->descripcion; 
        $servicio->categoria()->associate(Categoria::findOrFail($request->categoria_id));      
        $servicio->medida()->associate(Medida::findOrFail($request->medida_id));
        $servicio->save();
        SweetAlert::success('Exito','El servicio "'.$servicio->nombre.'" ha sido editada.');
        return Redirect::to('servicios');
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
        $servicio = Servicio::findOrFail($id);   
        $servicio->delete();
        SweetAlert::success('Exito','El servicio "'.$servicio->nombre.'" ha sido eliminada.');
        return Redirect::to('servicios');
}
}