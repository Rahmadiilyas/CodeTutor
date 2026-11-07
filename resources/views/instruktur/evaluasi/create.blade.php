@extends('layouts.master')
@section('title', 'Buat Evaluasi')
@section('description', 'Membuat evaluasi dan soal pembelajaran.')
@section('page_label', 'Area Instruktur')
@section('page_heading', 'Buat Evaluasi')
@section('content')
    @include('instruktur.evaluasi._form')
@endsection
