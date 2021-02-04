@extends('layouts.template')

@section('title', 'Users')

@section('main')
    <h1>Gebruikers</h1>
{{--    Error/succes messages--}}
    @include('shared.alert')
    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            {{$errors->first()}}
        </div>
    @endif
    @if(session()->has('msg'))
        <div class="alert alert-success" role="alert">
            {{session()->get('msg')}}
        </div>
    @endif
    <div class="table-responsive">
        <table class="table" id="myTable">
            <thead>
            <tr>
                <th onclick="sortTable(0)"># <i class="fas fa-arrows-alt-v"></i></th>
                <th onclick="sortTable(1)">Voornaam <i class="fas fa-arrows-alt-v"></i></th>
                <th onclick="sortTable(2)">Achternaam <i class="fas fa-arrows-alt-v"></i></th>
                <th onclick="sortTable(3)">Email <i class="fas fa-arrows-alt-v"></i></th>
                <th onclick="sortTable(4)">Bedrijf <i class="fas fa-arrows-alt-v"></i></th>
                <th onclick="sortTable(5)">Afdeling <i class="fas fa-arrows-alt-v"></i></th>
                <th onclick="sortTable(6)">Admin <i class="fas fa-arrows-alt-v"></i></th>
                <th onclick="sortTable(7)">Guest <i class="fas fa-arrows-alt-v"></i></th>
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
{{-- Vergelijkt user companyId met alle companyId's en gebruikt dan de naam van de company en zo ook met de types--}}
                    @if($type == "admin")
                        <td>@foreach($companies as $company) @if($user->companyId == $company->id) {{$company->name}} @endif @endforeach</td>
                    @elseif ($type == "lokale_admin")
                        <td>{{$companies->name}}</td>
                    @endif
                    <td>@foreach($types as $typeFunctie) @if($user->typeId == $typeFunctie->id) {{$typeFunctie->name}} @endif @endforeach</td>
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
        function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("myTable");
            switching = true;
            //Set the sorting direction to ascending:
            dir = "asc";
            /*Make a loop that will continue until
            no switching has been done:*/
            while (switching) {
                //start by saying: no switching is done:
                switching = false;
                rows = table.rows;
                /*Loop through all table rows (except the
                first, which contains table headers):*/
                for (i = 1; i < (rows.length - 1); i++) {
                    //start by saying there should be no switching:
                    shouldSwitch = false;
                    /*Get the two elements you want to compare,
                    one from current row and one from the next:*/
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    /*check if the two rows should switch place,
                    based on the direction, asc or desc:*/
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            //if so, mark as a switch and break the loop:
                            shouldSwitch= true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            //if so, mark as a switch and break the loop:
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    /*If a switch has been marked, make the switch
                    and mark that a switch has been done:*/
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    //Each time a switch is done, increase this count by 1:
                    switchcount ++;
                } else {
                    /*If no switching has been done AND the direction is "asc",
                    set the direction to "desc" and run the while loop again.*/
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }

    </script>
@endsection
