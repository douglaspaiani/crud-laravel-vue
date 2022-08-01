<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function lista(){
        $usuarios = DB::table('usuarios')->distinct()->get();
        return response()->json($usuarios, 200); 
    }
    public function get($id){
        $usuario = DB::table('usuarios')->where('id', '=', $id)->first();
        return response()->json($usuario, 200); 
    }
    public function add(Request $request){
        $data['nome'] = $request->get('nome');
        $data['email'] = $request->get('email');
        $data['cpf'] = $request->get('cpf');
        $data['celular'] = $request->get('celular');
        $add = DB::table('usuarios')->insert($data);
        if($add){
            return response()->json('true', 200); 
        } else {
            return response()->json(false, 200); 
        }
    }
    public function update($id, Request $request){
        $data['nome'] = $request->get('nome');
        $data['email'] = $request->get('email');
        $data['cpf'] = $request->get('cpf');
        $data['celular'] = $request->get('celular');
        $add = DB::table('usuarios')->where('id', $id)->update($data);
        if($add){
            return response()->json('true', 200); 
        } else {
            return response()->json(false, 200); 
        }
    }
    public function delete($id){
        $delete = DB::table('usuarios')->where('id', '=', $id)->delete();
        if($delete){
            return response()->json('true', 200); 
        } else {
            return response()->json(false, 200); 
        }
    }
}
