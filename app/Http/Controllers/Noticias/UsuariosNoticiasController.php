<?php

namespace App\Http\Controllers\Noticias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use App\Models\Usuario;
use App\Models\Rol;

class UsuariosNoticiasController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {

            $usuarios = Usuario::query();
            if (filled($request->get('nombre_completo'))) {
                $usuarios = $usuarios->where('nombre_completo', 'LIKE', '%'.$request->get('nombre_completo').'%');
            }
            if (filled($request->get('email'))) {
                $usuarios = $usuarios->where('email', 'LIKE', '%'.$request->get('email').'%');
            }
            if(filled($request->get('rol_id'))){
                $usuarios = $usuarios->where('rol_id', '=', $request->get('rol_id'));
            }

            return Datatables::of($usuarios->get())
                ->addColumn('rol', function ($item) use (&$request) {
                    return $item->rol->nombre;
                })
                ->addColumn('estado', function ($item) use (&$request) {
                    return $item->activo ?
                        '<div style="color: green; font-weight: bold">Sí</div>' :
                        '<div style="color: red; font-weight: bold">No</div>' ;
                })
                ->addColumn('action', function ($item) use (&$request) {
                    return '<a href="'.route('usuarios.editar', $item->id).'" title="Editar" class="btn btn-xs btn-primary"><ion-icon name="create"></ion-icon></a>&nbsp;
                            <a class="btn btn-xs btn-primary" onclick="script_usuarios.modal_cambiar_estado(event)" data-id="'.$item->id.'" title="Cambiar estado" data-url="'.route('usuarios.cambiar_estado').'">'.(($item->activo) ? '<ion-icon name="close-circle"></ion-icon>' :'<ion-icon name="checkmark-circle"></ion-icon>').'</a>';
                })
                ->rawColumns(['action','estado'])
                ->setRowId('orden')
                ->make(true);

        } else {
            $roles = Rol::obtenerRolesBuscador();
            return view('usuarios.index', [
                'roles_buscador' => $roles
            ]);
        }
    }


    public function crear() {
        $roles = Rol::obtenerRolesBuscador();
        return view('usuarios.form', [
            'roles' => $roles
        ]);
    }


    public function insertar(Request $request) {
        \DB::beginTransaction();

        $usuario = new Usuario();
        $usuario->nombre_completo = $request->get('nombre_completo');
        $usuario->email = $request->get('email');
        $usuario->rol_id = $request->get('rol_id');
        $usuario->telefono = $request->get('telefono');
        $usuario->password =Hash::make($request->get('password'));
        $usuario->activo = true;
        $usuario->save();

        \DB::commit();
        return redirect()->route('usuarios.index');
    }


    public function editar($id) {
        $usuario = Usuario::findOrFail($id);
        $roles = Rol::obtenerRolesBuscador();
        return view('usuarios.form', [
            'roles' => $roles,
            'usuario' => $usuario
        ]);
    }


    public function actualizar($id, Request $request) {
        \DB::beginTransaction();

        $usuario = Usuario::findOrFail($id);
        $usuario->nombre_completo = $request->get('nombre_completo');
        $usuario->email = $request->get('email');
        $usuario->rol_id = $request->get('rol_id');
        $usuario->telefono = $request->get('telefono');
        $usuario->activo = ($request->get('activo') == 'on') ? true : false;
        $usuario->save();

        \DB::commit();
        return redirect()->route('usuarios.index');
    }


    public function cambiarEstado(Request $request) {
        if ($request->ajax()) {
            \DB::beginTransaction();

            $usuario = Usuario::findOrFail($request->get('id'));
            if($usuario->activo){
                $usuario->activo = false;
            }else{
                $usuario->activo = true;
            }
            $usuario->save();

            \DB::commit();
        }
    }

}
