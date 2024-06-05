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
        <a class="nav-link" href="{{route('admin.dashboardeu')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Tableau de bord</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Gestion
    </div>

    <!-- Nav Item - User Management -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('listeUser.index')}}">
            <i class="fas fa-fw fa-user"></i>
            <span>Gérer Utilisateur</span>
        </a>
    </li>

    <!-- Nav Item - Add Mentor -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('register.mentor.form')}}">
            <i class="fas fa-fw fa-user-plus"></i>
            <span>Ajouter Mentor</span>
        </a>
    </li>

    <!-- Nav Item - Add Student -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('register.student.form')}}">
            <i class="fas fa-fw fa-user-graduate"></i>
            <span>Ajouter Étudiant</span>
        </a>
    </li>

 <!-- Nav Item - Questions -->
 <li class="nav-item">
        <a class="nav-link" href="{{ route('questionAdmin.index') }}">
            <i class="fas fa-fw fa-question-circle"></i>
            <span>Questions</span></a>
    </li>


    <!-- Nav Item - Edit Profile -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('profile.show') }}">
            <i class="fas fa-fw fa-user-edit"></i>
            <span>Modifier Profil</span>
        </a>
    </li>
<!-- Nav Item - Manage Reports -->
<li class="nav-item">
    <a class="nav-link" href="{{route('reported.admin')}}">
        <i class="fas fa-fw fa-flag"></i>
        <span>Gérer les signalements</span>
    </a>
</li>

  

<li class="nav-item">
    <a class="nav-link" href="{{ route('notifications.index') }}">
        <i class="fas fa-fw fa-bell"></i>
        <span>Notifications</span>
    </a>
</li>


    <!-- Nav Item - Manage Requests -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-tasks"></i>
            <span>Gérer Demande</span>
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
        <!-- <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
        <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
        <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a> -->
    </div>

</ul>
