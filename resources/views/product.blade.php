@extends('layouts.product')

<?php
$prod = \App\Models\products_detail::find($id);
?>

@section('head-title')
    {{ $prod->name }} - Ankas
@endsection
