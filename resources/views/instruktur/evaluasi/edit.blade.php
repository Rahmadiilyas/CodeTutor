@extends('layouts.master')
@section('title', 'Edit Evaluasi')
@section('description', 'Perbarui evaluasi dan soal pembelajaran.')
@section('page_label', 'Area Instruktur')
@section('page_heading', 'Edit Evaluasi')
@section('content')
    @include('instruktur.evaluasi._form')
@endsection
