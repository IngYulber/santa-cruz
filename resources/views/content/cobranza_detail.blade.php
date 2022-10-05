@extends('template.masterLayout')

@section('title', 'Detalle del Pago')

@section('content')
<cobranza-detalle :id_pago='{{$id}}'></cobranza-detalle>
@endsection
