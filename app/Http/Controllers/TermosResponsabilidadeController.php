<?php

namespace App\Http\Controllers;

use App\Models\TermosResponsabilidade;
use App\Mail\TermoResponsabilidadeMail;
use App\Models\User;
use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Input;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use Carbon\Carbon;
use Auth, Session, Datatables, Toastr, Artisan, File;
use DB, Route, PDF, Mail;

class TermosResponsabilidadeController extends Controller
{
    protected   $request;

    public function __construct(Request $request, TermosResponsabilidade $termosResponsabilidade)
    {
        $this->middleware('auth');
        $this->termosResponsabilidade   = $termosResponsabilidade;
        $this->request                  = $request;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(auth()->user()->can('Visualizar Termos de Responsabilidade'))
        {            
            $termos     = TermosResponsabilidade::whereNull('status')
                            ->orderby('id', 'asc')                
                            ->get();                           

            return view('termos.index',compact('termos'));
        }
        else
        {
            return view('errors.401');
        }   
    }

    public function termList(TermosResponsabilidade $termosResponsabilidade, Request $request)
    {
        //
        if(auth()->user()->can('Visualizar Termos de Responsabilidade'))
        {
        $today = Carbon::today()->startOfDay();

        $termos = DB::table('termos_responsabilidades')
            ->select([ 
                'termos_responsabilidades.matricula as matricula',
                'termos_responsabilidades.colaborador as colaborador',
                'termos_responsabilidades.equipamento as equipamento',
                'termos_responsabilidades.pat as pat',
                'termos_responsabilidades.ns as ns', 
                'termos_responsabilidades.id as id',
                'termos_responsabilidades.status as status',
                'termos_responsabilidades.empresa as empresa'           
            ])
            ->where( function ($q) {
                    $q->whereNull("status")
                    ->orwhere("status", 1);
                } );

        return datatables()->of($termos)          
          
            ->addColumn('admin_opt', function($row) {
                return '
                    <div class="btn-group">
                         <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <span class="caret"></span></button>
                         <ul class="dropdown-menu" role="menu" style="right: 0 !important; left: auto;">
                            <li>
                                <a href="termos/'. $row->id .'">Detalhes</a>
                            </li>   
                            <li>
                                <a href="termos/'.$row->id.'/edit">Editar</a>
                            </li>
                            <li class="divider"></li> 
                            <li> 
                               <a href="termos/delete/'.$row->id.'" onclick="javascript:showLoader();"><font color="red">Marcar como entregue</font></a>
                            </li>  
                         </ul>
                      </div>
                    ';                          
            })

            ->addColumn('print', function($row) {
                    return '<a href="termos/'. $row->id .'/docx"><i class="fas fa-file-word"></i></a>';
            })
           
            ->addColumn('user_opt', function($row) {
                    return '
                    <div class="btn-group">
                         <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <span class="caret"></span></button>
                         <ul class="dropdown-menu" role="menu" style="right: 0 !important; left: auto;">
                            <li><a href="termos/'. $row->id .'">Detalhes</a></li>                  
                         </ul>
                      </div>
                    ';
            })

            ->rawColumns(['print', 'termos', 'admin_opt', 'user_opt'])
            ->make(true);
            }
        }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexEntregues()
    {
        //
        if(auth()->user()->can('Visualizar Termos de Responsabilidade'))
        {            
            $termos     = TermosResponsabilidade::whereNull('status')
                            ->orderby('id', 'asc')                
                            ->get();

            return view('termos.index',compact('termos'));
        }
        else
        {
            return view('errors.401');
        }   
    }

    // Mostra apenas termos que foram entregues
    public function termentregueList(TermosResponsabilidade $termosResponsabilidade, Request $request)
    {
        //
        if(auth()->user()->can('Visualizar Termos de Responsabilidade'))
        {
        $today = Carbon::today()->startOfDay();

        $termos = DB::table('termos_responsabilidades')
            ->select([ 
                'termos_responsabilidades.matricula as matricula',
                'termos_responsabilidades.colaborador as colaborador',
                'termos_responsabilidades.equipamento as equipamento',
                'termos_responsabilidades.pat as pat',
                'termos_responsabilidades.ns as ns', 
                'termos_responsabilidades.id as id',
                'termos_responsabilidades.status as status',
                'termos_responsabilidades.empresa as empresa'           
            ])
            ->where( function ($q) {
                    $q->where("status", 0);
                } );

        return datatables()->of($termos)          
          
            ->addColumn('admin_opt', function($row) {
                return '
                    <div class="btn-group">
                         <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <span class="caret"></span></button>
                         <ul class="dropdown-menu" role="menu" style="right: 0 !important; left: auto;">
                            <li>
                                <a href="'. $row->id .'">Detalhes</a>
                            </li> 
                            <li>
                                <a href="'.$row->id.'/edit">Editar</a>
                            </li>
                            <li class="divider"></li>
                            <li> 
                               <a href="ativar/'.$row->id.'" onclick="javascript:showLoader();">Marcar como em uso</a>
                            </li>
                         </ul>
                      </div>
                    ';                                
            })

            ->addColumn('print', function($row) {
                    return '<a href="'. $row->id .'/docx"><i class="fas fa-file-word"></i></a>';
            })
           
            ->addColumn('user_opt', function($row) {
                    return '
                    <div class="btn-group">
                         <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <span class="caret"></span></button>
                         <ul class="dropdown-menu" role="menu" style="right: 0 !important; left: auto;">
                            <li><a href="'. $row->id .'">Detalhes</a></li>                  
                         </ul>
                      </div>
                    ';
            })
            ->rawColumns(['print', 'termos', 'admin_opt', 'user_opt'])
            ->make(true);
            }
        }

    public function estatisticas()
    {
        //
        if(auth()->user()->can('Visualizar Termos de Responsabilidade')){
        $today           = Carbon::today()->startOfDay();
        $end_today       = Carbon::today()->endOfDay();
        $tomorrow        = Carbon::tomorrow()->startOfDay();
        $aftertomorrow   = Carbon::tomorrow()->endOfDay();

        //Apresenta gráfico total de termos utilizados por ano
        $geral_anual = TermosResponsabilidade::select(
                 DB::raw('COUNT( id ) as term_hist
                    '),  
                 //DB::raw('CONCAT(sla_hist_vl,"%") as sla_hist'),          
                DB::raw('DATE_FORMAT(created_at, "%Y %m") month_year'),
                DB::raw('DATE_FORMAT(created_at, "%Y") year')
            )
            ->orderBy('year', 'asc')
            ->groupby('year')
            ->get();

        //Apresenta gráfico total de termos por unidade
        $geral_unidades = TermosResponsabilidade::select(
                DB::raw('unidades.id,unidades.name as unidade_count'),
                'unidade_id as unidade' ,
                DB::raw('COUNT(*) as termos_total')
            )
            ->join('unidades',function($q){
                    $q->on('termos_responsabilidades.unidade_id', 'unidades.id');
                })
            ->whereNull('termos_responsabilidades.status')
            ->groupBy('unidade')
            ->get();

        //Apresenta gráfico total de termos vencidos
        $geral_vencidos = TermosResponsabilidade::select(
                 DB::raw('COUNT(*) as vencidos_count'),
                 'termos_responsabilidades.colaborador as colaborador'
             )  
           ->whereNull('status')
            ->orderBy('colaborador', 'asc')
            ->groupby('colaborador')
            ->get();



        return view ('termos.estatisticas', compact('geral_anual', 'geral_unidades', 'geral_vencidos'));
          }else{
            return view('errors.401');
        }  
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(auth()->user()->can('Criar Termos de Responsabilidade'))
        {
            $termo      = TermosResponsabilidade::get();

            $users      = User::where('status', 1)->orderby('name', 'asc')->get();

            $unidades   = Unidade::whereNull('status')->orderby('name','asc')->get();

            return view('termos.create',compact('users', 'unidades', 'termo'));
        }
        else
        {
            return view('errors.401');
        }  

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if(auth()->user()->can('Criar Termos de Responsabilidade')){
      
        //insert post data
        TermosResponsabilidade::create($request->all() );

        if($request->send_mail == "ok"){
            
            $termo = termosResponsabilidade::latest('id')->first();

            $unidade        = Unidade::where('id', $termo->unidade_id);
            $gerente        = User::where('id', $termo->gerente_id);
            $responsavel    = User::where('id', $termo->responsavel_id);
            $testemunha     = User::where('id', $termo->testemunha_id);

            $centered       = array('align' => 'center');
            $noSpace        = array('spaceAfter' => 0);

            if(!empty($request->input('dt_entrega')))
            {
                $my_template    = new \PhpOffice\PhpWord\TemplateProcessor(public_path("doc//template//termo_responsabilidade_email_emprestimo.docx"));
                $my_template->setValue('data_entrega',      $termo->dt_entrega->formatLocalized('%d/%m/%Y'));
            }
            else
            {
                $my_template    = new \PhpOffice\PhpWord\TemplateProcessor(public_path("doc//template//termo_responsabilidade_email.docx"));
            }

            $my_template->setValue('contrato',          $termo->id);
            $my_template->setValue('colaborador',       $termo->colaborador);
            $my_template->setValue('matricula',         $termo->matricula);
            $my_template->setValue('rg',                $termo->rg);
            $my_template->setValue('cpf',               $termo->cpf);
            $my_template->setValue('cnpj',              $termo->cnpj);
            $my_template->setValue('contato',           $termo->contato);
            $my_template->setValue('unidade',           $unidade->value('name'));
            $my_template->setValue('cargo',             $termo->cargo);
            $my_template->setValue('vinculo',           $termo->vinculo);
            $my_template->setValue('equipamento',       $termo->equipamento);
            $my_template->setValue('marca',             $termo->marca);
            $my_template->setValue('modelo',            $termo->modelo);
            $my_template->setValue('processador',       $termo->processador);
            $my_template->setValue('memoria',           $termo->memoria);
            $my_template->setValue('hd',                $termo->hd);
            $my_template->setValue('patrimonio',        $termo->pat);
            $my_template->setValue('ns',                $termo->ns);
            $my_template->setValue('itens_add',         $termo->itens_add);            
            $my_template->setValue('empregadora',       $unidade->value('empregadora'));
            $my_template->setValue('endereco',          $unidade->value('endereco'));
            $my_template->setValue('cnpj_unidade',      $unidade->value('cnpj'));
            $my_template->setValue('gerente',           $gerente->value('name'));
            $my_template->setValue('gerente_rg',        $gerente->value('rg'));
            $my_template->setValue('responsavel',       $responsavel->value('name'));
            $my_template->setValue('responsavel_rg',    $responsavel->value('rg'));
            $my_template->setValue('testemunha',        $testemunha->value('name'));
            $my_template->setValue('testemunha_rg',     $testemunha->value('rg'));
            $my_template->setValue('created_at',        $termo->created_at->formatLocalized('%d de %B %Y'));
            $my_template->setValue('updated_at',        $termo->updated_at->formatLocalized('%d de %B %Y'));

            $table              = new Table(array(
                'borderSize'    => 8, 
                'borderColor'   => 'gray', 
                'width'         => 10000, 
                'unit'          => TblWidth::TWIP, 
                'cellSpacing '  => 0,
            ));

            $table->addRow(200,null);
            $table->addCell(8000)->addText('Software', array('bold'=>true), $noSpace);
            $table->addCell(2000)->addText('Versão', array('bold'=>true), $noSpace);

            $my_template->setComplexBlock('table', $table);
     
            $file = $my_template->saveAs(public_path('doc/temp/TR_'. $termo->id . '.docx'));

            //Envia Email com o Termo em Anexo
            Artisan::call('tr_criacao:mail');

            //Deleta o arquivo do servidor após o envio
            File::delete(public_path('doc/temp/TR_'. $termo->id . '.docx'));

            toastr()->info('Email com cópia do termo para o colaborador!', 'Enviado', ['timeOut' => 5000]);
        }

        toastr()->success('Termo registrado com sucesso!', 'Salvo', ['timeOut' => 5000]);
        return redirect()->route('termos.index');
        }
        else{
            return view('errors.401');
        }   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TermosResponsabilidade  $termosResponsabilidade
     * @return \Illuminate\Http\Response
     */
    public function show($id, TermosResponsabilidade $termosResponsabilidade, Request $request)
    {
        //
        if(auth()->user()->can('Visualizar Termos de Responsabilidade'))
        {
            $tm = TermosResponsabilidade::where('id', $id)->get();

            return view('termos.show',compact('tm'));
        }
        else
        {
            return view('errors.401');
        }  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TermosResponsabilidade  $termosResponsabilidade
     * @return \Illuminate\Http\Response
     */
    public function edit($id, TermosResponsabilidade $termosResponsabilidade)
    {
        //
        if(auth()->user()->can('Editar Termos de Responsabilidade'))
        {
            $termo      = TermosResponsabilidade::find($id);
            $users      = User::where('status', 1)->orderby('name', 'asc')->get();

            $unidades   = Unidade::whereNull('status')->orderby('name','asc')->get();

            return view('termos.edit',compact('users', 'unidades', 'termo'));
        }
        else
        {
            return view('errors.401');
        } 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TermosResponsabilidade  $termosResponsabilidade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TermosResponsabilidade $termosResponsabilidade)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TermosResponsabilidade  $termosResponsabilidade
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request, TermosResponsabilidade $termosResponsabilidade)
    {
        //
         if(auth()->user()->can('Remover Termos de Responsabilidade')){
            $termo               = TermosResponsabilidade::find($id);
            $termoUpdate         = $termo;
            $termoUpdate->status = 0;
            $termoUpdate->dt_devolucao = Carbon::now();
            $termoUpdate->save();    

            //Envia Email com a confirmação da devolução do equipamento
            Mail::send('emails.termos.tr_confirmdevolucao', ['termo' => $termo], function ($m) use ($termo) {
                $m->from('noreply.suporte@up.edu.br', 'T.I. Educacional - Universidade Positivo');

                $m->to($termo->email, $termo->colaborador)->subject('Confirmação de Devolução de Equipamento.');
            });

            toastr()->info('Confirmação de devolucao enviada para o colaborador!', 'Enviado', ['timeOut' => 5000]);


            toastr()->success('Termo '.$termo->id.' marcado como entregue com sucesso!', 'OK', ['timeOut' => 5000]);
            return redirect()->back();
        }
        else
        {
            return view('errors.401');
        }   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ambiente  $ambiente
     * @return \Illuminate\Http\Response
     */
    public function active($id, Request $request, TermosResponsabilidade $termosResponsabilidade)
    {
        //
        if(auth()->user()->can('Remover Termos de Responsabilidade')){
            $termo               = TermosResponsabilidade::find($id);
            $termoUpdate         = $termo;
            $termoUpdate->status = null;
            $termoUpdate->dt_devolucao = null;
            $termoUpdate->save();      

            toastr()->success('Termo '.$termo->id.' marcado com em uso com sucesso!', 'OK', ['timeOut' => 5000]);
            return redirect()->route('termos.index');
        }
        else
        {
            return view('errors.401');
        }   
    }

    public function genDOCX($id, Request $request) 
    {
        //
        $termo          = TermosResponsabilidade::find($id);

        $unidade        = Unidade::where('id', $termo->unidade_id);
        $gerente        = User::where('id', $termo->gerente_id);
        $responsavel    = User::where('id', $termo->responsavel_id);
        $testemunha     = User::where('id', $termo->testemunha_id);

        $centered       = array('align' => 'center');
        $noSpace        = array('spaceAfter' => 0);

        if($termo->dt_entrega != null)
        {
            $my_template = new \PhpOffice\PhpWord\TemplateProcessor(public_path("doc//template//termo_responsabilidade_emprestimo.docx"));
            $my_template->setValue('data_entrega',      $termo->dt_entrega->formatLocalized('%d/%m/%Y'));
        }else
        {
            $my_template = new \PhpOffice\PhpWord\TemplateProcessor(public_path("doc//template//termo_responsabilidade.docx"));
        }        

        $my_template->setValue('contrato',          $termo->id);
        $my_template->setValue('colaborador',       $termo->colaborador);
        $my_template->setValue('matricula',         $termo->matricula);
        $my_template->setValue('rg',                $termo->rg);
        $my_template->setValue('cpf',               $termo->cpf);
        $my_template->setValue('cnpj',              $termo->cnpj);
        $my_template->setValue('contato',           $termo->contato);
        $my_template->setValue('unidade',           $unidade->value('name'));
        $my_template->setValue('cargo',             $termo->cargo);
        $my_template->setValue('vinculo',           $termo->vinculo);
        $my_template->setValue('equipamento',       $termo->equipamento);
        $my_template->setValue('marca',             $termo->marca);
        $my_template->setValue('modelo',            $termo->modelo);
        $my_template->setValue('processador',       $termo->processador);
        $my_template->setValue('memoria',           $termo->memoria);
        $my_template->setValue('hd',                $termo->hd);
        $my_template->setValue('patrimonio',        $termo->pat);
        $my_template->setValue('ns',                $termo->ns);
        $my_template->setValue('itens_add',         $termo->itens_add);        
        $my_template->setValue('empregadora',       $unidade->value('empregadora'));
        $my_template->setValue('endereco',          $unidade->value('endereco'));
        $my_template->setValue('cnpj_unidade',      $unidade->value('cnpj'));
        $my_template->setValue('gerente',           $gerente->value('name'));
        $my_template->setValue('gerente_rg',        $gerente->value('rg'));
        $my_template->setValue('responsavel',       $responsavel->value('name'));
        $my_template->setValue('responsavel_rg',    $responsavel->value('rg'));
        $my_template->setValue('testemunha',        $testemunha->value('name'));
        $my_template->setValue('testemunha_rg',     $testemunha->value('rg'));
        $my_template->setValue('created_at',        $termo->created_at->formatLocalized('%d de %B %Y'));
        $my_template->setValue('updated_at',        $termo->updated_at->formatLocalized('%d de %B %Y'));

        $table              = new Table(array(
            'borderSize'    => 8, 
            'borderColor'   => 'gray', 
            'width'         => 10000, 
            'unit'          => TblWidth::TWIP, 
            'cellSpacing '  => 0,
        ));

        $table->addRow(200,null);
        $table->addCell(8000)->addText('Software', array('bold'=>true), $noSpace);
        $table->addCell(2000)->addText('Versão', array('bold'=>true), $noSpace);

        $my_template->setComplexBlock('table', $table);
 
        $file = $my_template->saveAs(public_path('doc/temp/TR_'. $termo->id . '.docx'));

        return response()->download(public_path('doc/temp/TR_'. $termo->id . '.docx'))->deleteFileAfterSend(true);
       
    }
}
