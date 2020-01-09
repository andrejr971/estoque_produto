<?php

namespace App\Http\Controllers;


use App\Models\CategoriaProduto;
use App\Models\Estoque_geral;
use App\Models\EstoqueProduto;
use App\Models\Fornecedor;
use App\Models\GrupoProduto;
use App\Models\MedidaProduto;
use App\Models\Produto;
use Illuminate\Http\Request;
use \App\Models\TipoProduto;

class ProdutosControle extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtos = [];
        return view('produtos.index', [
            'produtos' => $produtos,
            'tipo_produtos' => TipoProduto::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function criarFornecido() {
        $categorias = GrupoProduto::with('categoria')->get();

        //return $categorias;
        return view('produtos.criarFornecido', [
            'categorias' => $categorias
        ]);
    }

    /**busca no estoque */

    public function buscaProd(Request $request) {

        $pos = stripos($request->input('produto'), '-');

        $un_medida = $request->input('un_medida');

        if($pos === false) {
            $estoque = Estoque_geral::where('descricao', $request->input('produto'))
                        ->where('un_medida', $un_medida)
                        ->select('id', 'descricao', 'cod_prod')
                        ->get();

        } else {
            $produto = explode('-', $request->input('produto'));

            if($un_medida == 'M2') {
                $select = ['id', 'descricao', 'cod_prod', 'largura', 'altura', 'preco'];
            } else if($un_medida == 'M3') {
                $select = ['id', 'descricao', 'cod_prod', 'largura', 'altura', 'profundidade', 'preco'];
            } else if($un_medida == 'MTL') {
                $select = ['id', 'descricao', 'cod_prod', 'metragem', 'preco'];
            } else if($un_medida == 'LT') {
                $select = ['id', 'descricao', 'cod_prod', 'preco', 'qtd', 'vol'];
            } else {
                $select = ['id', 'descricao', 'cod_prod', 'preco', 'qtd', 'vol'];
            }

            $cod_prod = trim($produto[0]);
            //$descricao = trim($produto[1]);

            $estoque = Estoque_geral::with('fornecedores')->where('cod_item', $cod_prod)
                        ->where('un_medida', $un_medida)
                        ->select($select)
                        ->get();
        }

        return $estoque;
    }

    public function busca($unidade) {
        $estoque = Estoque_geral::where('un_medida', $unidade)
                    ->select('id', 'descricao', 'cod_prod', 'cod_item')
                    ->get();

        return $estoque;
    }

    public function buscaMaterialProd($id) {
        $consultaMaterial = EstoqueProduto::where('produto_id', $id)
                        ->select('id', 'produto_id', 'estoque_geral_id', 'nome', 'descricao', 'qtdItem', 'preco')
                        ->paginate(10);

        return $consultaMaterial;
    }

    public function buscaValor($id) {
        $consultaMaterial = EstoqueProduto::where('produto_id', $id)
                        ->select('preco')->get();

        return $consultaMaterial->sum('preco');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nome = $request->input('nome');
        $sku = $request->input('sku');
        $qtd = $request->input('qtd');
        $categoria = $request->input('categoria');
        $path = $request->file('imagem')->store('imagens', 'public');
        $largura = $request->input('largura');
        $altura = $request->input('altura');
        $profundidade = $request->input('profundidade');
        $obs = $request->input('obs');

        $produto = new Produto();
        $produto->descricao = $nome;
        $produto->sku = $sku;
        $produto->quantidade = $qtd;
        $produto->img01 = $path;
        $produto->categoria_produto_id = $categoria;
        $produto->tipo_produto_id = 1;
        $produto->observacao = $obs;
        // $produto->save();

        $produtos = Produto::all()->last();

        $produto_id = $produtos->id;

        $medida = new MedidaProduto();
        $medida->largura = $largura;
        $medida->altura = $altura;
        $medida->profundidade = $profundidade;
        $medida->produto_id = $produto_id;
        // $medida->save();

        $categorias = GrupoProduto::with('categoria')->get();

        return view('produtos.editarFornecido', [
            'resposta' => '1',
            'categorias' => $categorias,
            'produto' => Produto::with('medidas')->get()->last(),
            'fornecedores' => Fornecedor::all()
        ]);

    }

    public function estoqueProduto(Request $request) {
        $descricao = $request->input('descricao2');
        $produto_id = $request->input('produto_id');
        $nome = $request->input('nome');
        $un_medida = $request->input('un_medida');
        $altura = $request->input('altura2')/1000;
        $largura = $request->input('largura2')/1000;
        $preco = $request->input('preco2');
        $qtd = $request->input('qtd2');
        $fornecedor = $request->input('fornecedor');

        $larguraProd = $request->input('largura1');
        $alturaProd = $request->input('altura1');
        $profundidadeProd = $request->input('profundidadeProd');

        $verificarLargura = stripos($larguraProd, ',');
        $verificarAltura = stripos($alturaProd, ',');

        if($verificarLargura === false) {
            $larguraProd = $larguraProd;
        } else {
            $larguraProd = str_replace(',', '.', $larguraProd);
        }

        if($verificarAltura === false) {
            $alturaProd = $alturaProd;
        } else {
            $alturaProd = str_replace(',', '.', $alturaProd);
        }

        $qtdUsada = 0;


        if($un_medida == 'M2') {
            $larguraQuadrada = floor($largura / $larguraProd);

            $alturaQuadrada = floor($altura / $alturaProd);

            $area = $alturaQuadrada * $larguraQuadrada;

            $qtdUsada = ceil($qtd / $area);
        }


        $consultaEstoque = Estoque_geral::where('descricao', $descricao)
                            ->where('un_medida', $un_medida)
                            ->get();

        $estoque_produto = new EstoqueProduto();

        $estoque_produto->produto_id = $produto_id;

        $fornecedores = Fornecedor::where('nome', $fornecedor)
                        ->select('id', 'nome')
                        ->get();

        if(count($fornecedores) > 0) {
            foreach ($fornecedores as $f) {
                $estoque_produto->fornecedor_id = $f->id;
                $estoque_produto->fornecedor = $f->nome;
            }
        } else {
            $estoque_produto->fornecedor_id = null;
            $estoque_produto->fornecedor = $fornecedor;
        }

        $estoque_produto->altura = $alturaProd;
        $estoque_produto->largura = $larguraProd;
        $estoque_produto->profundidade = $profundidadeProd;
        $estoque_produto->un_medida = $un_medida;

        $estoque_produto->qtdItem = $qtd;
        $estoque_produto->qtd = $qtdUsada;
        $estoque_produto->preco = number_format(($alturaProd * $larguraProd * $qtd * $preco), '2', '.', '');
        $estoque_produto->nome = $nome;

        if(count($consultaEstoque) == 0) {
            $estoque_produto->descricao = $descricao;
            $estoque_produto->estoque = 0;
            $estoque_produto->alturaMaterial = $altura;
            $estoque_produto->larguraMaterial = $largura;
        } else {
            foreach ($consultaEstoque as $valor) {
                $estoque_produto->estoque_geral_id = $valor->id;
                $estoque_produto->descricao = $valor->descricao;
                $estoque_produto->alturaMaterial = $valor->altura;
                $estoque_produto->larguraMaterial = $valor->largura;
            }
            $estoque_produto->estoque = 1;
        }

        $estoque_produto->save();

        return $estoque_produto;

    }

    public function estoqueProdutoM3(Request $request) {
        $descricao = $request->input('descricao_m3');
        $produto_id = $request->input('produto_id');
        $nome = $request->input('nome');
        $un_medida = $request->input('un_medida');
        $altura = $request->input('altura_m3');
        $largura = $request->input('largura_m3');
        $profundidade = $request->input('profundidade_m3');
        $preco = $request->input('pre_m3');
        $qtd = $request->input('qtd_m3');
        $fornecedor = $request->input('fornecedor');

        $larguraProd = $request->input('larg_m3')/1000;
        $alturaProd = $request->input('alt_m3')/1000;
        $profundidadeProd = $request->input('prof_m3')/1000;

        $verificarLargura = stripos($largura, ',');
        $verificarAltura = stripos($altura, ',');
        $verificarProf = stripos($profundidade, ',');

        if($verificarLargura === false) {
            $largura = $largura;
        } else {
            $largura = str_replace(',', '.', $largura);
        }

        if($verificarAltura === false) {
            $altura = $altura;
        } else {
            $altura = str_replace(',', '.', $altura);
        }

        if($verificarProf === false) {
            $profundidade = $profundidade;
        } else {
            $profundidade = str_replace(',', '.', $profundidade);
        }

        $qtdUsada = 0;

        $area = $largura * $altura * $profundidade;

        $area_total = $area * $qtd;

        $consultaEstoque = Estoque_geral::where('descricao', $descricao)
                            ->where('un_medida', $un_medida)
                            ->get();

        $estoque_produto = new EstoqueProduto();

        $estoque_produto->produto_id = $produto_id;

        $fornecedores = Fornecedor::where('nome', $fornecedor)
                        ->select('id', 'nome')
                        ->get();

        if(count($fornecedores) > 0) {
            foreach ($fornecedores as $f) {
                $estoque_produto->fornecedor_id = $f->id;
                $estoque_produto->fornecedor = $f->nome;
            }
        } else {
            $estoque_produto->fornecedor_id = null;
            $estoque_produto->fornecedor = $fornecedor;
        }

        $estoque_produto->altura = $altura;
        $estoque_produto->largura = $largura;
        $estoque_produto->profundidade = $profundidade;
        $estoque_produto->un_medida = $un_medida;

        $estoque_produto->qtdItem = $qtd;
        $estoque_produto->preco = number_format(($area_total * $preco), '2', '.', '');
        $estoque_produto->nome = $nome;

        if(count($consultaEstoque) == 0) {
            $estoque_produto->descricao = $descricao;
            $estoque_produto->estoque = 0;
            $estoque_produto->alturaMaterial = $alturaProd * 1000;
            $estoque_produto->larguraMaterial = $larguraProd * 1000;
            $estoque_produto->profundidadeMaterial = $profundidadeProd * 1000;
        } else {
            foreach ($consultaEstoque as $valor) {
                $estoque_produto->estoque_geral_id = $valor->id;
                $estoque_produto->descricao = $valor->descricao;
                $estoque_produto->alturaMaterial = $valor->altura;
                $estoque_produto->larguraMaterial = $valor->largura;
                $estoque_produto->profundidadeMaterial = $valor->largura;

                // $total_area = 0;
                // $regra_tres = 0;
                // $quantidade = 0;
                // $quantidade_restante = 0;
                // $quantidade_total = 0;

                // $total_area = $larguraProd * $alturaProd * $profundidadeProd * $valor->qtd;
                // $regra_tres = ($area_total * $valor->qtd) / $total_area;
                // $quantidade = $valor->qtd - $regra_tres;

                // $quantidade_restante = round($quantidade) - $quantidade;

                // $quantidade_total = round($quantidade - $quantidade_restante, 2);
            }
            $estoque_produto->estoque = 1;
        }

        $estoque_produto->qtd = $area_total;

        $estoque_produto->save();

        return $estoque_produto;

    }

    public function estoqueProdutoMTL(Request $request) {
        $descricao = $request->input('descricao_mtl');
        $produto_id = $request->input('produto_id');
        $nome = $request->input('nome');
        $un_medida = $request->input('un_medida');
        $preco = $request->input('pre_mtl');
        $fornecedor = $request->input('fornecedor');

        $metragem = $request->input('metragem');
        $met_mtl = $request->input('met_mtl')/1000;


        $verificarMtl = stripos($metragem, ',');

        if($verificarMtl === false) {
            $metragem = $metragem;
        } else {
            $metragem = str_replace(',', '.', $metragem);
        }


        // return $metragem * $preco;

        $consultaEstoque = Estoque_geral::where('descricao', $descricao)
                            ->where('un_medida', $un_medida)
                            ->get();

        $estoque_produto = new EstoqueProduto();

        $estoque_produto->produto_id = $produto_id;

        $fornecedores = Fornecedor::where('nome', $fornecedor)
                        ->select('id', 'nome')
                        ->get();

        if(count($fornecedores) > 0) {
            foreach ($fornecedores as $f) {
                $estoque_produto->fornecedor_id = $f->id;
                $estoque_produto->fornecedor = $f->nome;
            }
        } else {
            $estoque_produto->fornecedor_id = null;
            $estoque_produto->fornecedor = $fornecedor;
        }

        $estoque_produto->un_medida = $un_medida;

        $estoque_produto->qtdItem = $metragem;
        $estoque_produto->preco = number_format(($metragem * $preco), '2', '.', '');
        $estoque_produto->nome = $nome;

        if(count($consultaEstoque) == 0) {
            $estoque_produto->descricao = $descricao;
            $estoque_produto->estoque = 0;
            $estoque_produto->larguraMaterial = $met_mtl;
        } else {
            foreach ($consultaEstoque as $valor) {
                $estoque_produto->estoque_geral_id = $valor->id;
                $estoque_produto->descricao = $valor->descricao;
                $estoque_produto->larguraMaterial = $valor->metragem;
            }
            $estoque_produto->estoque = 1;
        }

        $estoque_produto->qtd = $metragem;

        $estoque_produto->save();

        return $estoque_produto;

    }

    public function estoqueProdutoUN(Request $request) {
        $descricao = $request->input('descricao_un');
        $produto_id = $request->input('produto_id');
        $nome = $request->input('nome');
        $un_medida = $request->input('un_medida');
        $preco = $request->input('pre_un');
        $fornecedor = $request->input('fornecedor');

        $tipo = $request->input('tipo');
        $qtd = $request->input('qtd');

        if($tipo == 3) {
            $preco = $preco/1000 * $qtd;
        } else {
            $preco = $preco * $qtd;
        }

        $consultaEstoque = Estoque_geral::where('descricao', $descricao)
                            ->where('un_medida', $un_medida)
                            ->get();

        $estoque_produto = new EstoqueProduto();

        $estoque_produto->produto_id = $produto_id;

        $fornecedores = Fornecedor::where('nome', $fornecedor)
                        ->select('id', 'nome')
                        ->get();

        if(count($fornecedores) > 0) {
            foreach ($fornecedores as $f) {
                $estoque_produto->fornecedor_id = $f->id;
                $estoque_produto->fornecedor = $f->nome;
            }
        } else {
            $estoque_produto->fornecedor_id = null;
            $estoque_produto->fornecedor = $fornecedor;
        }

        $estoque_produto->un_medida = $un_medida;

        $estoque_produto->qtdItem = $qtd;
        $estoque_produto->preco = number_format($preco, '2', '.', '');
        $estoque_produto->nome = $nome;

        if(count($consultaEstoque) == 0) {
            $estoque_produto->descricao = $descricao;
            $estoque_produto->estoque = 0;
        } else {
            foreach ($consultaEstoque as $valor) {
                $estoque_produto->estoque_geral_id = $valor->id;
                $estoque_produto->descricao = $valor->descricao;
            }
            $estoque_produto->estoque = 1;
        }

        $estoque_produto->qtd = $qtd;

        $estoque_produto->save();

        return $estoque_produto;

    }

    public function estoqueProdutoKG(Request $request) {
        $descricao = $request->input('descricao_kg');
        $produto_id = $request->input('produto_id');
        $nome = $request->input('nome');
        $un_medida = $request->input('un_medida');
        $preco = $request->input('pre_kg');
        $fornecedor = $request->input('fornecedor');

        $volume = $request->input('volume');
        $qtd = $request->input('qtd');

        $verrificarQtd = stripos($qtd, ',');

        if($verrificarQtd === false) {
            $qtd = $qtd;
        } else {
            $qtd = str_replace(',', '.', $qtd);
        }

        // return round($preco / $volume * $qtd, 2);

        $consultaEstoque = Estoque_geral::where('descricao', $descricao)
                            ->where('un_medida', $un_medida)
                            ->get();

        $estoque_produto = new EstoqueProduto();

        $estoque_produto->produto_id = $produto_id;

        $fornecedores = Fornecedor::where('nome', $fornecedor)
                        ->select('id', 'nome')
                        ->get();

        if(count($fornecedores) > 0) {
            foreach ($fornecedores as $f) {
                $estoque_produto->fornecedor_id = $f->id;
                $estoque_produto->fornecedor = $f->nome;
            }
        } else {
            $estoque_produto->fornecedor_id = null;
            $estoque_produto->fornecedor = $fornecedor;
        }

        $estoque_produto->un_medida = $un_medida;

        $estoque_produto->qtdItem = $qtd;
        $estoque_produto->preco = round($preco / $volume * $qtd, 2);
        $estoque_produto->nome = $nome;

        if(count($consultaEstoque) == 0) {
            $estoque_produto->descricao = $descricao;
            $estoque_produto->estoque = 0;
        } else {
            foreach ($consultaEstoque as $valor) {
                $estoque_produto->estoque_geral_id = $valor->id;
                $estoque_produto->descricao = $valor->descricao;
            }
            $estoque_produto->estoque = 1;
        }

        $estoque_produto->qtd = $qtd;

        $estoque_produto->save();

        return $estoque_produto;

    }

    public function estoqueProdutoLT(Request $request) {
        $descricao = $request->input('descricao_kg');
        $produto_id = $request->input('produto_id');
        $nome = $request->input('nome');
        $un_medida = $request->input('un_medida');
        $preco = $request->input('pre_kg');
        $fornecedor = $request->input('fornecedor');

        $volume = $request->input('volume');
        $qtd = $request->input('qtd');

        $verrificarQtd = stripos($qtd, ',');

        if($verrificarQtd === false) {
            $qtd = $qtd;
        } else {
            $qtd = str_replace(',', '.', $qtd);
        }

        $preco = number_format($preco / $volume * $qtd, 2, '.', '');

        $consultaEstoque = Estoque_geral::where('descricao', $descricao)
                            ->where('un_medida', $un_medida)
                            ->get();

        $estoque_produto = new EstoqueProduto();

        $estoque_produto->produto_id = $produto_id;

        $fornecedores = Fornecedor::where('nome', $fornecedor)
                        ->select('id', 'nome')
                        ->get();

        if(count($fornecedores) > 0) {
            foreach ($fornecedores as $f) {
                $estoque_produto->fornecedor_id = $f->id;
                $estoque_produto->fornecedor = $f->nome;
            }
        } else {
            $estoque_produto->fornecedor_id = null;
            $estoque_produto->fornecedor = $fornecedor;
        }

        $estoque_produto->un_medida = $un_medida;

        $estoque_produto->qtdItem = $qtd;
        $estoque_produto->preco = $preco;
        $estoque_produto->nome = $nome;

        if(count($consultaEstoque) == 0) {
            $estoque_produto->descricao = $descricao;
            $estoque_produto->estoque = 0;
        } else {
            foreach ($consultaEstoque as $valor) {
                $estoque_produto->estoque_geral_id = $valor->id;
                $estoque_produto->descricao = $valor->descricao;
            }
            $estoque_produto->estoque = 1;
        }

        $estoque_produto->qtd = $qtd;

        $estoque_produto->save();

        return $estoque_produto;

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
        return EstoqueProduto::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // qtd : $('#qtdE').val(),
        // nome : $('#nomeE').val(),
        // largura : $('#larguraE').val(),
        // altura : $('#alturaE').val(),
        // desc : $('#descricaoE').val(),
        // larguraM : $('#larguraMaterialE').val(),
        // alturaM : $('#alturaMaterialE').val(),
        // preco : $('#precoE').val()

        $descricao = $request->input('desc');
        $nome = $request->input('nome');
        $qtd = $request->input('un_medida');
        $altura = $request->input('altura2')/1000;
        $largura = $request->input('largura2')/1000;
        $preco = $request->input('preco');
        $qtd = $request->input('qtd2');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produto = EstoqueProduto::find($id);

        $produto->delete();

        return EstoqueProduto::all();
    }
}
