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
    <!-- <li class="nav-item active">
        <a class="nav-link" href="{{route('admin.dashboardeu')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Tableau de bord</span>
        </a>
    </li> -->

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Gestion
    </div>

    <!-- Nav Item - User Management -->
    
  <!-- Nav Item - Create Category -->
  <li class="nav-item">
        <a class="nav-link" href="{{ route('categorie.index') }}">
            <i class="fas fa-fw fa-folder-plus"></i>
            <span>Catégorie de forum</span>
        </a>
    </li>

    <!-- Nav Item - Add Student -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('student.dashboard') }}">
            <i class="fas fa-fw fa-user-graduate"></i>
            <span>Discussion récentes</span>
        </a>
    </li>

     <!-- Nav Item - New Discussion -->
     <li class="nav-item">
        <a class="nav-link" href="{{ route('questions.create') }}">
            <i class="fas fa-fw fa-comments"></i>
            <span>Nouvelle discussion</span>
        </a>
    </li>

    <!-- Nav Item - Statistics -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('sondage.showForUser') }}">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Sondage des Mentor</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('listeUser.index')}}">
            <i class="fas fa-fw fa-user"></i>
            <span>Mes Mentors</span>
        </a>
    </li>

     <!-- Nav Item - Edit Profile -->
     <li class="nav-item">
        <a class="nav-link" href="{{ route('profile.show') }}">
            <i class="fas fa-fw fa-user-edit"></i>
            <span>Mettre à jour profil</span>
        </a>
    </li>

    <!-- Nav Item - Add Mentor -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('mentor.request') }}">
            <i class="fas fa-fw fa-user-plus"></i>
            <span>DM pour etre mentor</span>
        </a>
    </li>

  

   

    <!-- Nav Item - Manage Requests -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('notification.show') }}">
            <i class="fas fa-fw fa-tasks"></i>
            <span>Notifications</span>
        </a>
    </li>

   

    <!-- Nav Item - Test -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-vial"></i>
            <span>Assistance</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    <!-- <div class="sidebar-card d-none d-lg-flex">
        <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
        <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
        <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
    </div> -->

</ul>
