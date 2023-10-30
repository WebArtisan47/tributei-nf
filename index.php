<!DOCTYPE html>
<html lang="PT-BR">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Emissão de notas Fiscais</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand ps-3" href="index.html">Emissão de notas Fiscais</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                
                <?php include('menu.php');?>
                            
                    
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">   </h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Emissão de notas Fiscais</li>
                        </ol>
                        
                        <div class="input-group">
            
            <!--Filtros-->
            <!--Filtros-->
            <!--Filtros-->
            <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#produtos">
            Adicionar <i class="fa fa-plus"></i></button>

    
          </div>
<BR>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Lista de notas fiscais Emitidas
                            </div>

                            
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>EMPRESAS</th>
                                            <th>FORNECEDORES</th>
                                            <th>VALOR DA NOTA FISCAL</th>
                                            <th>PEDIDO</th>
                                            <th>STATUS</th>
                                            <th>DOWNLOAD</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <tr>
                                            <td>Tiger Nixon</td>
                                            <td>System Architect</td>
                                            <td>R$162,700</td>
                                            <td>61</td>
                                            <td><span class="badge badge-warning text-primary">Aguardando retorno</span></td>
                                            <td>BAIXAR XML</td>
                                        </tr>
                                        <tr>
                                            <td>Garrett Winters</td>
                                            <td>Accountant</td>
                                            <td>R$162,700</td>
                                            <td>63</td>
                                            <td><span class="badge badge-warning text-primary">Falha na Emissão</span></td>
                                            <td>BAIXAR XML</td>
                                        </tr>
                                        <tr>
                                            <td>Ashton Cox</td>
                                            <td>Junior Technical Author</td>
                                            <td>R$162,700</td>
                                            <td>66</td>
                                            <td><span class="badge badge-warning text-primary">Emitida</span></td>
                                            <td>BAIXAR XML</td>
                                        </tr>
                                        <tr>
                                            <td>Cedric Kelly</td>
                                            <td>Senior Javascript Developer</td>
                                            <td>R$162,700</td>
                                            <td>22</td>
                                            <td><span class="badge badge-warning text-primary">Emitida</span></td>
                                            <td>BAIXAR XML</td>
                                        </tr>
                                        <tr>
                                            <td>Airi Satou</td>
                                            <td>Accountant</td>
                                            <td>R$162,700</td>
                                            <td>33</td>
                                            <td><span class="badge badge-warning text-primary">Emitida</span></td>
                                            <td>BAIXAR XML</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted"></div>
                            <div>
                                <a href="#"></a>
                                &middot;
                                <a href="#"></a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>