@extends('layouts.commonMaster')

@section("layoutContent")

<div class="wrapper">

{{-- Nav --}}
@include("layouts.header.nav")

{{-- Sidebar --}}
@include("layouts.sidebar.sidebar")

    {{-- Content Wrapper --}}
    @yield('content')

{{-- Footer --}}
@include("layouts.footer.footer")

</div>

@endsection