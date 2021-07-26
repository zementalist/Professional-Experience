<nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container-fluid">
                <a class="navbar-brand" id="website-logo" href="/">{{config('app.name')}}</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
              
                <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                  <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                      <a class="nav-link" href="/">Home</span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="/FAQ">FAQ</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="/contact">Contact Us</a>
                    </li>
                    @guest
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                        </a>
  
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                    @endguest
                  </ul>
                </div>
        </div>
    </nav>
    