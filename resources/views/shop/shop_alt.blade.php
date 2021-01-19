@extends('layouts.template')

@section('title', 'Shop')

@section('main')
    <h1>Shop - alternative listing</h1>
    @foreach($genres as $genre)
        <h2 style="text-transform: capitalize">{{$genre->name}}</h2>
        <ul>
            @foreach($records as $record)
                @if ($genre->id == $record->genre_id)
                    <li>
        <span class="detailrecord"  data-id="{{$record->id}}">
        <a  href="#!">{{$record->artist . ' - ' . $record->title}}</a></span> {{' | Price: €' . $record->price . ' | Stock: ' . $record ->stock}}

                    </li>
                @endif

            @endforeach
        </ul>
    @endforeach
@endsection
@section('script_after')
    <script>
        $(function () {
            $('.detailrecord').click(function () {
                let record_id = $(this).data('id');
                $(location).attr('href', /shop/ + record_id); //OR $(location).attr('href', '/shop/' + record_id);
            });
        });
    </script>
@endsection