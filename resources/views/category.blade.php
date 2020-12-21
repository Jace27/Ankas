@extends('layouts.category')

<?php $cat = \App\Models\categories::find($id)->name; ?>

@section('head-title')
    Категория {{ $cat }} - Ankas
@endsection
