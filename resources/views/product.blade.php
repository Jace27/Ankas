@extends('layouts.product')

<?php
$cat = \App\Models\categories::find($catId);
$prod = \App\Models\products_detail::find($prodId);
?>

@section('head-title')
    {{ $prod->name }} - {{ $cat->name }} - Ankas
@endsection
