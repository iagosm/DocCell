const table = new DataTable('#enderecoTable');
$(document).ready(async function() {
  let b = urlAtual + 's'
  await getTable(b, [] , 'get');
});

$(document).on('click', '.button-action', async function() {
  let action = $(this).data('action')
  let id = $(this).data('id')
  activeLoad('start');
  if(action == 'up') {
    $('.recebeEndereco').val(id);
    let json = await actionAjax(urlAtual+'/get/'+id, [], 'get');
    preencherFormulario('editForm', json);
    activeLoad('stop');
    $('.nav-link[data-bs-target="#nav-contact"]').tab('show');
    
  } else if(action == 'del') {
    let url = urlAtual + '/' + id + '/del'
    let request = await actionAjax(url, [], 'post');
    await getTable(urlAtual+'s', [] , 'get');
  }
});

async function add() {
  activeLoad('start');
  let url = urlAtual + '/add'
  let form = $(this).closest('form');
  let dados = form.serialize(); 
  let request = await actionAjax(url, dados, 'POST');
  let b = urlAtual + 's'
  await getTable(b, [] , 'get');
  $('.nav-link[data-bs-target="#nav-home"]').tab('show');
};

async function edit() {
  activeLoad('start');
  let id = $('.recebeEndereco').val();
  let url = urlAtual +'/'+ id +'/edit'
  let form = $(this).closest('form');
  let dados = form.serialize(); 
  let request = await actionAjax(url, dados, 'POST');
  let b = urlAtual + 's'
  await getTable(b, [] , 'get');
  activeLoad('stop');
  $('.nav-link[data-bs-target="#nav-home"]').tab('show');
};


$('[name="cep"]').on('input', async function() {
  let valor = $(this).val();
  let qtd = valor.length;
  let url = "https://brasilapi.com.br/api/cep/v1/";
  if(qtd == 8) {
    activeLoad('start');
    let getCep = await actionAjax(url+valor, [], 'get');
    if(getCep) {
      let form = $(this).closest('form');
      form.find('[name="bairro"]').val(getCep.neighborhood);
      form.find('[name="cidade"]').val(getCep.city);
      form.find('[name="uf"]').val(getCep.state);
      form.find('[name="endereco"]').val(getCep.street);
    }
    activeLoad('stop');
  };
});

$('[name="cep"]').on('input', function() {
  this.value = this.value.replace(/[^0-9]/g, '');
});

// TODO refatorar o button-action para que possa ser reutilizado em outras paginas
// TODO Adicionar notificação
$(document).on('click', '.button-action', async function() {
  let action = $(this).data('action')
  let id = $(this).data('id')
  activeLoad('start');
  if(action == 'up') {
    $('.recebeEndereco').val(id);
    let json = await actionAjax(urlAtual+'/get/'+id, [], 'get');
    preencherFormulario('editForm', json);
    activeLoad('stop');
    $('.nav-link[data-bs-target="#nav-contact"]').tab('show');
    
  } else if(action == 'del') {
    let url = urlAtual + '/' + id + '/del'
    let request = await actionAjax(url, [], 'post');
    await getTable(urlAtual+'s', [] , 'get');
  }
});