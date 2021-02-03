<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="/"><img src="/assets/header_logo.png" width="120" alt="logo"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>

            </ul>
            {{--  Auth navigation  --}}
            <ul class="navbar-nav ml-auto">
                @if( Cookie::get('AuthToken') == '')
                    <li class="nav-item">
                        <a class="nav-link" href="/login"><i class="fas fa-sign-in-alt"></i>Login</a>
                    </li>
                @endif
                    @if( Cookie::get('AuthToken') != '')
                        <li class="nav-item">
                            <a class="nav-link" href="/profile/edit"><i class="fas fa-cog"></i>Profiel aanpassen</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/logout"><i class="fas fa-sign-out-alt"></i>Logout</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-secondary text-white" href="http://52.157.152.190:3000" target="_blank"><i class="fas fa-chart-bar"></i>Data Portaal <i class="fas fa-external-link-alt"></i></a>
                        </li>
                    @endif

            </ul>
        </div>
    </div>
</nav>
