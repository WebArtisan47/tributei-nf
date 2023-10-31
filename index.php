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
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
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

                    <BR>

                    <div class="input-group">
                        <button class="btn btn-dark btn-round ml-auto" data-toggle="modal" data-target="#mymodal">Emitir
                            Nota Fiscal <i class="fa fa-plus"></i></button>
                    </div>
                    <BR>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Documentos Emitidos
                        </div>


                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Empresas</th>
                                        <th>Fornecedores</th>
                                        <th>Número do Pedido</th>
                                        <th>Valor da Nota Fiscal</th>
                                        <th>Status</th>
                                        <th>Download</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>R$162,700</td>
                                        <td>61</td>
                                        <td>Aguardando retorno</td>
                                        <td>Baixar Arquivo XML</td>
                                    </tr>
                                    <tr>
                                        <td>Garrett Winters</td>
                                        <td>Accountant</td>
                                        <td>R$162,700</td>
                                        <td>63</td>
                                        <td>Falha na Emissão</td>
                                        <td>Baixar Arquivo XML</td>
                                    </tr>
                                    <tr>
                                        <td>Ashton Cox</td>
                                        <td>Junior Technical Author</td>
                                        <td>R$162,700</td>
                                        <td>66</td>
                                        <td>Emitida</td>
                                        <td>Baixar Arquivo XML</td>
                                    </tr>
                                    <tr>
                                        <td>Cedric Kelly</td>
                                        <td>Senior Javascript Developer</td>
                                        <td>R$162,700</td>
                                        <td>22</td>
                                        <td>Emitida</td>
                                        <td>Baixar Arquivo XML</td>
                                    </tr>
                                    <tr>
                                        <td>Airi Satou</td>
                                        <td>Accountant</td>
                                        <td>R$162,700</td>
                                        <td>33</td>
                                        <td>Emitida</td>
                                        <td>Baixar Arquivo XML</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </main>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>