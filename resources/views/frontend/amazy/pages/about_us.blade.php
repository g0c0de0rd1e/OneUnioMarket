@extends('frontend.amazy.layouts.app')

@php
    $page = \Modules\FrontendCMS\Entities\DynamicPage::where('slug', 'about-us')->first();
@endphp


@section('title')
{{$content->mainTitle}}
@endsection

@section('title')
Auction Product Gallery | {{ config('app.name') }}
@endsection

@section('share_meta')
<meta name="title" content=" {{$content->mainTitle}} | {{ config('app.name') }}">
<meta name="description" content="{{$content->mainTitle}} | {{ config('app.name') }}">
<meta property="og:title" content="{{$content->mainTitle}} | {{ config('app.name') }}" />
<meta property="og:description" content="{{$content->mainTitle}} | {{ config('app.name') }}" />
<meta property="og:url" content="{{url()->current()}}" />
@endsection

@section('content')

<div class="container mt_30 mb_30 min-vh-50">

    @php
        echo $page->description;
    @endphp
</div>
@endsection

