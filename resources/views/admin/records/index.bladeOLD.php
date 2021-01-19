@extends('layouts.template')
@section('title', 'Records(Admin)')

@section('main')
        <h1>Records</h1>

        <ul>
                <?php
                //    foreach ($records as $record){
                //        echo "<li> $record </li>";
                //        //echo '<li>' . $record . '</li>';
                //    }
                ?>
                @foreach($records as $record)
                        <li>{!! $record !!}</li>
                @endforeach

        </ul>
@endsection
