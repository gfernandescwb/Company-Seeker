<nav class="navbar navbar-default">
    <div class="container-fluid">
        
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                data-target="#navbar-content" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route("home") }}">Company Seeker</a>
        </div>

        <div class="collapse navbar-collapse" id="navbar-content">
            <ul class="nav navbar-nav navbar-right">
                @guest
                    <li>
                        <a href="{{ route("login.form") }}">Login</a>
                    </li>
    
                    <li>
                        <a href="{{ route("signup.form") }}">Sign up</a>
                    </li>
                @else
                    <li>
                        <a>
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                    </li>
    
                    <li>
                        <a href="{{ route("logout") }}" class="nav-link">Logout</a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
