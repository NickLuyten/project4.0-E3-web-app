@extends('layouts.template')

@section('title', 'Users')

@section('main')
    <h1>Gebruikers</h1>
    @include('shared.alert')
{{--    <form method="get" action="/admin/users" id="searchForm">--}}
{{--        <div class="row">--}}
{{--            <div class="col-sm-8 mb-2" >--}}
{{--                <label>Filter Name or Email</label>--}}
{{--                <input type="text" class="form-control" name="user_name" id="user_name"--}}
{{--                       value="{{request()->user_name}}" placeholder="Filter Name Or Email">--}}
{{--            </div>--}}
{{--            <div class="col-sm-4 mb-2">--}}
{{--                <label for="sort_by">Sort By</label>--}}
{{--                <select class="form-control" name="sort_by" id="sort_by">--}}
{{--                    @foreach($sortList as $i => $item)--}}
{{--                        <option value="{{$i}}" {{request() -> sort_by == $i ? 'selected' : ''}}>{{$item['name']}}</option>--}}
{{--                    @endforeach--}}

{{--                </select>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </form>--}}
{{--    @if ($users->count() == 0)--}}
{{--        <div class="alert alert-danger alert-dismissible fade show">--}}
{{--            Can't find any name or email with <b>'{{ request()->name }}'</b> for the user--}}

{{--            <button type="button" class="close" data-dismiss="alert">--}}
{{--                <span>&times;</span>--}}
{{--            </button>--}}
{{--        </div>--}}
{{--    @endif--}}
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Voornaam</th>
                <th>Achternaam</th>
                <th>Email</th>
                <th>Company</th>
                <th>Max Handgels/maand</th>
                <th>Admin</th>
                <th>Guest</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)


                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->firstName }}</td>
                    <td>{{ $user->lastName }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->companyId }}</td>
                    <td>{{ $user->sanitizerLimitPerMonth }}</td>
                    <td>
                        <?php
                        if (old('admin',$user->admin) == 1) {
                            echo "<b>&#10004;</b>";
                        } else {
                            echo "";
                        }
                        ?> </td>
                    <td>
                        <?php
                        if (old('guest',$user->guest) == 1) {
                            echo "<b>&#10004;</b>";
                        } else {
                            echo "";
                        }
                        ?> </td>
                    <td>
                            <div class="btn-group btn-group-sm">
                                <a href="/admin/users/{{ $user->id }}/edit" class="btn btn-outline-success"
                                   data-toggle="tooltip"
                                   title="Edit {{ $user->email }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="/admin/users/{{ $user->id }}/delete" class="btn btn-outline-danger"
                                   data-toggle="tooltip"
                                   title="Delete {{ $user->email }}">
                                    <i class="fas fa-trash-alt"></i>
                                </a>

                                @if (old('guest',$user->guest) == 1)
                                    <a href='/admin/users/qrcodeGuest/{{$user->id}}' class='btn btn-outline-primary'>Qr code</a>
                                @else

                                @endif

                            </div>
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
        <a href="/admin/users/create" class="btn btn-outline-success btn-lg btn-block"><i class="fas fa-plus"></i> Gebruiker toevoegen</a>
    </div>
@endsection
@section('script_after')
    <script>




    </script>
@endsection
