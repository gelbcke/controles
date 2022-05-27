<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Rota para visualização prévia dos templates de email
/*
Route::get('/mail_view', function () {
    $value = App\TermosResponsabilidade::find(3000000);

    return new App\Mail\TRCriacaoMail($value);

});
*/

	Auth::routes();

	Route::get('verify/resend', 'Auth\TwoFactorController@resend')->name('verify.resend');
	Route::resource('verify', 'Auth\TwoFactorController')->only(['index', 'store']);

	//LOCKSCREEN
	Route::get('login/locked', 'Auth\LoginController@locked')->middleware('auth')->name('login.locked');
	Route::post('login/locked', 'Auth\LoginController@unlock')->name('login.unlock');

	Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

	//INICIO
	Route::get('/', 'DashboardController@dash')->name('dashboard');

Route::group( ['middleware' => ['auth', 'twofactor', 'auth.lock']], function() {

//SEGURANÇA
	Route::resource('users', 'UserController');
	Route::resource('roles', 'RoleController');
	Route::resource('permissions','PermissionController');

//LOG
	Route::get('/log/log-list', 'LogController@logList');
	Route::get('/log/log-list-info', 'LogController@logListInfo');
	Route::get('/log/log-list-erro', 'LogController@logListErro');
	Route::get('/log/log-list-bug', 'LogController@logListBug');
	Route::get('/log/log-list-alerta', 'LogController@logListAlerta');
	Route::get('/log', 'LogController@index')->name('log');
	Route::get('/log/info', 'LogController@index')->name('log.info');
	Route::get('/log/erro', 'LogController@index')->name('log.erro');
	Route::get('/log/bug', 'LogController@index')->name('log.bug');
	Route::get('/log/alerta', 'LogController@index')->name('log.alerta');

//ALERTAS
	Route::resource('alertas','AlertController');

//BUGREPORTS
	Route::resource('bug_report','BugReportController');

//CHANGELOG
	Route::view('/changelog', 'changelog.index');

//USUÁRIOS
	Route::get('/usuarios/config', 'UserController@config')->name('usuarios.config');
	Route::get('/usuarios/lockscreen', 'UserController@lockscreen')->name('usuarios.lockscreen');
	Route::get('/usuarios/disabled', 'UserController@disabled')->name('usuarios.disabled');
	Route::get('/usuarios/meu_perfil', 'UserController@meu_perfil')->name('usuarios.meu_perfil');
	Route::get('/usuarios/active/{id}', 'UserController@active')->name('usuarios.active');
	Route::get('/usuarios/deactive/{id}', 'UserController@deactive')->name('usuarios.deactive');
	Route::resource('usuarios','UserController');

//REVISÕES ATIVIDADES
	Route::resource('revisao_atividades','RevisaoAmbienteAtividadeController');

//REVISÕES
	Route::get('/revisao/close/{id}', 'RevisaoAmbienteController@rev_close')->name('revisao.close');
	Route::get('/revisao/rev-list', 'RevisaoAmbienteController@revList');
	Route::get('/revisao/rev-list-mes', 'RevisaoAmbienteController@revListMes');
	Route::get('/revisao/filtro', 'RevisaoAmbienteController@filter')->name('revisao.filter');
	Route::get('/revisao/rev-list-filter', 'RevisaoAmbienteController@revListFilter')->name('revisao.list_filter');
	//Route::view('/revisao/reader', 'revisao.qr_reader');
	Route::get('/revisao/mes_atual','RevisaoAmbienteController@revisao_mes')->name('revisao.mes');
	Route::get('/revisao/vencidas','RevisaoAmbienteController@revisao_vencidas')->name('revisao.vencidas');
	Route::get('/revisao/','RevisaoAmbienteController@filter')->name('revisao.filter');
	Route::resource('revisao','RevisaoAmbienteController');

//UNIDADE
	Route::resource('unidade','UnidadeController');

//BLOCO
	Route::resource('bloco','BlocoController');

//AMBIENTE
	Route::get('/ambientes/amb-list', 'AmbienteController@ambList');
	Route::get('/ambiente/print/{id}','AmbienteController@generate_print_software')->name('ambiente.print');
	Route::get('get-bloco-rev','AmbienteController@getBlocoRev');
	Route::get('get-ambiente-rev','AmbienteController@getAmbienteRev');
	Route::get('get-ambiente-adm','AmbienteController@getAmbienteADM');
	Route::get('get-ambiente-all','AmbienteController@getAmbienteAll');
	Route::get('/ambiente/alterar_vencimento','AmbienteController@alterar_vencimento')->name('ambiente.alterar_vencimento');
	Route::post('/ambiente/atualizar_vencimento', 'AmbienteController@update_vencimento')->name('ambiente.update_vencimento');
	//Mostra somente os ambientes que vencem nos próximos dias
	Route::get('/ambiente/desabilitados', 'AmbienteController@amb_disabled')->name('ambiente.amb_disabled');
	Route::get('/ambiente/ativar/{id}', 'AmbienteController@active')->name('ambiente.active');
	Route::get('/ambiente/index', 'AmbienteController@proximos_vencimentos')->name('ambiente.proximos_vencimentos');
	//Route::post('/ambiente/filtrar','AmbienteController@filter')->name('ambiente.filter');
	Route::get('/ambiente/filtrar','AmbienteController@filter')->name('ambiente.filter');
	Route::get('/ambiente/revisao_vencida', 'AmbienteController@revisao_vencida')->name('ambiente.revisao_vencida');
	Route::any('/ambiente/vence_hoje', 'AmbienteController@revisao_vence_hoje')->name('ambiente.revisao_vence_hoje');
	Route::any('/ambiente/vence_amanha', 'AmbienteController@revisao_vence_amanha')->name('ambiente.revisao_vence_amanha');
	Route::resource('ambiente','AmbienteController');

//HISTÓRICO DE HARDWARE
	Route::get('/ambiente/hardware_hist/{id}', 'HardwareHistController@show')->name('hardware_hist.show');

//SOFTWARES
	Route::post('/software/update_img','SoftwareController@update_img')->name('software.update_img');
	Route::get('/software/autocomplete', 'SoftwareController@autocomplete');
	//Route::post('/software/buscar','SoftwareController@search')->name('software.search');
	Route::get('/software/buscar','SoftwareController@search')->name('software.search');
	Route::get('addmore','SoftwareController@addMore');
	Route::post('addmore','SoftwareController@addMorePost');
	Route::get('get-bloco-list','SoftwareController@getBlocoList');
	Route::get('get-ambiente-list','SoftwareController@getAmbienteList');
	Route::resource('software','SoftwareController');

//LISTA DE SOFTWARES
	Route::get('/lista_de_softwares/searchajax', ['as'=>'searchajax','uses'=>'SoftwareListController@searchResponse']);
	Route::get('/softwarelist/all_key','SoftwareListController@allKey')->name('software.all_key');
	Route::get('/softwarelist/buscar','SoftwareListController@search')->name('softwarelist.search');
	Route::get('/softwarelist/addmore','SoftwareListController@addMore');
	Route::post('/softwarelist/addmore','SoftwareListController@addMorePost');
	Route::resource('softwarelist','SoftwareListController');

//SOFTWARE KEYS
	Route::get('/software_key/download/{path}/{file}', ['as' => 'software_key.download_file', 'uses' => 'SoftwareKeyController@download_file']);
	Route::get('/software_key/inativa/{id}', 'SoftwareKeyController@disabled_details')->name('software_key.disabled_details');
	Route::get('/software_key/searchsoftware', ['as'=>'searchsoftware','uses'=>'SoftwareKeyController@searchSoftware']);
	Route::post('/software_key/detalhes_ativação','SoftwareKeyController@details')->name('software_key.details');
	Route::resource('software_key','SoftwareKeyController');

//CONTRATOS
	Route::get('/contratos/download/{path}/{file}', ['as' => 'contratos.download_file', 'uses' => 'ContratoController@download_file']);
	Route::get('/contratos/desabilitados', 'ContratoController@disabled')->name('contratos.disabled');
	Route::get('/contratos/inativo/{id}', 'ContratoController@disabled_details')->name('contratos.disabled_details');
	Route::get('/contratos/ativar/{id}', 'ContratoController@active')->name('contratos.active');
	Route::get('/contratos/detalhes_ativação','ContratoController@details')->name('contratos.details');
	Route::resource('contratos','ContratoController');

//IMAGEM
	Route::get('/imagem/all', 'ImagemController@all')->name('imagem.all');
	Route::get('/imagem/software_ambiente/{id}', 'ImagemController@soft_amb')->name('imagem.soft_amb');
	Route::get('/imagem/update/{id}', 'ImagemController@update_version')->name('imagem.update_img');
	Route::resource('imagem','ImagemController');

//IMPRESSORAS
	Route::get('/impressora/estatisticas', 'ImpressoraController@estatisticas')->name('impressora.estatisticas');
	Route::get('/impressora/modelo_filter/{id}', 'ImpressoraController@modelo_filter')->name('impressora.modelo_filter');
	Route::resource('impressora','ImpressoraController');

//IMPORTANT NOTES
	Route::resource('notas_importantes','ImportantNotesController');

//MINHAS NOTAS
	Route::resource('my_note','MyNoteController');

//PROJETORES
	Route::post('/projetor_modelo/update/{id}', 'ProjetorModeloController@update')->name('projetor.edit_model');
	Route::resource('projetor_modelo', 'ProjetorModeloController');
	Route::get('/projetor/ficha_tecnica/{id}', 'ProjetorController@model_datasheet')->name('projetor.model_datasheet');
	Route::get('/projetor/modelo_filter/{id}', 'ProjetorController@modelo_filter')->name('projetor.modelo_filter');
	Route::get('/projetor/infra_filter/{id}', 'ProjetorController@infra_filter')->name('projetor.infra_filter');
	Route::get('/projetor/suporte_filter/{id}', 'ProjetorController@suporte_filter')->name('projetor.suporte_filter');
	Route::get('/projetor/create_model', 'ProjetorController@create_model')->name('projetor.create_model');
	Route::post('/projetor/registrar_modelo', 'ProjetorController@store_model')->name('projetor.store_model');
	Route::get('/projetor/search', 'ProjetorController@search')->name('projetor.search');
	Route::get('/projetor/todos', 'ProjetorController@all')->name('projetor.all');
	Route::get('/projetor/estatisticas', 'ProjetorController@estatisticas')->name('projetor.estatisticas');
	Route::resource('projetor', 'ProjetorController');

//FORNECEDORES
	Route::get('/fornecedores/searchfornecedor', ['as'=>'searchfornecedor','uses'=>'FornecedorController@searchFornecedor']);
	Route::get('/fornecedores/desabilitados', 'FornecedorController@disabled')->name('fornecedor.disabled');
	Route::get('/fornecedor/ativar/{id}', 'FornecedorController@active')->name('fornecedor.active');
	Route::get('/fornecedor/fornecedor-list-disabled', 'FornecedorController@fornecedorListDisabled');
	Route::get('/fornecedor/fornecedor-list', 'FornecedorController@fornecedorList');
	Route::resource('fornecedor', 'FornecedorController');

//RELÓGIO PONTO
	Route::get('/relogio_ponto/desabilitados', 'RelogioPontoController@disabled')->name('relogio_ponto.disabled');
	Route::get('/relogio_ponto/ativar/{id}', 'RelogioPontoController@active')->name('relogio_ponto.active');
	Route::get('/relogio_ponto/fornecedor-list', 'RelogioPontoController@fornecedorList');
	Route::resource('relogio_ponto', 'RelogioPontoController');

//GRÁFICOS
	Route::get('rev/rev_hist','DashboardController@revHistChart');

//TERMOS DE RESPONSABILIDADE
		/*
		Route::get('/termos/estatisticas', 'TermosResponsabilidadeController@estatisticas')->name('termos.estatisticas');
		Route::get('/termos/{id}/docx', 'TermosResponsabilidadeController@genDOCX')->name('termos.docx');
		Route::get('/termos/{id}/pdf', 'TermosResponsabilidadeController@genPDF')->name('termos.pdf');
		Route::get('/termos/ativar/{id}', 'TermosResponsabilidadeController@active')->name('termos.active');
		Route::get('/termos/term-list', 'TermosResponsabilidadeController@termList');
		Route::get('/termos/term-entregue', 'TermosResponsabilidadeController@termentregueList');
		Route::get('/termos/entregues', 'TermosResponsabilidadeController@indexEntregues')->name('termos.entregues');
		Route::resource('termos','TermosResponsabilidadeController');
		Route::get('/termos/delete/{id}', 'TermosResponsabilidadeController@destroy')->name('termos.destroy');
		Route::post('/termos/edit/{id}', 'TermosResponsabilidadeController@update')->name('termos.update');
		Route::get('/termos/{id}', 'TermosResponsabilidadeController@show')->name('termos.show');
		Route::get('/termos/delete/{id}', 'TermosResponsabilidadeController@destroy')->name('termos.destroy');
		*/
});
