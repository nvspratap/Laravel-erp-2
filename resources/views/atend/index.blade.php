@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-list fa-1x"></i> Lista de atendimentos realizados
        </div>
        <div class="panel-body">
          <form method="POST" action="{{ url('lista/atendimentos') }}/">
            <div id="secondNavbar" class="row">
              <div class="row">
                <div class="col-md-2 text-left pull-left" >
                  <div class=" form-inline col-md-10 text-right">
                    @botaoDelete
                    @botaoEditar
                    @botaoDetalhes
                  </div>
                  <div class=" form-inline col-md-1 text-left">
                    @idSelecionado
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group form-inline text-center">
                    {{ csrf_field() }}
                    @buscaSimples
                    @buscaExtraBotao
                  </div>
                </div>
                  <div class="col-md-1 pull-right text-right">
                    @botaoNovo(atendimentos)
                  </div>
              </div>
              <div id="buscaAvançada" class="row collapse " aria-expanded="" style="background-color: #fff; z-index:1030;">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="data_de">Busca por data <span class="label label-info">de</span></label>
                    <input type="text" class="form-control datepicker" name="data_de" id="data_de" placeholder="">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="data_ate">Busca por data <span class="label label-info">ate</span></label>
                    <input type="text" class="form-control datepicker" name="data_ate" id="data_ate" placeholder="">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="data_ate">Assunto</label>
                    <select class="form-control" id="assunto" name="assunto">
                      <option value="" selected> - Escolha a relação -</option>>
                      @foreach($comboboxes as $key => $combo)
                        <option value="{{$combo->text}}">{{$combo->text}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                @if (isset(Auth::user()->perms["admin"]) and Auth::user()->perms["admin"]==1)
                  <div class="col-md-2 pull-right">
                    <input type="checkbox"name="deletados" id="deletados"   >
                    <span id="deletadosText">buscar com deletados</span>
                  </div>
                @endif
              </div>
            </div>
          </form>
          <div class="row "  id="lista">
            <div class="col-md-1">
              IDs
            </div>
            <div class="col-md-2">
              Quem foi atendido
            </div>
            <div class="col-md-2">
              Assunto
            </div>
            <div class="col-md-5">
              Descrição
            </div>
            <div class="col-md-1 pull-right">
              Quando
            </div>
          </div>
          @if (!empty($atendimentos))
            @foreach($atendimentos as $key => $atendimento)
                <div class="row list-contacts" onclick="selectRow({{$atendimento->id}})">
                  <div class="col-md-1 text-left ajuda-popover" @if ($key==0) title="Criação e contato" data-content="Data do atendimento, e contato atendido." data-placement="bottom" @endif >
                    <span class="label label-info">
                      ID: {{$atendimento->id}}
                    </span>
                  </div>
                  <div class="col-md-2">
                    @mostraContato($atendimento->contatos->id*str_limit($atendimento->contatos->nome, 15))
                  </div>
                  <div class="col-md-2 ajuda-popover" @if ($key==0) title="Detalhes" data-content="Assunto e descrição." data-placement="bottom" @endif >
                    {{$atendimento->assunto}}
                  </div>
                  <div class="col-md-6">
                    {{ str_limit(strip_tags($atendimento->texto), 60)}}
                  </div>
                  <div class="col-md-1 pull-right">
                    <span class="label label-info">
                      {{date('d/m/Y', strtotime($atendimento->created_at))}}
                    </span>
                  </div>
                </div>

            @endforeach
            <div class="row">
              <div class="col-md-10 text-center">
                <span class="label label-primary">
                  Total de atendimentos: {{ $total }}
                </span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-10 text-center">
                {{ $atendimentos->links() }}
              </div>
            </div>
            <hr>
            @if ($deletados!='0')
              <h1> Deletados</h1>
              @foreach($deletados as $key => $atendimento)
                <div class="row list-contacts" onclick="selectRow({{$atendimento->id}})">
                  <div class="col-md-1 text-left ajuda-popover" @if ($key==0) title="Criação e contato" data-content="Data do atendimento, e contato atendido." data-placement="bottom" @endif >
                    <span class="label label-info">
                      ID: {{$atendimento->id}}
                    </span>
                  </div>
                  <div class="col-md-3">
                    <a href="{{ url('novo/contatos') }}/{{$atendimento->contatos->id}}" class="label label-primary">
                      <i class="fa fa-user"></i> {{ str_limit($atendimento->contatos->nome, 30)}}
                    </a>
                  </div>
                  <div class="col-md-2 ajuda-popover" @if ($key==0) title="Detalhes" data-content="Assunto e descrição." data-placement="bottom" @endif >
                    {{$atendimento->assunto}}
                  </div>
                  <div class="col-md-4">
                    {{ str_limit(strip_tags($atendimento->texto, 25))}}
                  </div>
                  <div class="col-md-1 pull-right">
                    <span class="label label-info">
                      {{date('d/m/Y', strtotime($atendimento->created_at))}}
                    </span>
                  </div>
                </div>
              @endforeach
            @endif
          </div>
        </div>
      </div>
    </div>
    <script language="javascript">
    var imageStatus = false;
      function selectRow(id){
        window.id_attach_form = id;
        $("#ids").val(id);
        $("#botaoDelete").attr('href', '{{ url('lista/atendimentos') }}/'+id+'/delete/');
        $("#botaoDetalhes").attr('onclick', 'openModal("{{ url('lista/atendimentos') }}/'+id+'")');
        $("#botaoEditar").attr('href', '{{ url('novo/atendimentos') }}/'+id);
      }
      function listaTop(){
        var css = $('#lista').css('margin-top');
        if(css == "75px"){
          $('#lista').css('margin-top', '0px');
        } else {
          $('#lista').css('margin-top', '75px');
        }
      }
    </script>
    <script language="javascript">
      $( function() {
        $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
      } );
    </script>
  @endif
@endsection
