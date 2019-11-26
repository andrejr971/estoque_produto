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

        tdElemento1.appendChild(texto1);
        tdElemento2.appendChild(texto2);
        tdElemento3.appendChild(texto3_1);
        tdElemento3.appendChild(texto3_2);
        tdElemento3.appendChild(texto3_3);
        tdElemento4.appendChild(btnEditar);
        tdElemento4.appendChild(btnRemover);

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
        error: function() {
            console.log(error);
        }
    });
}

function remover(id) {
    $.ajax({
        type: 'DELETE',
        url: '/api/fornecedor/' + id,
        context: this,
        success: function() {
            carregarFornecedores();
            alert('Fornecedor Deletado');
        },
        error: function() {
            console.log(error);
        }
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