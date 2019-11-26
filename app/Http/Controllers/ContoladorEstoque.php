<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estoque;
use App\Models\Estoque_geral;
use App\Models\Fornecedor;

class ContoladorEstoque extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexView()
    {
        return view('estoque.index');
    }

    public function verEstoque() {
        return view('estoque.estoque');
    }

    public function index()
    {
        $estoque = Estoque_geral::with('fornecedores')->get();
        return $estoque->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('estoque.tipoEstoque.estoqueChapas');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ult_id = Estoque_geral::all()->last();
        $estoque = new Estoque_geral();

        $cod = str_split(strtoupper($request->input('nome')), 3);

        $tipo_estoque = $request->input('tipo');

        if($tipo_estoque == '1') {
            //$ini = 'CHA';
        
            $estoque->descricao = strtoupper($request->input('nome'));
            if($ult_id === null) {
                $estoque->cod_item = 'CHA' . $cod[0]. '_01';
            } else {
                $estoque->cod_item = 'CHA' . $cod[0]. '_0' . ($ult_id->id+1);
            }
            
            $estoque->un_medida = $request->input('unidade');
            $estoque->qtd = $request->input('qtd');
            $estoque->estoque_min = $request->input('min');
            $estoque->estoque_max = $request->input('ideal');
            $estoque->preco = $request->input('preco');
            $estoque->espessura =  $request->input('espessura');
            $estoque->largura =  $request->input('largura');
            $estoque->altura =  $request->input('altura');
            
            $estoque->area = (($request->input('largura') / 1000) * ($request->input('altura') / 1000) * $estoque->qtd);;

            /*$estoque->ean_item = null;*/
            $estoque->ncm_item = $request->input('ncm');
            /*$estoque->estante = null;
            $estoque->vol = null;
            $estoque->reservado = null;
            $estoque->pedido = null;
            $estoque->metragem = null;*/
            
            
            //return redirect('/estoque');

        } else if($request->input('tipo') == '2') {
            $ini = 'COT';
        } else if($request->input('tipo') == '3') {
            $ini = 'GER';
        } else if($request->input('tipo') == '4') {
            $ini = 'TEC';
        }
        
        //return view('estoque.estoque');
        $estoque->save();

        $relEstoque = Estoque_geral::all()->last();

        $relEstoque->fornecedores()->attach($relEstoque->id, ['tipo_estoque_id' => $tipo_estoque]);

        
        return json_encode($estoque);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
