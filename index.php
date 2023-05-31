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

    <link rel="stylesheet" href="style.css?time<?php echo time(); ?>">

    <title>Composer teste</title>
</head>

<body>
    <header class="container">
        <button type="button" class="btn btn-info" onclick="showSendPdfModal()">Enviar pdf</button>
        <button type="button" class="btn btn-info" onclick="showCreateSignerModal()">Criar signatário</button>
        <button type="button" class="btn btn-info" onclick="showSendDocumentSignerModal()">
            Mandar documento para assinar
        </button>
        <button type="button" class="btn btn-info" onclick="showSendSignersCsvModal()">
            Criar signatários por csv
        </button>
        <a href="signatarios.php">
            <button type="button" class="btn btn-info">Visualizar signatários</button>
        </a>

    </header>
    <main class="container">
        <div class="row">

            <div class="col" id="content">
                <form method="post" id="uploadFIleForm">
                    <h2>bucket-brunorm</h2>
                    <label for="fileInput" class="picture"><span class="fileImg">Upload de foto</span></label>
                    <div>

                        <input type="file" name="file" id="fileInput">
                        <p id="fileName"></p>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>

                <form id="formSignedDocuments">
                    <h3>Documentos Assinados</h3>
                    <select id="signedDocuments" name="url" class="form-select"></select>
                    <button type="submit" class="btn btn-primary">Baixar documento selecionado</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div id="listar" class="my-galeria"></div>
                <div id="listSignedDocuments" class="document-galeria"></div>
                <div id="advice"></div>
            </div>
        </div>




    </main>

    <section class="popupModal" id="sendPdfPopup">
        <div class="popup">
            <span class="close">&times;</span>
            <h2>Enviar pdf</h2>
            <input type="file" name="pdfInput" id="pdfInput">
            <button onclick="createDocument()" class="btn btn-primary">Enviar</button>
        </div>

    </section>

    <section class="popupModal" id="uploadSignersCsvPopup">
        <form method="post" id="signersCsvForm" class="popup">
            <span class="close">&times;</span>
            <h2>Enviar csv</h2>
            <input type="file" name="csvFileInput" id="csvFileInput">
            <button class="btn btn-primary">Enviar</button>
        </form>

    </section>

    <section class="popupModal" id="signerPopup">
        <form method="post" id="signatarioForm" class="popup">
            <span class="close">&times;</span>

            <h2>Criar signatário</h2>

            <div class="form-group">
                <label for="name" class="form-label">full name</label>
                <input type="text" name="name" class="form-style form-control" placeholder="Full Name" id="name" />
                <i class="input-icon uil uil-user"></i>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">email</label>
                <input type="text" name="email" class="form-style form-control" placeholder="email@example.com"
                    id="email" />
                <i class="input-icon uil uil-user"></i>
            </div>

            <div class="form-group">
                <label for="phone" class="form-label">phone</label>
                <input type="text" name="phone" class="form-style cel-sp-mask form-control" placeholder="phone"
                    id="phone" />
                <i class="input-icon uil uil-user"></i>
            </div>

            <div class="form-group">
                <label for="cpf" class="form-label">cpf</label>
                <input type="text" name="cpf" class="form-style cpf-mask form-control" placeholder="000.000.000-00"
                    id="cpf" />
                <i class="input-icon uil uil-user"></i>
            </div>

            <div class="form-group">
                <label for="birthday" class="form-label">birthday</label>
                <input type="text" name="birthday" class="form-style date-mask form-control" placeholder="dd/mm/aaaa"
                    id="birthday" />
                <i class="input-icon uil uil-user"></i>
            </div>

            <div>
                <div>
                    <p>Meio de notificação</p>
                </div>
                <label>Email</label>
                <input type="radio" name="auth" value="email" id="emailNotifications" checked>

                <label>WhatsApp</label>
                <input type="radio" name="auth" value="whatsapp" id="whatsAppNotifications">
            </div>
            <button type="submit" class="btn btn-primary">Criar signatário</button>

        </form>

    </section>

    <section class="popupModal" id="sendDocumentSigner">
        <form id="sendDocumentSigner" class="popup">
            <span class="close">&times;</span>
            <h2>Enviar documento ao Signatário</h2>

            <label for="document_key" id="document_key">Documento</label>
            <select name="document_key" id="documents" class="form-select"></select>

            <label for="signer_key" id="signer_key">Signatário</label>
            <select name="signer_key" id="signers" class="form-select"></select>

            <button type="submit" class="btn btn-primary">Adicionar signatário ao documento</button>
        </form>


    </section>

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


    <script type="text/javascript">

        async function retrieveAdvice() {
            const req = await fetch("https://api.adviceslip.com/advice")
            const res = await req.json()

            return res.slip.advice
        }


        function deleteFoto(file_name) {

            $.ajax({
                url: `actions.php?action=delete&file_name=${file_name}`,
                method: "get",
                processData: false,
                contentType: false,
                success: response => {
                    if (response.includes("success")) {
                        Swal.fire({
                            icon: "success",
                            title: "Good job!",
                            text: response,
                        }).then(() => {
                            loadBucketObjects()
                        })
                    } else {
                        Swal.fire({
                            icon: "Error",
                            title: "Erro",
                            text: response,
                        })
                    }
                }
            })


        }

        function downloadFoto(file_name) {

            window.location.href = `actions.php?action=download&file_name=${file_name}`

        }

        function sendTelegram(file_name) {
            $.ajax({
                url: `actions.php?action=sendTelegram&file_name=${file_name}`,
                method: "get",
                processData: false,
                contentType: false,
                success: response => {
                    if (response.includes("sucesso")) {
                        Swal.fire({
                            icon: "success",
                            title: "Good job!",
                            text: response,
                        })
                    } else {
                        Swal.fire({
                            icon: "Error",
                            title: "Erro",
                            text: response,
                        })
                    }
                }
            })
        }

        $("#uploadFIleForm").on("submit", async (e) => {
            e.preventDefault()

            const advice = await retrieveAdvice()
            const adviceAlert = Swal.fire(advice)

            const form = new FormData();
            const inputElement = document.querySelector('input[type=file]');
            const file = inputElement.files[0];
            form.append('file', file);

            $.ajax({
                url: "actions.php?action=upload",
                method: "post",
                data: form,
                processData: false,
                contentType: false,
                success: (response) => {
                    adviceAlert.close()
                    if (response.includes("Uploaded")) {
                        Swal.fire({
                            icon: "success",
                            title: "Good job!",
                            text: response,
                        }).then(() => {
                            loadBucketObjects()
                        })
                    } else {
                        Swal.fire({
                            icon: "Error",
                            title: "Erro",
                            text: response,
                        })
                    }
                }
            })

        })


        async function loadBucketObjects() {
            const advice = await retrieveAdvice()

            $("#advice").text(advice)


            $.ajax({
                url: "actions.php?action=list",
                method: "get",
                processData: false,
                contentType: false,
                success: async (response) => {
                    const files = response.split("*-*")

                    // $("#listar").html("")

                    files.map(file => {
                        const file_name = file
                        const temporary = file.split(".")
                        const file_extension = temporary.pop()

                        if (file_extension.toLowerCase() == "jpg" || file_extension.toLowerCase() == "jpeg" || file_extension.toLowerCase() == "png") {
                            $.ajax({
                                url: `actions.php?action=get&file_name=${file_name}`,
                                method: "get",
                                processData: false,
                                contentType: false,
                                success: async (url) => {

                                    const f_name = file_name.split("/").pop() + `<div><button class='btn btn-success' onclick=downloadFoto('${file_name}')>Download</button> <button class='btn btn-danger' onclick=deleteFoto('${file_name}')>Delete</button> <button onclick=sendTelegram('${file_name}') class='btn btn-primary'>Enviar para o Telegram</button></div>`


                                    $("#listar").append(`
                                        <a href="${url}" title="${f_name}">
                                            <figure class="listFigure">
                                                <img src="${url}" >
                                            </figure>
                                        </a>
                                        `
                                    )

                                    $('.my-galeria').magnificPopup({
                                        delegate: 'a',
                                        type: 'image',
                                        tLoading: 'Loading image #%curr%...',
                                        mainClass: 'mfp-img-mobile',
                                        gallery: {
                                            enabled: true,
                                            navigateByImgClick: true,
                                            preload: [0, 1]
                                        }
                                    });
                                    $("#advice").text("")
                                }
                            })
                        }
                    })

                }
            })
        }

        loadBucketObjects()

        async function loadSignedObjects() {

            $.ajax({
                url: "actions.php?action=listSignedDocuments",
                method: "get",
                processData: false,
                contentType: false,
                success: async (response) => {
                    const files = response.split("*-*")

                    $("#signedDocuments").html("<option value='DEFAULT' hidden>Selecione um Documento</option>")

                    files.map(file => {
                        const file_name = file
                        const temporary = file.split(".")
                        const file_extension = temporary.pop()

                        if (file_extension.toLowerCase() == "pdf") {
                            $.ajax({
                                url: `actions.php?action=get&file_name=${file_name}`,
                                method: "get",
                                processData: false,
                                contentType: false,
                                success: async (url) => {
                                    const f_name = file_name.split("/").pop()
                                    // $('<option>').val(file_name).text(`${f_name}`).appendTo('#signedDocuments');
                                    $('<option>').val(url).text(`${f_name}`).appendTo('#signedDocuments');
                                    $("#listSignedDocuments").append(`
                                        <a href="${url}" title="${f_name}">
                                            <figure class="listFigure">
                                                <div class="iframeSpace">
                                                    <div></div>
                                                    <iframe src="${url}" frameborder="0" id="iframe"></iframe>
                                                </div>
                                            </figure>
                                        </a>
                                        `
                                    )
                                    $('.document-galeria').magnificPopup({
                                        delegate: 'a',
                                        type: 'iframe',
                                        tLoading: 'Loading image #%curr%...',
                                        mainClass: 'mfp-img-mobile',
                                        gallery: {
                                            enabled: true,
                                            navigateByImgClick: true,
                                            preload: [0, 1]
                                        }
                                    });
                                }
                            })
                        }
                    })

                }
            })
        }

        loadSignedObjects()

        $("#formSignedDocuments").on("submit", async (e) => {
            e.preventDefault()

            const url = $("#signedDocuments").val()
            const file_name = $("#signedDocuments :selected").text()

            if (url == "DEFAULT" || url == null) {
                return Swal.fire(
                    'Fail',
                    "Selecione um documento",
                    'error'
                )
            }

            ////

            Swal.fire({
                icon: "info",
                title: "Confirmar o download?",
                showDenyButton: true,
                html: `<iframe src="${url}" frameborder="0" id="iframe"></iframe>`,
                confirmButtonColor: '#3085d6',
                confirmButtonText: "Confirmar",
                denyButtonText: `Cancelar`,
            }).then((result) => {
                if (result.isConfirmed) {
                    downloadPdf();
                    $(".popupModal").css("display", "none")
                }
            })

            ////

            // Função para realizar o download do PDF
            const downloadPdf = () => {
                const link = document.createElement('a');
                link.href = `actions.php?url=${encodeURIComponent(url)}&file_name=${file_name}&action=downloadSignedDocument`;
                link.target = '_blank';
                link.click();
            };

        })

        function showSendPdfModal() {
            $("#sendPdfPopup").css("display", "flex")
        }


        function showSendSignersCsvModal() {
            $("#uploadSignersCsvPopup").css("display", "flex")
        }


        function showCreateSignerModal() {
            $("#signerPopup").css("display", "flex")
        }


        function showSendDocumentSignerModal() {
            $("#sendDocumentSigner").css("display", "flex")
        }


        document.addEventListener("click", (e) => {
            closePopupModal(e)
        })

        function closePopupModal(e) {
            for (let i = 0; i < e.target.classList.length; i++) {
                if (e.target.classList[i] == "popupModal" || e.target.classList[i] == "close") {
                    $(".popupModal").css("display", "none")
                }
            }
            if (e == "close") {
                $(".popupModal").css("display", "none")
            }
        }

    </script>

    <script>

        const inputFile = document.querySelector("#fileInput");
        const pictureImage = document.querySelector(".fileImg");
        const pictureImageTxt = "Upload de imagem";
        pictureImage.innerHTML = pictureImageTxt;

        inputFile.addEventListener("change", function (e) {
            const inputTarget = e.target;
            const file = inputTarget.files[0];

            if (file) {
                const reader = new FileReader();

                reader.addEventListener("load", function (e) {
                    const readerTarget = e.target;

                    const img = document.createElement("img");
                    img.src = readerTarget.result;
                    img.classList.add("filePreview");

                    pictureImage.innerHTML = "";
                    pictureImage.appendChild(img);

                    $("#fileName").text(file.name)
                });

                reader.readAsDataURL(file);
            } else {
                pictureImage.innerHTML = pictureImageTxt;
            }
        });



    </script>

    <script type="text/javascript">

        $(".date-mask").mask('00/00/0000');
        $(".cpf-mask").mask('000.000.000-00');
        $(".cel-sp-mask").mask('(00) 00000-0000');

        function createDocument() {


            let formData = new FormData()
            formData.append("file", $("#pdfInput").prop("files")[0])

            $.ajax({
                url: 'actions.php?action=createDocument',
                method: 'POST',
                contentType: false,
                processData: false,
                data: formData,
                success: (response) => {
                    response = JSON.parse(response)
                    if (Array.isArray(response.errors)) {
                        Swal.fire(
                            'Fail',
                            response.errors,
                            'error'
                        )
                    } else {
                        Swal.fire(
                            'Good job!',
                            "Arquivo criado com sucesso",
                            'success'
                        ).then(() => {
                            listDocuments()
                            $(".popupModal").css("display", "none")
                        })
                    }

                },
                error: function (xhr, status, error) {
                    console.error('Erro ao criar documento: ' + error);
                }
            })
        }


        $("#signersCsvForm").on("submit", (event) => {
            event.preventDefault()

            const file = $("#csvFileInput").prop("files")[0]

            const extension = file.name.split(".").pop()
            if (extension.toLowerCase() !== "csv") {
                return Swal.fire({
                    icon: "error",
                    title: "Fail",
                    html: "Erro: formato de arquivo não é .csv"
                })
            }

            const reader = new FileReader();

            reader.onload = (e) => {
                const contents = e.target.result;

                processSingersCSV(contents)
            }

            reader.readAsText(file);


            function processSingersCSV(csv) {
                const lines = csv.split('\n');
                let isData = false;
                let isHeader = false;
                let header = [];
                const data = [];

                lines.forEach((line, index) => {
                    let cells = line.split(',');

                    cells.map((cell, i) => {
                        cell = cell.split("\r")[0]
                        cells.splice(i, 1, cell)
                    })


                    if (isData) {
                        let obj = {};
                        // header.forEach((k, i) => { k != "auths" ? obj[k] = cells[i] : obj[k] = [cells[i]] })
                        // header.forEach((k, i) => { k != "has_documentation" ? obj[k] = cells[i] : cells[i] == "true" ? obj[k] = true : obj[k] = false })
                        header.forEach((k, i) => { obj[k] = cells[i] })
                        data.push(obj);
                    } else if (isHeader) {
                        header = cells;
                        isData = true;
                    } else if (cells.every((cell) => cell === "")) {
                        isHeader = true;
                    }

                });

                // data.map((signer, index) => {
                //     $.ajax({
                //         url: 'actions.php?action=createSigner',
                //         method: "post",
                //         contentType: "application/json",
                //         data: JSON.stringify(signer),
                //         success: (response) => {
                //             console.log(response);
                //         },
                //         error: function (xhr, status, error) {
                //             console.error('Erro ao criar documento: ' + error);
                //         }
                //     })
                // })

                $.ajax({
                    url: 'actions.php?action=createSigners',
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify(data),
                    success: (response) => {
                        if (response.includes("success")) {
                            Swal.fire(
                                'Good job!',
                                "Signatários criados com sucesso",
                                'success'
                            ).then(() => {
                                listSigners()
                                $(".popupModal").css("display", "none")
                            })
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Fail",
                                html: response
                            })
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Erro ao criar documento: ' + error);
                    }
                })
            }
        })



        $("#signatarioForm").on("submit", (e) => {
            e.preventDefault()

            $.ajax({
                url: 'actions.php?action=createSigner',
                method: "post",
                data: $("#signatarioForm").serialize(),
                success: (response) => {
                    response = JSON.parse(response)
                    if (Array.isArray(response.errors)) {
                        Swal.fire(
                            'Fail',
                            response.errors,
                            'error'
                        )
                    } else {
                        Swal.fire(
                            'Good job!',
                            "Signatário criado com sucesso",
                            'success'
                        ).then(() => {
                            listSigners()
                            $(".popupModal").css("display", "none")
                        })
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Erro ao criar documento: ' + error);
                }
            })

        })

        function listDocuments() {
            $.ajax({
                url: 'actions.php?action=listDocuments',
                method: "get",
                success: (response) => {
                    response = JSON.parse(response)

                    const documentos = response.documents

                    $("#documents").html("<option value='DEFAULT' hidden>Select a Document</option>")

                    documentos.map((document) => {
                        if (document.status != "canceled") {
                            $('<option>').val(document.key).text(`${document.filename} - ${document.status}`).appendTo('#documents');
                        }
                    })
                },
                error: function (xhr, status, error) {
                    console.error('Erro ao criar documento: ' + error);
                }
            })
        }
        listDocuments()

        function listSigners() {
            $.ajax({
                url: 'actions.php?action=listSigners',
                method: "get",
                success: (response) => {
                    response = JSON.parse(response)

                    const signers = response.signers

                    $("#signers").html("<option value='DEFAULT' hidden>Select a Signer</option>")

                    signers.map((signer) => {
                        $('<option>').val(signer.key).text(`${signer.name} - ${signer.auths[0]}`).appendTo('#signers');
                    })
                },
                error: function (xhr, status, error) {
                    console.error('Erro ao criar documento: ' + error);
                }
            })
        }
        listSigners()

        $("#sendDocumentSigner").on("submit", (e) => {
            e.preventDefault()

            if ($("#documents :selected").text().includes("closed")) {

            }

            $.ajax({
                url: 'actions.php?action=sendDocumentSigner',
                method: "post",
                data: $("#sendDocumentSigner").serialize(),
                success: (response) => {
                    response = JSON.parse(response)
                    const request_signature_key = response.list.request_signature_key

                    if ($("#signers :selected").text().includes("email")) {

                        $.ajax({
                            url: 'actions.php?action=notifyByEmail',
                            method: "post",
                            data:
                                `request_signature_key=${request_signature_key}`,
                            success: (response) => {
                                if (response == "") {
                                    Swal.fire(
                                        'Good job!',
                                        "Documento enviado ao email do signatário",
                                        'success'
                                    ).then(() => {
                                        listDocuments()
                                        $(".popupModal").css("display", "none")
                                    })
                                } else {
                                    response = JSON.parse(response)
                                    Swal.fire(
                                        'Fail',
                                        response.errors,
                                        'error'
                                    )
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error('Erro ao criar documento: ' + error);
                            }
                        })

                    } else {
                        $.ajax({
                            url: 'actions.php?action=notifyByWhatsApp',
                            method: "post",
                            data:
                                `request_signature_key=${request_signature_key}`,
                            success: (response) => {
                                if (response == "") {
                                    Swal.fire(
                                        'Good job!',
                                        "Documento enviado ao WhatsApp do signatário",
                                        'success'
                                    ).then(() => {
                                        listDocuments()
                                        $(".popupModal").css("display", "none")
                                    })
                                } else {
                                    response = JSON.parse(response)
                                    Swal.fire(
                                        'Fail',
                                        response.errors,
                                        'error'
                                    )
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error('Erro ao criar documento: ' + error);
                            }
                        })
                    }


                },
                error: function (xhr, status, error) {
                    console.error('Erro ao criar documento: ' + error);
                }
            })

        })

    </script>
</body>

</html>

<!-- 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 -->