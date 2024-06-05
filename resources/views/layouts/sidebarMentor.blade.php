<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('mentor.dashboardeu') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Tableau de bord</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu
    </div>

    <!-- Nav Item - Recent Discussions -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('mentor.dashboard') }}">
            <i class="fas fa-fw fa-comments"></i>
            <span>Discussion récentes</span>
        </a>
    </li>

    <!-- Nav Item - Forum Categories -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('categorie.index') }}">
            <i class="fas fa-fw fa-folder"></i>
            <span>Catégorie de forum</span>
        </a>
    </li>

    <!-- Nav Item - Create Discussion -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('questions.create') }}">
            <i class="fas fa-fw fa-comments"></i>
            <span>Nouvelle discussion</span>
        </a>
    </li>

    <!-- Nav Item - Update Profile -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('profile.show') }}">
            <i class="fas fa-fw fa-user-edit"></i>
            <span>Mettre à jour profil</span>
        </a>
    </li>

    <!-- Nav Item - Notifications -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('notification.show') }}">
            <i class="fas fa-fw fa-bell"></i>
            <span>Notifications</span>
        </a>
    </li>

    <!-- Nav Item - Create Survey -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('sondage.create') }}">
            <i class="fas fa-fw fa-poll"></i>
            <span>Nouveau sondage</span>
        </a>
    </li>

    <!-- Nav Item - Student Mentorship -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('listeUser.index') }}">
            <i class="fas fa-fw fa-user-graduate"></i>
            <span>Étudiants mentorés</span>
        </a>
    </li>

    <!-- Nav Item - My Surveys -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('sondage.showForUser') }}">
            <i class="fas fa-fw fa-poll-h"></i>
            <span>Mes sondages</span>
        </a>
    </li>

    <!-- Nav Item - My Mentorships -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('meetings.index') }}">
            <i class="fas fa-fw fa-user-friends"></i>
            <span>Mes mentorats</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    <div class="sidebar-card d-none d-lg-flex">
        <!-- <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="..."> -->
        <!-- <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p> -->
        <!-- <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a> -->
    </div>

</ul>
