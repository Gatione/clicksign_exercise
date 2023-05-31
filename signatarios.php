<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css"
        integrity="sha512-WEQNv9d3+sqyHjrqUZobDhFARZDko2wpWdfcpv44lsypsSuMO0kHGd3MQ8rrsBn/Qa39VojphdU6CMkpJUmDVw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />

    <link rel="stylesheet" href="style.css?time<?php echo time(); ?>">

    <title>Composer teste</title>
</head>

<body>
    <header class="container">
        <a href="index.php">
            <button type="button" class="btn btn-info">Home</button>
        </a>

    </header>
    <main class="container">
        <div class="row">
            <div class="section">
                <div class="container">
                    <table id="myTable" class="table table-striped" style="color: #000; width: 100%;">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Autorização</th>
                                <th>Aniversário</th>
                                <th>Documentação</th>
                                <th>Email</th>
                                <th>Nome</th>
                                <th>Número de telefone</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Autorização</th>
                                <th>Aniversário</th>
                                <th>Documentação</th>
                                <th>Email</th>
                                <th>Nome</th>
                                <th>Número de telefone</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.4.js"
        integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js"
        integrity="sha512-C1zvdb9R55RAkl6xCLTPt+Wmcz6s+ccOvcr6G57lbm8M2fbgn2SUjUJbQ13fEyjuLViwe97uJvwa1EUf4F1Akw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"
        integrity="sha512-0XDfGxFliYJPFrideYOoxdgNIvrwGTLnmK20xZbCAvPfLGQMzHUsaqZK8ZoH+luXGRxTrS46+Aq400nCnAT0/w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>


    <script type="text/javascript">
        const table = $('#myTable').DataTable({
            ajax: "./actions.php?action=retrieveSigners",
            columns: [
                { data: "id" },
                { data: "auths" },
                { data: "birthday" },
                { data: "documentation" },
                { data: "email" },
                { data: "name" },
                { data: "phone_number" },
            ]
        });
    </script>
</body>

</html>