const elementoTable = document.querySelector('#tableFornecedor tbody');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//limpa os campos
function limparCampos() {
    $('#nome').val('');
    $('#cnpj').val('');
    $('#telefone').val('');
    $('#email').val('');
    $('#inscricao').val('');
    $('#numero').val('');
    $('#cep').val('');
    $('#endereco').val('');
    $('#bairro').val('');
    $('#cidade').val('');
    $('#id').val('');

}
axios.get('https://servicodados.ibge.gov.br/api/v1/localidades/estados')
    .then(function(response) {
        carregarUf(response.data);
    })
    .catch(function(erro) {
        console.log(erro);
    });

function renderTabela(dados) {
    elementoTable.innerHTML = '';

    for(dado of dados) {
        var trElemento = document.createElement('tr');
        var tdElemento1 = document.createElement('td');
        var tdElemento2 = document.createElement('td');
        var tdElemento3 = document.createElement('td');
        var tdElemento4 = document.createElement('td');

        var texto1 = document.createTextNode(dado.nome);
        var texto2 = document.createTextNode(dado.cnpj);
        var texto3_1 = document.createTextNode(dado.email);
        var texto3_2 = document.createTextNode(' | ');
        var texto3_3 = document.createTextNode(dado.telefone);

        var btnEditar = document.createElement('button');
        var textoBtn1 = document.createTextNode('Editar');
        btnEditar.setAttribute('onclick', 'editar(' + dado.id + ')');
        btnEditar.setAttribute('class', 'btn btn-outline-info');
        btnEditar.appendChild(textoBtn1);

        var btnRemover = document.createElement('button');
        var textoBtn2 = document.createTextNode('Remover');
        btnRemover.setAttribute('onclick', 'remover(' + dado.id + ')');
        btnRemover.setAttribute('class', 'btn btn-outline-danger ml-2');
        btnRemover.appendChild(textoBtn2);

        //if(dado.estoque.length > 0) {
        var btnItens = document.createElement('button');
        var textoBtn2 = document.createTextNode('Itens');
        btnItens.setAttribute('onclick', 'itens(' + dado.id + ')');
        btnItens.setAttribute('class', 'btn btn-outline-dark ml-2');
        btnItens.appendChild(textoBtn2);
        //}

        tdElemento1.appendChild(texto1);
        tdElemento2.appendChild(texto2);
        tdElemento3.appendChild(texto3_1);
        tdElemento3.appendChild(texto3_2);
        tdElemento3.appendChild(texto3_3);
        tdElemento4.appendChild(btnEditar);
        tdElemento4.appendChild(btnRemover);
        tdElemento4.appendChild(btnItens);

        trElemento.appendChild(tdElemento1);
        trElemento.appendChild(tdElemento2);
        trElemento.appendChild(tdElemento3);
        trElemento.appendChild(tdElemento4);

        elementoTable.appendChild(trElemento);
    }
}

function editar(id) {
    axios.get('/api/fornecedor/' + id)
    .then(function(response) {
        edicao(response.data);
    })
    .catch(function(erro) {
        console.log(erro);
    });
}

function edicao(data) {
    $('#id').val(data.id);
    $('#nome').val(data.nome);
    $('#cnpj').val(data.cnpj);
    $('#telefone').val(data.telefone);
    $('#email').val(data.email);
    $('#inscricao').val(data.inscricao);
    $('#cep').val(data.cep);
    $('#endereco').val(data.endereco);
    $('#numero').val(data.numero);
    $('#bairro').val(data.bairro);
    $('#cidade').val(data.cidade);
    $('#uf').val($('option:contains("' + data.uf + '")').val());

    $('#modalFornecedor').modal('show');
}

function itens(id) {
    axios.get('/api/fornecedor')
        .then(function(response) {
            verItens(response.data, id);
        })
        .catch(function(erro) {
            alert(erro);
        });
}

function salvarFornecedor() {
    var fornecedor = {
        id : $('#id').val(),
        nome : $('#nome').val(),
        cnpj : $('#cnpj').val(),
        telefone : $('#telefone').val(),
        email : $('#email').val(),
        inscricao : $('#inscricao').val(),
        cep : $('#cep').val(),
        endereco : $('#endereco').val(),
        numero : $('#numero').val(),
        bairro : $('#bairro').val(),
        cidade : $('#cidade').val(),
        uf : $('#uf').val()
    }

    $.ajax({
        type: 'PUT',
        url: '/api/fornecedor/' + fornecedor.id,
        data : fornecedor,
        context: this,
        success: function(data) {
            carregarFornecedores();
            $('#modalFornecedor').modal('hide');
            alert('Fornecedor Atualizado');
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function remover(id) {
    var estoques = [];

    axios.get('/api/fornecedor')
    .then(function(response) {
        let cont = 0;
        for(dado of response.data) {
            if(dado.id == id) {
                for(item of dado.estoque) {
                    estoques.push(item.id);
                }
            }
            cont ++;
        }

        $.ajax({
            type: 'DELETE',
            url: '/api/fornecedor/' + id,
            context: this,
            success: function() {
                carregarFornecedores();
                alert('Fornecedor Deletado');
            },
            error: function(erro) {
                alert(erro);
            }
        });

    })
    .catch(function(erro) {
        alert(erro);
    });

}

function carregarFornecedores() {
    axios.get('/api/fornecedor')
        .then(function(response) {
            renderTabela(response.data);
        })
        .catch(function(erro) {
            alert(erro);
        });
}

function carregarUf () {
    $.getJSON('https://servicodados.ibge.gov.br/api/v1/localidades/estados', function(dados) {
        for (let i = 0; i < dados.length; i++) {
            opcao = '<option value ="' + dados[i].sigla +'"> ' + dados[i].sigla + '</option>';
            $('#uf').append(opcao);

        }
    });
}

function novoFornecedor() {
    fornecedor = {
        nome : $('#nome').val(),
        cnpj : $('#cnpj').val(),
        telefone : $('#telefone').val(),
        email : $('#email').val(),
        inscricao : $('#inscricao').val(),
        cep : $('#cep').val(),
        endereco : $('#endereco').val(),
        numero : $('#numero').val(),
        bairro : $('#bairro').val(),
        cidade : $('#cidade').val(),
        uf : $('#uf').val()
    }

    $.post('/api/fornecedor', fornecedor, function() {
        carregarFornecedores();

        alert('Fornecedor Cadastrado');
    });

    $('#modalFornecedor').modal('hide');
}

$('#formFornecedor').submit(function(event) {
    event.preventDefault();

    if($('#id').val() != '') {
        salvarFornecedor();
    } else {
        novoFornecedor();
    }
});

$(function() {
    carregarFornecedores();
});


//VER ITENS RELACIONADOS COM O FORNECEDOR
var tabelaItens = document.querySelector('#tableFornecedorItens tbody');

function verItens(dados, id) {
    tabelaItens.innerHTML = '';
    for(dado of dados) {
        if(dado.id == id) {
            for(item of dado.estoque) {
                var trElemento = document.createElement('tr');
                var tdElemento = document.createElement('td');
                var tdElemento1 = document.createElement('td');

                var btnEditar = document.createElement('button');
                var textoBtn1 = document.createTextNode('Ver/Editar');
                btnEditar.setAttribute('onclick', 'ItemSelecionado(' + item.id + ')');
                btnEditar.setAttribute('class', 'btn btn-outline-info');
                btnEditar.appendChild(textoBtn1);

                tdElemento1.appendChild(btnEditar);
                //tdElemento1.appendChild(btnRemover);

                tdElemento = document.createTextNode(item.descricao);
                trElemento.appendChild(tdElemento);
                trElemento.appendChild(tdElemento1);
                trElemento.appendChild(tdElemento1);

                tabelaItens.appendChild(trElemento);
            }
        }

    }

    $('#modalItens').modal('show');
}

function carregarFornecedoresitens(dados, id) {
    selectElement.innerHTML = '';

    for(dado of dados) {
        var optionElement = document.createElement('option');
        var textOption = document.createTextNode(dado.nome);

        optionElement.setAttribute('value', dado.id);
        optionElement.appendChild(textOption);

        selectElement.appendChild(optionElement);

        for(estoque of dado.estoque) {
            if(id === estoque.id) {
                $('#fornecedor').val($('option:contains("' + dado.id + '")').val());
            }
        }
    }
}

//VER ITEM SELECIONADO
var selectElement = document.querySelector('#fornecedor');

function ItemSelecionado(id) {
    axios.get('/api/estoque')
        .then(function(response) {
            editarItemSelecionado(response.data, id);
        })
        .catch(function(erro) {
            alert(erro);
        });

    //$('#modalItens').modal('hide');
    //$('#modalEditar').modal('show');
}

function editarItemSelecionado(dados, id) {
    axios.get('/api/fornecedor')
        .then(function(response) {
            carregarFornecedoresitens(response.data, id);
        })
        .catch(function(erro) {
            alert(erro);
        });

        for(dado of dados) {
            if(dado.id == id) {
                //alert(dado.descricao);
                $('#descricao').val(dado.descricao);
                $('#cod').val(dado.cod_item);
                $('#cod1').val(dado.cod_item);
                $('#estoque_id').val(dado.id);

                if(dado.ean_item == null) {
                    $('#ean').val('');
                    $('#ean').prop('disabled', true);
                } else {
                    $('#ean').prop('disabled', false);
                    $('#ean').val(dado.ean_item);
                }

                $('#qtd').val(dado.qtd);
                $('#min').val(dado.estoque_min);
                $('#ideal').val(dado.estoque_max);
                $('#ncm').val(dado.ncm_item);

                for(fornecedor of dado.fornecedores) {
                    $('#fornecedor_id').val(fornecedor.id);
                    $('#tipo_estoque_id').val(fornecedor.pivot.tipo_estoque_id);
                }
                $('#unidade').val($('option:contains("' + dado.un_medida + '")').val());

                if(dado.estante == null) {
                    $('#estante').val('');
                    $('#estante').prop('disabled', true);
                } else {

                    $('#estante').prop('disabled', false);
                    $('#estante').val($('option:contains("' + dado.estante + '")').val());
                }

                if(dado.largura == null) {
                    $('#largura').val('');
                    $('#altura').val('');

                    $('#largura').prop('disabled', true);
                    $('#altura').prop('disabled', true);
                    $('#espessura').prop('disabled', true);
                } else {

                    $('#largura').prop('disabled', false);
                    $('#altura').prop('disabled', false);
                    $('#espessura').prop('disabled', false);

                    $('#largura').val(dado.largura);
                    $('#altura').val(dado.altura);
                    $('#espessura').val($('option:contains("' + dado.espessura + '")').val());
                }

                if(dado.reservado == null) {
                    $('#reservado1').prop('disabled', true);
                    $('#reservado0').prop('disabled', true);

                    $('#pedido').prop('disabled', true);
                } else {
                    $('#reservado1').prop('disabled', false);
                    $('#reservado0').prop('disabled', false);

                    $('#pedido').prop('disabled', false);
                    if(dado.reservado == 1) {
                        $('#reservado1').filter('[value="1"]').attr('checked', true);
                    } else {
                        $('#reservado0').filter('[value="0"]').attr('checked', true);
                    }

                    $('#pedido').val(dado.pedido);
                }

                if(dado.vol == null) {
                    $('#volume').val('');
                    $('#volume').prop('disabled', true);
                } else {
                    $('#volume').prop('disabled', true);

                    $('#volume').val(dado.vol);
                }

                $('#preco').val(dado.preco);
                var buttonExcluir = document.querySelector('#excluir');
                buttonExcluir.setAttribute('onclick', 'remover(' + dado.id + ')');

                var form = document.querySelector('#formEditar');
                form.setAttribute('action', '/estoque/'+dado.id);

            }
        }

        $('#modalEditar').modal('show');
}

function removerItem(id) {
    teste = {
        fornecedor_id : $('#fornecedor_id')
    }
    $.ajax({
        type: 'DELETE',
        url: '/api/estoque/' + id,
        dado: fornecedor_id,
        context:this,
        success: function() {
            $('#modalEditar').modal('hide');
            alert('Item Removido');
            //itens(data);
        },
        error: function(erro) {
            alert(erro);
        }
    });
}
