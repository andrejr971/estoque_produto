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
        $estantes = ['Escritório', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        return view('estoque.estoque', [
            'estantes' => $estantes
        ]);
    }

    public function verEstoqueChapas() {
        $estantes = ['Escritório', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        return view('estoque.ver.estoqueChapa', [
            'estantes' => $estantes
        ]);
    }

    public function verEstoqueInflamaveis() {
        $estantes = ['Escritório', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        return view('estoque.ver.estoqueCola', [
            'estantes' => $estantes
        ]);
    }

    public function verEstoqueGeral() {
        $estantes = ['Escritório', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        return view('estoque.ver.estoqueGeral', [
            'estantes' => $estantes
        ]);
    }

    public function verEstoqueTecido() {
        $estantes = ['Escritório', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        return view('estoque.ver.estoqueTextil', [
            'estantes' => $estantes
        ]); 
    }

    public function verEstoqueBaixo() {
        return view('estoque.ver.estoqueBaixo');
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

    public function createInfla()
    {
        $estantes = ['Escritório', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        return view('estoque.tipoEstoque.estoqueCola', [
            'estantes' => $estantes
        ]);
    }

    public function createGeral()
    {
        $estantes = ['Escritório', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        return view('estoque.tipoEstoque.estoqueGeral', [
            'estantes' => $estantes
        ]);
    }

    public function createTextil()
    {
        $estantes = ['Escritório', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        return view('estoque.tipoEstoque.estoqueTecido', [
            'estantes' => $estantes
        ]);
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
        $fornecedor_id = $request->input('fornecedor');

        if($tipo_estoque == '1') {
        
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

        } else if($tipo_estoque == '2') {
            $estoque->descricao = strtoupper($request->input('nome'));
            if($ult_id === null) {
                $estoque->cod_item = 'INF' . $cod[0]. '_01';
            } else {
                $estoque->cod_item = 'INF' . $cod[0]. '_0' . ($ult_id->id+1);
            }
            
            $estoque->un_medida = $request->input('unidade');
            $estoque->qtd = $request->input('qtd');
            $estoque->estoque_min = $request->input('min');
            $estoque->estoque_max = $request->input('ideal');
            $estoque->preco = $request->input('preco');
            $estoque->ean_item = $request->input('ean_item');
            $estoque->ncm_item = $request->input('ncm');
            $estoque->estante = $request->input('estante');
            $estoque->vol = $request->input('volume');
        } else if($tipo_estoque == '3') {
            $estoque->descricao = strtoupper($request->input('nome'));
            if($ult_id === null) {
                $estoque->cod_item = 'GER' . $cod[0]. '_01';
            } else {
                $estoque->cod_item = 'GER' . $cod[0]. '_0' . ($ult_id->id+1);
            }
            
            $estoque->un_medida = $request->input('unidade');
            $estoque->qtd = $request->input('qtd');
            $estoque->estoque_min = $request->input('min');
            $estoque->estoque_max = $request->input('ideal');
            $estoque->preco = $request->input('preco');
            $estoque->ean_item = $request->input('ean_item');
            $estoque->ncm_item = $request->input('ncm');
            $estoque->estante = $request->input('estante');
        } else if($tipo_estoque === '4') {
            $estoque->descricao = strtoupper($request->input('nome'));
            if($ult_id === null) {
                $estoque->cod_item = 'TEX' . $cod[0]. '_01';
            } else {
                $estoque->cod_item = 'TEX' . $cod[0]. '_0' . ($ult_id->id+1);
            }
            
            $estoque->un_medida = $request->input('unidade');
            $estoque->qtd = $request->input('metragem');
            $estoque->metragem = $request->input('metragem');
            $estoque->estoque_min = $request->input('min');
            $estoque->estoque_max = $request->input('ideal');
            $estoque->preco = $request->input('preco');
            $estoque->ncm_item = $request->input('ncm');
            $estoque->estante = $request->input('estante');
            $estoque->reservado = $request->input('reservado');
            $estoque->pedido = $request->input('pedido');
            $estoque->oc = $request->input('oc');
            
        }
        $estoque->save();

        $relEstoque = Estoque_geral::all()->last();
        $relEstoque->fornecedores()->attach($fornecedor_id, ['tipo_estoque_id' => $tipo_estoque]);

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

        $estoque = Estoque_geral::find($id);

        if(isset($estoque)) {
            $estoque->descricao = $request->input('descricao');
            $estoque->cod_item = $request->input('cod_item');
            $estoque->ean_item = $request->input('ean_item');
            $estoque->ncm_item = $request->input('ncm_item');
            $estoque->un_medida = $request->input('un_medida'); 
            $estoque->qtd = $request->input('qtd');
            $estoque->estoque_min = $request->input('estoque_min');
            $estoque->estoque_max = $request->input('estoque_max');
            $estoque->estante = $request->input('estante');
            $estoque->vol = $request->input('vol');
            $estoque->espessura = $request->input('espessura');
            $estoque->largura = $request->input('largura');
            $estoque->altura = $request->input('altura');
            if($request->input('tipo_estoque_id') == 4) {
                $estoque->reservado = $request->input('reservado');
                $estoque->pedido = $request->input('pedido');
            } else {
                $estoque->reservado = null;
                $estoque->pedido = null;
            }
            $fornecedor_id = $request->input('fornecedor_id');
            $fornecedor = $request->input('fornecedor');

            $estoque->metragem = $request->input('metragem');
            $estoque->preco = $request->input('preco');
            $estoque->save();

            if($fornecedor_id <> $fornecedor) {
                $estoque->fornecedores()->detach($fornecedor_id);
                $estoque->fornecedores()->attach($fornecedor, ['tipo_estoque_id' => $request->input('tipo_estoque_id')]);
            }

            //echo 'teste';
        
            //return json_encode($estoque);
            return back()->with('resul', 'Item Atualizado');
        }

        return response('Produto não encontrado', 404);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $fornecedor_id = $request->input('fornecedor_id');
        $estoque = Estoque_geral::find($id);
        if(isset($estoque)) {

            $estoque->fornecedores()->detach($fornecedor_id);
            $estoque->delete();

            return json_encode(Estoque_geral::all());
        }
       
    }
}
