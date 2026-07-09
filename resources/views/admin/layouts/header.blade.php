        <!-- Header -->
        <header class="header">
            <div class="d-flex justify-content-between align-items-center w-100">
                <div>
                    <h4 class="mb-0">Dashboard</h4>
                    <small class="text-muted">Welcome back, Admin!</small>
                </div>
                
                <div class="d-flex align-items-center gap-3">
                    <button class="theme-toggle" onclick="toggleTheme()">
                        <i class="bi bi-moon-fill" id="theme-icon"></i>
                    </button>
                    
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="https://placehold.co/400" width="32" height="32" alt="Admin" class="rounded-circle me-2">
                            <span>Admin User</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <!-- <li><a class="dropdown-item" href="#">Logout</a></li> -->
                            <li>
                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </header>
