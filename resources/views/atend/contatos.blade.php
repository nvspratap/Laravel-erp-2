<?php
use Carbon\Carbon;
?>
@extends('main')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading ">
          <i class="fa fa-list fa-1x"></i> Novo atendimento
        </div>
        <div class="panel-body">
          <div class="row pull-center">
            <div class="col-md-12">
              <form method="POST" action="{{ url('/atendimentos') }}/novo/busca">
                <div class="form-group form-inline text-center">
                  {{ csrf_field() }}
                  <input type="text" class="form-control" name="busca" id="busca" placeholder="Busca" size="10">
                  <button type="submit" class="btn btn-success" id="buscar" >Buscar</button>
                </div>
              </form>
            </div>
          </div>
          <div class="row">
            <div class="col-md-8 h3">
              @foreach($contatos as $key => $contato)
                <div class="row list-contacts">
                  <div class="col-md-4 text-right">
                    <a class="btn btn-info" onclick="
                                                      $('#form').show();
                                                      $('#contato').val('{{$contato->nome}}');
                                                      $('#contatos_id').val('{{$contato->id}}');
                    ">
                      <i class="fa fa-gear"></i>
                    </a>
                  </div>
                  <div class="col-md-8">
                    {{$contato->nome}}
                  </div>
                </div>
              @endforeach
            </div>
            <div class="col-md-4" style="display: none;" id="form">
              <form method="POST" action="{{ url('/atendimentos') }}/novo">
                {{ csrf_field() }}
                <div class="form-group">
                  <label>Atendimento para</label>
                  <input type="text" class="form-control" name="contato" id="contato" value="" disabled>
                  <input type="hidden" class="form-control" name="contatos_id" id="contatos_id" value="">
                </div>
                <div class="form-group">
                  <label>Assunto</label>
                  <input type="text" class="form-control" name="assunto" id="assunto" placeholder="Assunto">
                </div>
                <div class="form-group">
                  <label>Data</label>
                  <input type="text" class="form-control" name="data" id="data" value="{{Carbon::now()}}">
                </div>
                <div class="form-group">
                  <label for="text">Descrição </label>
                  <textarea class="form-control" id="texto" rows="5" name="texto"></textarea>
                </div>
                <button type="submit" class="btn btn-success" id="enviar" >Enviar</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
