<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Lisocash - Dashboard Administrateur</title>

    <!-- Link Cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"/>
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
   

</head>
<body>

    <div class="container-scroller">

        <!-- Navbar -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
                <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                    <!-- <a class="navbar-brand brand-logo mr-5" href="/"><img src="images/logo.svg" class="mr-2" alt="logo"></a> -->
                    <!-- <a class="navbar-brand brand-logo-mini" href="index.html"><img src="images/logo-mini.svg" alt="logo"></a> -->
                    <a class="navbar-brand brand-logo mr-5" href="/">LISOCASH </a>
                </div>
                <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                    <!-- <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                        <span><i class="fa-solid fa-bars"></i></span>
                    </button> -->
                    <ul class="navbar-nav navbar-nav-right">

                        <!-- DECONNEXION -->
                    <li class="nav-item"><a href="javascript:void(0)" class="btn btn-outline-danger"
                                      onclick="event.preventDefault(); document.getElementById('logout-form').submit()"><i
                                          class="ti-power-off "></i>Déconnexion</a></li>
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="">
                                  @csrf
                              </form>
                              <!-- END DECONNEXION  -->




                        <!-- <li class="nav-item dropdown">
                        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                            <i class="fa-solid fa-bell"></i>
                            <span class="count"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                            <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                            <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-success">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <h6 class="preview-subject font-weight-normal">Application Error</h6>
                                <p class="font-weight-light small-text mb-0 text-muted">
                                Just now
                                </p>
                            </div>
                            </a>

                        </div>
                        </li>

                        <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                            <img src="images/faces/face28.jpg" alt="profile">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">

                            <a class="dropdown-item">

                                Se Deconnecter
                            </a>
                            <a href="javascript:void(0)" class=""
                                      onclick="event.preventDefault(); document.getElementById('logout-form').submit()"><i
                                          class="ti-power-off "></i><i class="fa-solid fa-right-from-bracket"></i>Se Deconnecter</a>


                        </div>
                        </li> -->
                    </ul>
                </div>
        </nav>

        <div class="container-fluid page-body-wrapper">

            <!-- SideBar -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav" id="nav">
                    <li class="nav-item ">
                        <a class="nav-link" href="/dashboard">
                            <i class="fa-solid fa-gauge mr-3"></i>
                            <span class="menu-title">Statistiques</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard/liste_clients" aria-expanded="false" aria-controls="auth">
                            <i class="fa-solid fa-users mr-3"></i>
                            <span class="menu-title">Clients</span>
                        </a>

                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard/liste_employes" aria-expanded="false" aria-controls="auth">
                            <i class="fa-solid fa-users mr-3"></i>
                            <span class="menu-title">Utilisateurs</span>
                        </a>

                    </li>
                   
                   


                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa-regular fa-user mr-3"></i>
                            <span class="menu-title">Distributeurs</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa-regular fa-user mr-3"></i>
                            <span class="menu-title">Marchands</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa-regular fa-user mr-3"></i>
                            <span class="menu-title">Agences</span>
                        </a>
                    </li>

                </ul>
            </nav>

            <!-- Content -->
            @yield('content')



        </div>
    </div>

        <script src="{{ asset('assets/js/app.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
        <script src="//cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>

        <script type="text/javascript">

            $("#nav>li").each(function() {
                var navItem = $(this);
                if (navItem.find("a").attr("href") == location.pathname) {
                navItem.addClass("active");
                }
            });


            $(document).ready( function () {
                $('#client_datatable').DataTable();
            } );

           
    $(document).ready(function() {
        $('.selectpicker').selectpicker();
    });

      </script>
</body>
</html>