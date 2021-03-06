@extends('layouts.app')

@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('content')

    <div class="app--wrapper">

        <div class="app-artworks">

            <main>

                <div class="artworks">

                    <artworks-menu></artworks-menu>

                    <artworks-block artworks_="{{ json_encode($artworks->items()) }}"></artworks-block>
{{--                    @include('partials.artworks', $artworks)--}}

                </div>

                <div class="artworks-bottom" style="text-align: center;margin: 50px 0;">

                    <el-button><a href="/artwork?selected=selected">See artworks of the week</a></el-button>

                    @if($artworks->hasMorePages())
                        <el-button><a href="{{  $artworks->nextPageUrl() }}">See more Artworks</a></el-button>
                    @endif
                    <el-button><a href="{{ route('people') }}">Browse Artists</a></el-button>
                </div>

                {{ $artworks->links() }}

            </main>
        </div>


    </div>

@endsection