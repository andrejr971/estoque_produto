<?php

namespace App\Http\Controllers;

use App\Models\EntradaSaida;
use Illuminate\Http\Request;
use App\Models\Estoque;
use App\Models\Estoque_geral;
use App\Models\Fornecedor;
use App\Models\tipo_estoque;
use Carbon\Carbon;

class ContoladorEstoque extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexView()
    {
        $dataAtual = new Carbon('now');
        $data2 = new Carbon('last fortnight');

        $estoque = Estoque_geral::with('fornecedores')->get();
        $entrada = EntradaSaida::where('situacao', '1')
                ->whereBetween('created_at', [$data2->toDateString(), $dataAtual->toDateString()])->limit(3)->get();

        return view('estoque.index', [
            'estoque' => $estoque,
            'entrada' => $entrada
        ]);
    }

    public function indexViewG()
    {
        return view('estoque.tipoEstoque.categoria');
    }

    public function indexJCat() {

        $tipo_estoque = tipo_estoque::with('estoque')->get();

        return json_encode($tipo_estoque);
    }

    public function verEstoque() {
        $estantes = ['Escritório', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        $tipo_estoque = tipo_estoque::with('estoque')->get();

        return view('estoque.estoque', [
            'estantes' => $estantes,
            'grupos' => $tipo_estoque
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

    //Gerar PDF
    public function gerarPDF()
    {
        return \PDF::loadView('estoque.pdf.PDFEstoqueB', [
            'estoque' => Estoque_geral::with('fornecedores')->get(),
        ])->setPaper('a4', 'landscape')
                    ->stream('nome-arquivo-pdf-gerado.pdf');
    }

    public function index()
    {
        $estoque = Estoque_geral::with(['fornecedores', 'estoque'])->get();
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

    public function createOutros() {
        $estantes = ['Escritório', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        $categoria = tipo_estoque::all();
        return view('estoque.tipoEstoque.estoqueOutros', [
            'estantes' => $estantes,
            'categorias' => $categoria
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
                $estoque->cod_item = 'CHA' . $cod[0]. '_' . str_pad('1', 4, '0', STR_PAD_LEFT);
            } else {
                $estoque->cod_item = 'CHA' . $cod[0]. '_' . str_pad($ult_id->id+1, 4, '0', STR_PAD_LEFT);
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
                $estoque->cod_item = 'INF' . $cod[0]. '_' . str_pad('1', 4, '0', STR_PAD_LEFT);
            } else {
                $estoque->cod_item = 'INF' . $cod[0]. '_' . str_pad($ult_id->id+1, 4, '0', STR_PAD_LEFT);
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
                $estoque->cod_item = 'GER' . $cod[0]. '_' . str_pad('1', 4, '0', STR_PAD_LEFT);
            } else {
                $estoque->cod_item = 'GER' . $cod[0]. '_' . str_pad($ult_id->id+1, 4, '0', STR_PAD_LEFT);
            }
            
            $estoque->un_medida = $request->input('unidade');
            $estoque->qtd = $request->input('qtd');
            $estoque->estoque_min = $request->input('min');
            $estoque->estoque_max = $request->input('ideal');
            $estoque->preco = $request->input('preco');
            $estoque->ean_item = $request->input('ean_item');
            $estoque->ncm_item = $request->input('ncm');
            $estoque->estante = $request->input('estante');
        } else if($tipo_estoque == '4') {
            $estoque->descricao = strtoupper($request->input('nome'));
            if($ult_id === null) {
                $estoque->cod_item = 'TEX' . $cod[0]. '_' . str_pad('1', 4, '0', STR_PAD_LEFT);
            } else {
                $estoque->cod_item = 'TEX' . $cod[0]. '_' . str_pad($ult_id->id+1, 4, '0', STR_PAD_LEFT);
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
            
        } else if($tipo_estoque == '5') {
            $estoque->descricao = strtoupper($request->input('nome'));

            $categoria = tipo_estoque::find($request->input('categoria'));

            $cat = str_split($categoria->descricao, 3);
            //return $cat;

            if($ult_id === null) {
                $estoque->cod_item = strtoupper($cat[0]) . $cod[0]. '_' . str_pad('1', 4, '0', STR_PAD_LEFT);
            } else {
                $estoque->cod_item = strtoupper($cat[0]) . $cod[0]. '_' . str_pad($ult_id->id+1, 4, '0', STR_PAD_LEFT);
            }
            
            $estoque->un_medida = $request->input('unidade');
            $estoque->qtd = $request->input('qtd');
            $estoque->estoque_min = $request->input('min');
            $estoque->estoque_max = $request->input('ideal');
            $estoque->preco = $request->input('preco');
            $estoque->ean_item = $request->input('ean_item');
            $estoque->ncm_item = $request->input('ncm');
            $estoque->estante = $request->input('estante');
        }
        $estoque->save();

        $relEstoque = Estoque_geral::all()->last();
        $relEstoque->fornecedores()->attach($fornecedor_id, ['tipo_estoque_id' => $request->input('categoria')]);

        return json_encode($estoque);
    }

    public function grupo(Request $request) {
        $categoria = new tipo_estoque();

        $categoria->descricao = strtoupper($request->input('grupo'));
        $categoria->nota = $request->input('nota');

        $categoria->save();

        return json_encode($categoria);
    }

    public function grupoA(Request $request, $id) {
        $categoria = tipo_estoque::find($id);

        $categoria->descricao = strtoupper($request->input('grupo'));
        $categoria->nota = $request->input('nota');

        $categoria->save();

        return json_encode($categoria);
    }

    public function entrada(Request $request) {
        $opcao = $request->input('xml');

        if($opcao == 1) {
            return view('estoque.entrada_saida.entrada');
        } else if($opcao == 2) {
            $file = $request->file('upFile');

            $xml = simplexml_load_file($file);

            //return $convert;

            foreach ($xml->NFe as $emit) {
                if(isset($emit->infNFe)) {
                    $cnpj = (string)$emit->infNFe->emit->CNPJ;

                    $consultarFornecedor = Fornecedor::where('cnpj', trim($cnpj))->get();

                    if(count($consultarFornecedor) == 0) {
                        echo 'Fornecedor não encontrado';
                    } else {
                        for($i = 0; $i < 1000; $i++) {
                            if(!empty($emit->infNFe->det[$i]->prod->cProd)) {
                                echo $emit->infNFe->det[$i]->prod->cEAN.'<br>';
                            }
                            
                        }
                    }
                    
                }
                
                
            }


        }
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
