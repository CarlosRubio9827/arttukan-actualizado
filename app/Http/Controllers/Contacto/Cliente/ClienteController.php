<?php

namespace App\Http\Controllers\Contacto\Cliente;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contacto\Cliente;
use App\Models\Contacto\Persona;
use App\Models\Dato_basico\Ubicacion;
use App\Models\Dato_basico\Direccion;
use App\Models\Dato_basico\Pais;
use App\Models\Dato_basico\Ciudad;
use App\Models\Root\User;
use App\Models\Root\Role;
use Illuminate\Support\Facades\Validator;
use SweetAlert;

class ClienteController extends Controller
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
        $clientes = Cliente::all();
        return View::make('contacto.clientes.index')->with(compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
        $cliente = new Cliente;
        $persona = new Persona;
        $direccion = new Direccion;
        $direccion->ciudad()->associate(new Ciudad);
        $direccion->ubicacion()->associate(new Ubicacion);
        $persona->usuario()->associate(new User);   
        $persona->direccion()->associate($direccion);
        $cliente->persona()->associate($persona);
        $editar = false;
        $paises = Pais::orderBy('nombre', 'asc')->get();
        /*$usuarios = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'ROLE_CLIENTE');
 })->whereNotIn('id',Persona::distinct()->select('usuario_id'))->get();
        return View::make('contacto.clientes.create')->with(compact('cliente','editar','paises','usuarios'));*/
        return View::make('contacto.clientes.create')->with(compact('cliente','editar','paises'));
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
            'cedula'                   => 'required|max:50|unique:personas',
            'cuenta_banco'                   => 'max:50',
            'primer_nombre'                   => 'required|max:50',
            'segundo_nombre'                   => 'max:50',
            'primer_apellido'                   => 'required|max:50',
            'segundo_apellido'                   => 'max:50',
            'telefono_fijo'                   => 'max:50',
            'telefono_movil'                   => 'required|max:50',
            'barrio'                   => 'required|max:50',
            'direccion'                   => 'required|max:50',
            //'latitud'                   => 'required|max:50',
            //'longitud'                   => 'required|max:50',
            'ciudad_id'              => 'required',
            'name'                  => 'required|max:50|unique:users',
                'email'                 => 'required|email|max:100|unique:users',
                'password'              => 'required|between:8,50|confirmed',
                'password_confirmation' => 'required|same:password',
                // 'usuario_id'                   => 'required|unique:personas',
    );

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            $request->flash();
            SweetAlert::error('Error','Errores en el formulario.');
            return Redirect::to('clientes/create')
                ->withErrors($validator);
        } else {

            $role = Role::findOrFail(4);
            $usuario = new User;
            $usuario->name = $request->name;
            $usuario->email = $request->email;
            $usuario->password =  bcrypt($request->password);         
            $usuario->save();
            $usuario->roles()->attach($role);

            $cliente = new Cliente;
            $persona = new Persona;
            $ubicacion = new Ubicacion;
            $direccion = new Direccion;

            $ubicacion->latitud = "3.5221006057596975";
            $ubicacion->longitud = "-76.29353920932567";
            $ubicacion->save();

            $usuario = User::findOrFail($usuario->id);
            $ciudad = Ciudad::findOrFail($request->ciudad_id);

            $persona->cedula = $request->cedula;
            $persona->cuenta_banco = $request->cuenta_banco;
            $persona->primer_nombre = $request->primer_nombre;
            $persona->segundo_nombre = $request->segundo_nombre;
            $persona->primer_apellido = $request->primer_apellido;
            $persona->segundo_apellido = $request->segundo_apellido;
            $persona->telefono_movil = $request->telefono_movil;
            $persona->telefono_fijo = $request->telefono_fijo;       

            $direccion->barrio = $request->barrio;
            $direccion->direccion = $request->direccion;
            $direccion->ciudad()->associate($ciudad);
            $direccion->ubicacion()->associate($ubicacion);
            $direccion->save();

            $persona->usuario()->associate($usuario);
            $persona->direccion()->associate($direccion);
            $persona->save();

            $cliente->persona()->associate($persona);     
            $cliente->save();        

            SweetAlert::success('Exito','El cliente "'.$cliente->persona->primer_nombre.' '.$cliente->persona->primer_apellido.'" ha sido registrado.');
            return Redirect::to('clientes');
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
        $cliente = Cliente::findOrFail($id);
        return View::make('contacto.clientes.show')->with(compact('cliente'));
        
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
        $cliente = Cliente::findOrFail($id);
        $editar = true;
        $paises = Pais::orderBy('nombre', 'asc')->get();
        /*$usuarios = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'ROLE_CLIENTE');
 })->whereNotIn('id',Persona::distinct()->select('usuario_id'))->get();
        return View::make('contacto.clientes.edit')->with(compact('cliente','editar','paises','usuarios'));*/
           return View::make('contacto.clientes.edit')->with(compact('cliente','editar','paises'));

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
            'cedula'                   => 'required|max:50',
            'cuenta_banco'                   => 'max:50',
            'primer_nombre'                   => 'required|max:50',
            'segundo_nombre'                   => 'max:50',
            'primer_apellido'                   => 'required|max:50',
            'segundo_apellido'                   => 'max:50',
            'telefono_fijo'                   => 'max:50',
            'telefono_movil'                   => 'required|max:50',
            'barrio'                   => 'required|max:50',
            'direccion'                   => 'required|max:50',
            'latitud'                   => 'required|max:50',
            'longitud'                   => 'required|max:50',
            'ciudad_id'              => 'required',
           // 'usuario_id'                   => 'required|unique:personas',
    );

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            $request->flash();
            SweetAlert::error('Error','Errores en el formulario.');
            return Redirect::to('clientes/create')
                ->withErrors($validator);
        } else {
            $cliente = Cliente::findOrFail($id);
            $persona = Persona::findOrFail($cliente->persona_id);
            $direccion = Direccion::findOrFail($persona->direccion_id);
            $ubicacion = Ubicacion::findOrFail($direccion->ubicacion_id);
            $ciudad = Ciudad::findOrFail($request->ciudad_id);

            $ubicacion->latitud = $request->latitud;
            $ubicacion->longitud = $request->longitud;
            $ubicacion->save();

            $direccion->barrio = $request->barrio;
            $direccion->direccion = $request->direccion;
            $direccion->ciudad()->associate($ciudad);
            $direccion->ubicacion()->associate($ubicacion);
            $direccion->save();

            $persona->cedula = $request->cedula;
            $persona->cuenta_banco = $request->cuenta_banco;
            $persona->primer_nombre = $request->primer_nombre;
            $persona->segundo_nombre = $request->segundo_nombre;
            $persona->primer_apellido = $request->primer_apellido;
            $persona->segundo_apellido = $request->segundo_apellido;
            $persona->telefono_movil = $request->telefono_movil;
            $persona->telefono_fijo = $request->telefono_fijo;    
            $persona->direccion()->associate($direccion);   
            $persona->save();
            
            $cliente->persona()->associate($persona);  
            $cliente->save();            


        SweetAlert::success('Exito','El cliente "'.$cliente->persona->primer_nombre.' '.$cliente->persona->primer_apellido.'" ha sido editado.');
        return Redirect::to('clientes');
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
        $cliente = Cliente::findOrFail($id);
    
        $cliente->delete();
        SweetAlert::success('Exito','El cliente "'.$cliente->persona->primer_nombre.' '.$cliente->persona->primer_apellido.'" ha sido eliminado.');
        return Redirect::to('clientes');
}
}