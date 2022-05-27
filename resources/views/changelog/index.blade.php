@extends('layouts.app')
@section('pageTitle', 'Changelog')
@section('content')
<header class="page-header">
   <h2>Changelog</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <span>Changelog</span>
         </li>
      </ol>
      <a class="sidebar-right-toggle" data-open="sidebar-right">
      <i class="fa fa-chevron-left"></i>
      </a>
   </div>
</header>
<section class="panel">
   <header class="panel-heading">
      <div class="row">
         <div class="col-sm-6">
            <h2 style="margin-top: 10px;" class="panel-title">
              Versão atual - <b>{{ config('app.controles_app_version') }}</b>
            </h2>
         </div>
      </div>
   </header>
   <div class="panel-body">
       <h5><strong><u>Versão {{ config('app.controles_app_version') }}</u></strong></h5>
         <div style="padding-left:1em">
            <b>Contratos</b>
               <br>- Criação do módulo de Contratos com Fornecedores;               
            <p>
<br>
            <b>Ambientes</b>
               <br>- Possibilidade de manter o histórico de altrações/upgrade de hardware do Ambiente;
               <br>- Aplicada correção da query de alteração de vencimentos geral;
               <br>- Ao registrar uma revisão, o sistema identifica automaticamente se a próxima data de revisão irá ser um fim de semana, caso seja, a data será lançada no próximo dia útil;
               <br>- Adicionado log de alterações de data de vencimento das revisões;
               <br>- Alterado carregamento das tabelas para server-side;
               <br>- Adicionado informações sobre modelo do gabinete (Slim/Torre/Union/Notebook);
               <br>- Possibilidade de verificar no index se o ambiente possuí imagem, projetor e dados de hardware/impressora cadastrados;
               <br>- Adicionado tipo de ambiente "Área Comum" para alocar equipamentos que ficam em áreas abertas/comuns;
               <br>- Alterado checkbox para identificar ambientes sem número (S/N);
            <p>
            <p>
            <b>Blocos</b>
               <br>- Criada página de Visualização e Edição das informações; 
            <p>
            <p>
            <b>Dashboard</b>
               <br>- Aplicada correção dos indicadores de "Revisões Vencidas ( Por Bloco / Mês Atual )" que não estava contabilizando apenas do mês atual;
               <br>- Mantido como padrão todos os indicadores abertos;
               <br>- Alterada a visualização de indicadores "Revisões Preventivas" para busca dos último 12 meses;
               <br>- Indicador em tempo real da revisões em andamento;
               <br>- Aplicada correção de cálculo dos blocos que possuem maior número de revisões vencidas;
               <br>- Adicionado contador de Softwares, Licença de Softwares e Imagens;
               <br>- Alteração no indicador "Revisões Preventivas", e adição de valores com histórico de SLA;
            <p>
            <p>
            <b>Fornecedores</b>
               <br>- Criação do módulo Fornecedores;
            <p>
            <p>
            <b>Imagens</b>
               <br>- Adicionada informação de Unidade e Bloco no dropdown ao selecionar a imagem para registrar software;
               <br>- Possibilidade de verificar ambientes que possuem determinada imagem instalada;
               <br>- Melhoria na apresentação e ordenação das imagens versionadas;
            <p>
            <p>
            <b>Impressoras</b>
               <br>- Adicionado campos "Fila de Impressão", "Contrato" e "Valor do Contrato";
               <br>- Criada view para edição dos equipamentos;
               <br>- Criada view de estatísticas gerais das impressora
            <p>
            <p>
            <b>Licenças de Softwares</b>
               <br>- Criado módulo para controle e consulta de licença de softwares;
               <br>- Criada função para alerta de licenças venceram, ou que irão vencer no próximos 30 dias (Sistema e Email);
               <br>- Função para upload de documentos referente a licença;
            <p>
            <p>
            <b>Log</b>
               <br>- Criação do módulo de Log para alteração de datas de vencimentos das revisões;
            <p>
            <p>
            <b>Meu Perfil</b>
               <br>- Alerta caso o perfil esteja incompleto;
               <br>- Criado aba "Configurações";
               <br>- Criado opção de bloqueio automático do sistema (opção selecionável em Meu Perfil > Configurações); 
            <p>
            <p>
            <b>Notas Importantes</b>
               <br>- Criação do módulo;
            <p>
            <p>
            <b>Projetores</b>
               <br>- Alterado identificação das bases/suportes de projetores de Antigo para Fixo, e Novo para Universal;
               <br>- Alterada tabela e emissão de relatórios. Separando Unidade, Bloco, Ambiente e Sala da mesma coluna; 
               <br>- Correção do gráfico "Quantidade geral de projetores por modelo" que não estava contando alguns equipamentos;
               <br>- Adicionado imagem e ficha técnica do projetor;
            <p>
            <p>
            <b>Relógio Ponto</b>
               <br>- Criação do módulo de controles de relógios ponto;  
            <p>
            <p>
            <b>Revisões</b>
               <br>- Alterado carregamento das tabelas para server-side;
               <br>- O usuário só pode registrar/iniciar uma revisão por vez. Desta forma, contabilizando o tempo gasto em cada atividade;
               <br>- Criada regra para que uma segunda revisão não possa ser iniciada, caso já tenha alguma em andamento por outro usuário;            
            <p>
            <p>
            <b>Termos de Responsabilidade</b>
               <br>- Criado módulo para criar e armazenar Termos de Responsabilidade de equipamentos;
               <br>- Opção de envio de cópia digital do documento para o colaborador;
            <p>
            <p>
            <b>Unidades</b>
               <br>- Adicionado informações: CNPJ, Endereço e Empregadora;
               <br>- Criada página de Visualização e Edição das informações; 
            <p>
            <p>
            <b>Usuários</b>
               <br>- Correção na função de último login do usuário;
               <br>- Melhoria na interface de administração de dados dos usuários;
               <br>- Efetua logoff do usuário quando sua conta é desabilitada;
               <br>- Identificação no index de cadastros incompletos;
               <br>- Export completo dos usuários para excel e pdf;
            <p>
            <p>
            <b>GERAL</b>
               <br>- Remoção de "/public" na url de acesso ao sistema;
               <br>- Adicionado menu de "Demais Configurações";
               <br>- Adicionado 2FA para logon ao sistema;
               <br>- Alteração de fonte e cores do layout;
            <p>
            <p>
         </p>
      </div>
      <hr>
         <h5><strong><u>Versão: Beta</u></strong></h5>
         <div style="padding-left:1em">
            <b>Projetores</b>
               <br>- Adicionado novos tipos de infraestrutura em estatíticas e cadastro de projetores (Carrinho e Interativo);
               <br>- Correção nas estatíticas após filtro de unidade/bloco;
            <p>
            <p>
            <b>Calendário</b>
               <br>- Adicionado informação sobre nível de revisão que está para vencer/venceu;
               <br>- Correção de apresentação de ambientes que possuem vencimento para data atual;
               <p>
            <p>
            <b>Meu Perfil</b>
               <br>- Correção de contagem de revisões realizadas no prazo/fora do prazo;
               <p>
            <p>
             <b>Ambientes</b>
               <br>- Adicionada informações de hardware (desktop e projetor) nos detalhes do ambiente;
            </div>
            <hr>
         <h5><strong><u>Versão: Alpha 2</u></strong></h5>
         <div style="padding-left:1em">
            <b>Módulos Novos</b>
               <br>- Impressoras;
               <br>- Projetores;
            <p>
            <p>
            <b>Ambientes</b>
               <br>- Possibilidade de editar o nome do ambiente;
               <br>- Possibilidade de "Desabilitar" ambiente;
               <br>- Adicionado campo quantidade de máquinas nos ambientes;
               <br>- Adicionado informações de Hardware aos ambientes;
            <p>
            <p>
            <b>Dashboard</b>
               <br>- Indicador de ambientes sob responsabilidade do usuário logado que: Ambientes que possuem revisão vencida, vence hoje e vence amanhã;
               <br>- Indicador de SLA das revisões preventivas cumpridas no mês atual;
               <br>- Indicador com histórico de revisões realizadas (No Prazo/Fora do Prazo);
               <br>- Indicador de bloco com maior quantidade de revisões realizadas após o vencimento;
               <br>- Indicador de bloco com maior índice de revisões realizadas após o vencimento, proporcionalmente calculando a quantidade de ambientes/quantidade de revisões fora do prazo;
               <br>- Indicador de quantidade de ambientes, projetores e impressoras;
            <p>
            <p>
               <b>Revisões</b>
               <br>- Adicionado modal de validação das informações antes do registro da revisão.;                   
               <br>- Adicionado exceção para evitar registro com valor 0;
            <p>
            <p>
               <b>Usuários</b>
               <br>- Criação do módulo "Meu Perfil" com os dados do usuário;
               <br>- Possibilidade de colocar blocos sob responsabilidade de determinado usuário para filtrar alertas;
            <p>
            <p>
               <b>Segurança</b>
               <br>- Adicionado restrição de apenas um dispositivo logado por usuário;
               <br>- Correções de segurança na criação de usuários;
            <p>
            <p>
               <b>Softwares/Imagens</b>
               <br>- Melhoria no cadastro de Softwares para evitar duplicidade;
               <br>- Melhoria no cadastro de Softwares em imagem cadastrada;
               <br>- Correção de permissão para usuários buscarem softwares por imagem/ambiente;
            <p>
            <p>
               <b>Imagens</b>
               <br>- Melhoria no cadastro de imagens;
               <br>- Possibilidade de atualizar versão da imagem buscando softwares já instalados previamente;
            <p>
            <p>
               <b>Geral</b>
               <br>- Melhoria na visualização das Tabelas com filtros ativos;
               <br>- Possibilidade de exportar filtro de buscas para Excel, PDF e Impressão direta;
               <br>- Reformulação da Dashboard com mais informações;
               <br>- Correção vencimentos de revisões;
               <br>- Correção módulo de alterações de vencimentos;
               <br>- Correções no Backend/Frontend;
         </div>    
   <hr>
      <div class="table-responsive m-t-20">
         <h5><strong><u>Versão: Alpha 1</u></strong></h5>
         <div style="padding-left:1em">
            - Criação da Dashboard; <br>
            - Criação do Módulo Ambientes; <br>
            - Criação do Módulo Revisão de Ambientes; <br>
            - Criação do Módulo Softwares; <br>
            - Criação do Módulo Imagens; <br>
            - Crição de Grupo de Permissões de Acesso do Usuários; <br>
            - Melhoria no módulo do perfil de Usuário; <br>
            - Criação de Filtro de Buscas; <br>
         </div>
      </div>
</section>
@endsection