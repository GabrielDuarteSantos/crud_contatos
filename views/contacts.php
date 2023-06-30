<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="libs/bootstrap-5.3.0-dist/css/bootstrap.min.css">
        <script defer src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
        <script defer src="libs/bootstrap-5.3.0-dist/js/bootstrap.bundle.min.js"></script>
        <script defer src="views/scripts/contacts.js"></script>
        <title>Contatos</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    <body class="bg-dark text-light">
        <div class="container-fluid" style="padding-top: calc(var(--bs-gutter-x) * .5);">
            <div class="row">
                <div class="col-2">
                    <img src="images/logo_alphacode.png" alt="Logo" class="img-fluid" />
                </div>
                <div class="col-10 align-self-center">
                    <h1 class="text-info">Cadastro de contatos</h1>
                </div>
            </div>
        </div>
        <form id="contact-form" class="mt-2">
            <div class="container">
                <div class="row">
                    <div class="col-sm mt-3">
                        <label for="fullName-input" class="form-label">Nome completo</label>
                        <input type="text" class="form-control" id="fullName-input" name="full_name" required>
                    </div>
                    <div class="col-sm mt-3">
                        <label for="birthdate-input" class="form-label">Data de nascimento</label>
                        <input type="date" class="form-control" id="birthdate-input" name="birthdate" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm mt-3">
                        <label for="email-input" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email-input" name="email" required>
                    </div>
                    <div class="col-sm mt-3">
                        <label for="occupation-input" class="form-label">Profissão</label>
                        <input type="text" class="form-control" id="occupation-input" name="occupation" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm mt-3">
                        <label for="landline-input" class="form-label">Telefone para contato</label>
                        <input type="text" class="form-control" id="landline-input" name="landline_number">
                    </div>
                    <div class="col-sm mt-3">
                        <label for="phone-input" class="form-label">Celular para contato</label>
                        <input type="text" class="form-control" id="phone-input" name="phone_number">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <input class="form-check-input" type="checkbox" id="whatsapp-check" name="phone_number_has_whatsapp">
                        <label class="form-check-label" for="whatsapp-check">Número de celular possui Whatsapp</label>
                    </div>
                    <div class="col-6">
                        <input class="form-check-input" type="checkbox" id="email-notify-check" name="send_email_notifications">
                        <label class="form-check-label" for="email-notify-check">Enviar notificações por E-mail</label>
                    </div>
                    <div class="col-6">
                        <input class="form-check-input" type="checkbox" id="sms-notify-check" name="send_sms_notifications">
                        <label class="form-check-label" for="sms-notify-check">Enviar notificações por SMS</label>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </div>
                </div>
            </div>
        </form>
        <table class="table table-dark mt-5">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Data de nascimento</th>
                    <th>E-mail</th>
                    <th>Número para contato</th>
                </tr>
            </thead>
            <tbody id="contacts-list"></tbody>
        </table>
        <div class="container">
            <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 mt-5 border-top">
                <div>Termos | Políticas</div>
                <div>
                    &copy; Copyright 2023 | Desenvolvido por
                    <img src="images/logo_rodape_alphacode.png" alt="Logo rodapé" Style="height: 50px;" />
                </div>
                <div>&copy; Alphacode IT Solutions 2023</div>
            </footer>
        </div>
        <div class="toast bg-light text-dark" style="position: absolute; top: 10px; right: 10px;">
            <div class="toast-body"></div>
        </div>
    </body>
</html>