<?php

namespace App\Http\Controllers;

use App\Models\EntradaSaida;
use Illuminate\Http\Request;
use App\Models\PedidoEstoque;
use App\Models\Estoque_geral;
use App\Models\Fornecedor;
use App\Models\PedidoItem;
use Illuminate\Support\Facades\Mail;

class ControladorPedidoEstoque extends Controller
{
    public function index() {
        $pedido = PedidoEstoque::where([
            'status' => 'RE'
        ])->get();

        return view('estoque.pedido.index', [
            'pedidos' => $pedido
        ]);
    }

    public function indexApi($id) {
        $pedidoEstoque = PedidoItem::with('pedido_item_estoque')
                        ->where(['estoque_geral_id' => $id, 'status' => 'RE'])->get();

        if(count($pedidoEstoque) == 0){
            return 0;
        } else {
            return 1;
        }
    }

    public function indexApi2() {
        $pedidoEstoque = PedidoItem::with('pedido_item_estoque')
                        ->where('status' , 'RE')
                        ->select('id', 'pedido_estoque_id', 'estoque_geral_id', 'qtd', 'valor', 'status')->get();

        return json_encode($pedidoEstoque);
    }

    public function enviarPedido($id) {
        $pedido = new PedidoEstoque();
        
        $consultaFornecedor = $pedido->consultaFornecedor($id);

        return json_encode($consultaFornecedor);
    }

    public function enviarEmail(Request $request) {
        $itens_pedido = PedidoItem::with('pedido_item_estoque')->where('pedido_estoque_id', $request->input('pedido_id2'))->get();
        $dados = [
            ['assunto' => $request->input('assunto')],
            ['obs' => $request->input('observacao')],
            'itens_pedido' => $itens_pedido,
            'id' => $request->input('pedido_id2')
        ];

        $email = $request->input('email2');
        $cc = 'sistema@inkasa.ind.br';
        $assunto = $request->input('assunto');

        Mail::send('email.emailPedido', ['dados' => $dados], function ($message) use ($email, $cc, $assunto) {
            $message->from('andrejunior179@gmail.com', 'André Junior');
            $message->to($email);
            $message->cc($cc);
            $message->subject($assunto);
        });

        foreach ($itens_pedido as $item) {
            $item->status = 'EN';
            $item->save();
        }

        $pedidoEstoque = PedidoEstoque::find($request->input('pedido_id2'));
        $pedidoEstoque->status = 'EN';
        $pedidoEstoque->save();

        return redirect()->route('carrinhoPedido')->with('resul', 'E-mail enviado com sucesso');
        //return $dados;
    }

    public function addPedido(Request $request) {
        
        $estoque_geral_id = $request->input('estoque_geral_id');

        $estoque = Estoque_geral::find($estoque_geral_id);

        if(empty($estoque->id)) {
            return redirect()->route('verEstoqueBaixo')->with('resul', 'Item Não Encontrado');
        }

        $fornecedor_id = $request->input('fornecedor_id');
        
        $consulta_id = new PedidoEstoque();
        
        $pedido_id = $consulta_id->consultaId([
            'fornecedor_id' => $fornecedor_id,
            'status' => 'RE'
        ]);

        if(empty($pedido_id)) {
            $pedido_novo = new PedidoEstoque();
            $pedido_novo->fornecedor_id = $fornecedor_id;
            $pedido_novo->status = 'RE';
            $pedido_novo->save();

            $pedido_id = $pedido_novo->id;
        }
        
        $item_pedido = PedidoItem::where(['estoque_geral_id' => $estoque_geral_id, 'status' => 'RE'])->get();

        if(empty($item_pedido)) {
            return redirect()->route('verEstoqueBaixo')->with('resul', 'Item já esta na lista');
        } 

        $pedido_itens = new PedidoItem();
        $pedido_itens->pedido_estoque_id = $pedido_id;
        $pedido_itens->estoque_geral_id = $estoque_geral_id;
        $pedido_itens->qtd = $request->input('qtd');
        $pedido_itens->valor = $estoque->preco;
        $pedido_itens->status = 'RE';
        $pedido_itens->save();

        return json_encode($pedido_itens);
        
    }

    public function addTudoFornecedor(Request $request) {
        //return redirect()->route('carrinhoPedido')->with('resul', 'Itens Adicionados');
        $id = $request->input('fornecedor_id');
        $itensFornecedor = Fornecedor::with('estoque')->where('id', $id)->get();

        //$itens_existentes = new PedidoItem();

        foreach ($itensFornecedor as $itens) {
           foreach ($itens->estoque as $item) {
            $pedidoEstoque = PedidoItem::with('pedido_item_estoque')
                        ->where(['estoque_geral_id' => $item->id, 'status' => null])->get();

               if(count($pedidoEstoque) === 0) {
                    if($item->qtd <= 1) {
                        $consulta_id = new PedidoEstoque();

                        $pedido_id = $consulta_id->consultaId([
                            'fornecedor_id' => $id,
                            'status' => 'RE'
                        ]);

                        if(empty($pedido_id)) {
                            $pedido_novo = new PedidoEstoque();
                            $pedido_novo->fornecedor_id = $id;
                            $pedido_novo->status = 'RE';
                            $pedido_novo->save();

                            $pedido_id = $pedido_novo->id;
                        }

                        $pedido_itens = new PedidoItem();
                        $pedido_itens->pedido_estoque_id = $pedido_id;
                        $pedido_itens->estoque_geral_id = $item->id;
                        $pedido_itens->qtd = $item->estoque_min;
                        $pedido_itens->valor = $item->preco;
                        $pedido_itens->status = 'RE';
                        $pedido_itens->save();
                    }
               }
           }
        }

        return redirect()->route('carrinhoPedido')->with('resul', 'Itens Adicionados');
    }

    public function addItem(Request $request) {
        $estoque_geral_id = $request->input('item_id');
        $qtdAdd = $request->input('quantidade0');

        $qtd = 0;
        $item = PedidoItem::find($estoque_geral_id);
        $qtd = $item->qtd;

        $item->qtd = $qtd + $qtdAdd;
        $item->save();

        return redirect()->back()->with('ativo', $item->pedido_estoque_id);
    }

    public function dimItem(Request $request) {
        $estoque_geral_id = $request->input('item_id');
        $qtdRem = $request->input('quantidade0');

        $qtd = 0;
        $item = PedidoItem::find($estoque_geral_id);
        $qtd = $item->qtd;

        $item->qtd = $qtd - $qtdRem;
        $item->save();

        return redirect()->back()->with('ativo', $item->pedido_estoque_id);
    }

    public function deletarItem(Request $request) {
        $pedido_id = $request->input('pedido_id');
        $estoque_geral_id = $request->input('estoque_geral_id');
        $remover_apenas_item = (boolean)$request->input('item');
        $fornecedor_id = $request->input('fornecedor_id');

        $consulta_id = new PedidoEstoque();
        
        $pedido_id = $consulta_id->consultaId([
            'id' => $pedido_id,
            'fornecedor_id' => $fornecedor_id,
            'status' => 'RE'
        ]);

        if(empty($pedido_id)) {
            return redirect()->back()->with(['resul' => 'Item não encontrado', 'ativo' => $pedido_id]);
        }

        $where_item = [
            'pedido_estoque_id' => $pedido_id,
            'estoque_geral_id' => $estoque_geral_id 
        ];

        $item = PedidoItem::where($where_item)->orderBy('id', 'desc')->first();
        if(empty($item->id)) {
            return redirect()->back()->with(['resul' => 'Item não encontrado', 'ativo' => $pedido_id]);
        }

        if($remover_apenas_item) {
            $where_item['id'] = $item->id;
        }
        PedidoItem::where($where_item)->delete();

        $check_pedido = PedidoItem::where([
            'pedido_estoque_id' => $item->pedido_estoque_id
        ])->exists();

        if(!$check_pedido) {
            PedidoEstoque::where([
                'id' => $item->pedido_estoque_id
            ])->delete();
    
        }
        return redirect()->back()->with(['resul' => 'Item não encontrado', 'ativo' => $pedido_id]);
    }

    public function estoqueFornecedor($id) {
        $estoqueFor = Fornecedor::with('estoqueFilter')->where('id', $id)
        ->select('id', 'nome')->get();
        
        //return json_encode($estoqueFor);
        return view('estoque.ver.estoqueFornecedor', [
            'estoque' => $estoqueFor
        ]);
    }

    //estados dos pedidos
    public function pedidosEstoqueEN() {
        $pedido = PedidoEstoque::with('pedido_item')->where([
            'status' => 'EN'
        ])->get();

        //return $pedido;

        return view('estoque.pedido.enviados', [
            'pedidos' => $pedido
        ]);
    }

    public function pedidosEstoqueCP() {
        $pedido = PedidoEstoque::with('pedido_item')->where([
            'status' => 'CP'
        ])->get();

        //return json_encode($pedido);
        return view('estoque.pedido.autorizados', [
            'pedidos' => $pedido
        ]);
    }

    public function pedidosEstoqueFP() {
        $pedido = PedidoEstoque::with('pedido_item')->where([
            'status' => 'FP'
        ])->get();

        return view('estoque.pedido.finalizados', [
            'pedidos' => $pedido
        ]);
    }

    public function pedidosEstoqueCpId(Request $request) {
        $pedido_id = $request->input('pedido_id');

        $pedido = PedidoEstoque::find($pedido_id);

        if(isset($pedido_id)) {
            $pedidoItem = PedidoItem::where('pedido_estoque_id', $pedido_id)->get();

            foreach($pedidoItem as $item) {
                $item->status = 'CP';
                $item->save();
            }

            $arquivo = $request->file('upFile');

            if(!empty($arquivo)) {
                $path = $request->file('upFile')->store('anexos', 'public');
                $pedido->anexo = $path;
            }
            
            $pedido->status = 'CP';
            $pedido->save();

            return redirect()->route('pedidosEstoqueEN')->with('resul' ,'Pedido Autorizado');
        }

        return redirect()->route('pedidosEstoqueEN')->with('resul', 'Falha ao autorizar');
    }

    public function pedidosEstoqueAtId(Request $request) {
        $item = PedidoItem::find($request->input('item_id'));

        if(isset($item)) {
            $estoque = Estoque_geral::find($item->estoque_geral_id);
            $estoque->preco = $request->input('valor');
            $estoque->save();

            $pedido_id = $request->input('pedido_id');

            $item->valor = $request->input('valor');
            $item->save();

            return redirect()->back()->with(['resul' => 'Valor Alterado', 'ativo' => $pedido_id]);
        }

        return redirect()->back()->with('resul', 'Falha ao alterar o preço');
    }

    public function pedidosEstoqueFpId(Request $request) {
        $pedido_id = $request->input('pedido_id');

        $pedido = PedidoEstoque::find($pedido_id);
        
        if(isset($pedido)) {
            $arquivo = $request->file('upFile');

            if(!empty($arquivo)) {
                $path = $request->file('upFile')->store('anexos', 'public');
                $pedido->nota_fiscal = $path;
            }

            $pedido->status = 'FP';
            $pedido->save();

            $pedidoItem = PedidoItem::where('pedido_estoque_id', $pedido_id)->get();

            foreach ($pedidoItem as $item) {
                $item->status = 'FP';
                $item->save();
            }

            return redirect()->back()->with('resul' ,'Pedido Finalizado, aguardando chegada');
        }

        return redirect()->back()->with('resul', 'Falha ao finalizar pedido');
    }

    public function pedidosEstoqueOK(Request $request) {
        $pedido_id = $request->input('pedido_id');

        $pedido = PedidoEstoque::find($pedido_id);

        if(isset($pedido)) {
            $pedidoItem = PedidoItem::where('pedido_estoque_id', $pedido_id)->get();
            
            if(isset($pedidoItem)) {
                foreach($pedidoItem as $item) {
                    $item->status = 'OK';
                    $item->save();
                    //$entrada->entrada_saida()
                    $entrada = new EntradaSaida();
                    
                    $entrada->estoque_geral_id = $item->estoque_geral_id;
                    $entrada->fornecedor_id = $pedido->fornecedor_id;
                    $entrada->qtd = $item->qtd;
                    $entrada->situacao = '1';
                    $entrada->save();
    
                    $estoque = Estoque_geral::find($item->estoque_geral_id);
                    $estoque->qtd = $estoque->qtd + $item->qtd;
                    $estoque->save();
                }
            }
            //return json_encode($entrada);
            $pedido->status = 'OK';
            $pedido->save();

            return redirect()->back()->with('resul' ,'Baixa ok'); 
        }

        return redirect()->back()->with('resul' ,'Ops Falhou'); 
    }

    public function destroy($id) {
        $pedido = PedidoEstoque::find($id);
        if(isset($pedido)) {
            $pedidoItem = PedidoItem::where('pedido_estoque_id', $id)->get();

            foreach ($pedidoItem as $item) {
                $item->delete();
            }

            $pedido->delete();
            
            return redirect()->back()
                    ->with('resul', 'Pedido Excluido');
        }

        return redirect()->back()
                    ->with('resul', 'Pedido não Encontrado');

    }
}
