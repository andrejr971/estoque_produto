<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fornecedor;
use App\Models\Estoque_geral;
use App\Models\Estoque;

class ContoladorFornecedor extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexView()
    {
        $estantes = ['Escritório', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        return view('fornecedor.index',  [
            'estantes' => $estantes
        ]);
    }

    public function index()
    {
        $fornecedores = Fornecedor::with('estoque')->get();
        return $fornecedores->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fornecedor.addFornecedor');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fornecedor = new Fornecedor();
        
        $fornecedor->nome = $request->input('nome');
        $fornecedor->email = $request->input('email');
        $fornecedor->cnpj = $request->input('cnpj');
        $fornecedor->telefone = $request->input('telefone');
        $fornecedor->inscricao = $request->input('inscricao');
        $fornecedor->endereco = $request->input('endereco');
        $fornecedor->numero = $request->input('numero');
        $fornecedor->bairro = $request->input('bairro');
        $fornecedor->cidade = $request->input('cidade');
        $fornecedor->cep = $request->input('cep');
        $fornecedor->uf = $request->input('uf');

        $fornecedor->save();

        return json_encode($fornecedor);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fornecedor = Fornecedor::find($id);
        if(isset($fornecedor)) {
            return $fornecedor->toJson();
        }
        return response('Fornecedor não encontrado', 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fornecedor = Fornecedor::find($id);

        if(isset($fornecedor)) {
            $fornecedor->nome = $request->input('nome');
            $fornecedor->email = $request->input('email');
            $fornecedor->cnpj = $request->input('cnpj');
            $fornecedor->telefone = $request->input('telefone');
            $fornecedor->inscricao = $request->input('inscricao');
            $fornecedor->endereco = $request->input('endereco');
            $fornecedor->numero = $request->input('numero');
            $fornecedor->bairro = $request->input('bairro');
            $fornecedor->cidade = $request->input('cidade');
            $fornecedor->cep = $request->input('cep');
            $fornecedor->uf = $request->input('uf');

            $fornecedor->save();

            return json_encode($fornecedor);
        }
        return response('Fornecedor não encontrado', 404);
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $itens = Estoque::where('fornecedor_id', $id)->get();
        $fornecedor = Fornecedor::find($id);

        if(isset($fornecedor)) {
            for ($i=0; $i < count($itens); $i++) { 
                $estoque = Estoque_geral::find($itens[$i]->estoque_geral_id);
                $estoque->fornecedores()->detach($id);

                $estoque->delete();
            }
            $fornecedor->delete();
            return response('OK', 200);
        }

        return response('Fornecedor não encontrado', 404);
    }
}
