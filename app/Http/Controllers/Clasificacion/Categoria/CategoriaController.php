<?php

namespace App\Http\Controllers\Clasificacion\Categoria;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Clasificacion\Categoria;

use Illuminate\Support\Facades\Validator;
use SweetAlert;

class CategoriaController extends Controller
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
        $categorias = Categoria::all();
        return View::make('clasificacion.categorias.index')->with(compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
        $categoria = new Categoria;
        $categoria->categoria()->associate(new Categoria);
        $categorias = Categoria::whereNull('categoria_id')->get();
        $editar = false;
        return View::make('clasificacion.categorias.create')->with(compact('categorias','categoria','editar'));
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
                'categoria_id'                   => 'required',
        );

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            $request->flash();
            SweetAlert::error('Error','Errores en el formulario.');
            return Redirect::to('categorias/create')
                ->withErrors($validator);
        } else {
            $categoria = new Categoria;
            $categoria->nombre = $request->nombre; 
            //$categoria->etiqueta = $request->etiqueta; 
            $categoria->categoria()->associate(Categoria::find($request->categoria_id));      
            $categoria->save();        

            SweetAlert::success('Exito','La categoria "'.$categoria->nombre.'" ha sido registrada.');
            return Redirect::to('categorias');
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
        $categoria = Categoria::findOrFail($id);
        return View::make('clasificacion.categorias.show')->with(compact('categoria'));
        
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
        $categoria = Categoria::findOrFail($id);
        $categorias = Categoria::whereNull('categoria_id')->get();
        $editar = false;
        return View::make('clasificacion.categorias.edit')->with(compact('categorias','categoria','editar'));
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
            'etiqueta'                   => 'required|max:5',
            'especialidad_id'                   => 'required',
    );

    $validator = Validator::make($request->all(), $rules);


    if ($validator->fails()) {
        $request->flash();
        SweetAlert::error('Error','Errores en el formulario.');
        return Redirect::to('categorias/'+$id+'/edit')
            ->withErrors($validator);
    } else {
        $categoria = Categoria::findOrFail($id);
        $categoria->nombre = $request->nombre; 
        $categoria->etiqueta = $request->etiqueta; 
        $categoria->categoria()->associate(Categoria::find($request->categoria_id)); 
        $categoria->save();

        SweetAlert::success('Exito','La categoria "'.$categoria->nombre.'" ha sido editada.');
        return Redirect::to('categorias');
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
        $categoria = Categoria::findOrFail($id);
    
        $categoria->delete();
        SweetAlert::success('Exito','La categoria "'.$categoria->nombre.'" ha sido eliminada.');
        return Redirect::to('categorias');
}
}