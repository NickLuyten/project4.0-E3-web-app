@extends('layouts.template')

@section('title', 'Users')

@section('main')
    <h1>Users</h1>
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
                <th>Admin</th>
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
                    <td>
                        <?php
                        if (old('admin',$user->admin) == 1) {
                            echo "<b>&#10004;</b>";
                        } else {
                            echo "";
                        }
                        ?> </td>


                </tr>
            @endforeach
            </tbody>
        </table>
{{--        {{$users -> links()}}--}}
    </div>
@endsection
@section('script_after')
    <script>
        $(function () {
            $('.deleteForm button').click(function () {

                let name= $(this).data('name');
                let msg = `Delete this user ${name}?`;
                if(confirm(msg)) {
                    $(this).closest('form').submit();
                }
            })
        });
        $(function () {
            // Get name and redirect to the detail page
            $('.card').click(function () {
                user_name = $(this).data('name');
                $(location).attr('href', `/users/${user_name}`);
            });

            $('#user_name').blur(function () {
                $('#searchForm').submit();
            });

            $('#sort_by').change(function () {
                $('#searchForm').submit();
            });
        })




    </script>
@endsection
