@extends('dashboard.admin.layouts.app')
@section('title',"Dashboard")
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">

            <!-- Statistiques -->
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                            <h3 class="font-weight-bold">Bienvenue Joe</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="card rounded float-start w-100">
                        <img src="https://images.pexels.com/photos/50987/money-card-business-credit-card-50987.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="card-img-top h-100" alt="...">
                        <div class="card-body">

                        </div>
                    </div>
                </div>
                <div class="col-md-6 grid-margin transparent">
                    <div class="row">
                        <div class="col-md-6 mb-4 stretch-card transparent">
                            <div class="card card-tale">
                            <div class="card-body">
                                <p class="mb-4">Nombre de clients</p>
                                <p class="fs-30 mb-2">4006</p>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4 stretch-card transparent">
                            <div class="card card-dark-blue">
                            <div class="card-body">
                                <p class="mb-4">Nombre de Distributeur</p>
                                <p class="fs-30 mb-2">614</p>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                            <div class="card card-light-blue">
                                <div class="card-body">
                                    <p class="mb-4">Nombre de Transaction</p>
                                    <p class="fs-30 mb-2">34040</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 stretch-card transparent">
                            <div class="card card-light-danger">
                                <div class="card-body">
                                    <p class="mb-4">Nombre
                                    <p class="fs-30 mb-2">33</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Demande Client, Distributeur -->
            <div class="row">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                    <div class="card-body">
                        <p class="card-title mb-0">Demande d'ahésion Client</p>
                        <div class="table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead>
                            <tr>
                                <th>N° de compte</th>
                                <th>Nom et Prénoms</th>
                                <th>Date d'inscription</th>
                                <th>Statut</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="font-weight-bold">C001</td>
                                <td>Search Engine Marketing</td>
                                <td>21 Sep 2018</td>
                                <td class="font-weight-medium"><div class="badge badge-success w-100">Valider</div></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">C002</td>
                                <td>Pay Per Click Advertising</td>
                                <td>30 Jun 2018</td>
                                <td class="font-weight-medium"><div class="badge badge-warning w-100">En cours</div></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">C003</td>
                                <td>E-Mail Marketing</td>
                                <td>01 Nov 2018</td>
                                <td class="font-weight-medium"><div class="badge badge-danger w-100">Refuser</div></td>
                            </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                    <div class="card-body">
                        <p class="card-title mb-0">Demande d'ahésion Distributeur</p>
                        <div class="table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead>
                            <tr>
                                <th>N° de compte</th>
                                <th>Nom et Prénoms</th>
                                <th>Date de demande</th>
                                <th>Statut</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="font-weight-bold">D001</td>
                                <td>Search Engine Marketing</td>
                                <td>21 Sep 2018</td>
                                <td class="font-weight-medium"><div class="badge badge-success w-100">Valider</div></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">D002</td>
                                <td>E-Mail Marketing</td>
                                <td>01 Nov 2018</td>
                                <td class="font-weight-medium"><div class="badge badge-warning w-100">En Cours</div></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">D003</td>
                                <td>E-Mail Marketing</td>
                                <td>01 Nov 2018</td>
                                <td class="font-weight-medium"><div class="badge badge-danger w-100">Refuser</div></td>
                            </tr>

                            </tbody>
                        </table>
                        </div>
                    </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">

                    <!-- Transaction recente -->
                    <div class="card">
                        <div class="card-body">
                                <p class="card-title">Transactions recentes</p>
                                <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                    <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6"></div>
                                            <div class="col-sm-12 col-md-6"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table id="example" class="display expandable-table dataTable no-footer" style="width: 100%;" role="grid">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="select-checkbox sorting_disabled" rowspan="1" colspan="1" aria-label="Quote#" style="width: 89px;">#</th>
                                                            <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" style="width: 97px;">N° de transacation</th>
                                                            <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 118px;">Destinateur</th>
                                                            <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 111px;">Beneficitaire</th>
                                                            <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 79px;">Montant</th>
                                                            <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 97px;">Date</th>
                                                            <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 79px;">Statut</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>01</td>
                                                            <td>TR001</td>
                                                            <td>Koné Zakaria</td>
                                                            <td>Atchin Parfait</td>
                                                            <td>$1200</td>
                                                            <td>16/02/2023</td>
                                                            <td><div class="badge badge-danger w-100">Refuser</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td>02</td>
                                                            <td>TR002</td>
                                                            <td>Business type 2</td>
                                                            <td>Jesse Thomas</td>
                                                            <td>$1200</td>
                                                            <td>25/04/2020</td>
                                                            <td><div class="badge badge-success w-100">Valider</div></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>

                    <footer class="footer">
                        <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021.  Premium <a href="" target="_blank">Bootstrap admin template</a> from BootstrapDash. All rights reserved.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted &amp; made with <i class="ti-heart text-danger ml-1"></i></span>
                        </div>
                    </footer>

                </div>
            </div>

        </div>
    </div>
@endsection
