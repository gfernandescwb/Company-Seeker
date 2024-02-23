@extends('layouts.app')

@section('title', 'New company')

@section('content')

    <main class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form enctype="multipart/form-data">
                            @csrf

                            <div class="form-group text-center">
                                <h2 class="text-center">New company 🏙️</h2>

                                <hr>

                                <h4>Register a new company through the form below 👇</h4>
                            </div>

                            <input type="text" name="user_id" value="{{ Auth::user()->id }}" hidden aria-hidden="true">

                            <div class="form-group">
                                <label for="companyName">Company name:</label>
                                <input type="text" class="form-control" name="name" id="companyName" required>
                            </div>

                            <div class="form-group" style="margin-bottom: 2rem;">
                                <label for="companyLogo">Logo</label>
                                <input name="logo" type="file" id="companyLogo"
                                    accept="image/jpeg, image/jpg, image/png, image/gif">
                            </div>

                            <div class="form-group">
                                <label for="companyPostalCode">Postal code (CEP):</label>
                                <input type="text" class="form-control" name="cep" id="companyPostalCode"
                                    placeholder="XXXXX-XXX" required maxlength="8" pattern="\d{5}-?\d{3}" required>
                            </div>

                            <div class="row">
                                <div class="form-group col-xs-8">
                                    <label class="sr-only" for="companyCity">City:</label>
                                    <input readonly name="city" type="text" id="companyCity" class="form-control"
                                        placeholder="Cidade" required>
                                </div>

                                <div class="form-group col-xs-4">
                                    <label class="sr-only" for="companyState">State:</label>
                                    <input readonly name="state" type="text" id="companyState" class="form-control"
                                        placeholder="Estado" required>
                                </div>
                            </div>

                            <div class="row" style="margin-bottom: 1rem;">
                                <div class="form-group col-md-5">
                                    <label class="sr-only" for="companyAddress">Address:</label>
                                    <input readonly name="address" type="text" id="companyAddress" class="form-control"
                                        placeholder="Endereço" required>
                                </div>

                                <div class="form-group col-xs-8 col-md-4">
                                    <label class="sr-only" for="companyComplement">Complement:</label>
                                    <input name="complement" type="text" id="companyComplement" class="form-control"
                                        placeholder="Complemento">
                                </div>

                                <div class="form-group col-xs-4 col-md-3">
                                    <label class="sr-only" for="companyNumber">Number:</label>
                                    <input name="number" type="text" id="companyNumber" class="form-control"
                                        placeholder="Número" required>
                                </div>
                            </div>

                            <div id="errorMsg" class="alert alert-danger" style="display:none;"></div>

                            <button type="submit" class="btn btn-primary btn-lg btn-block">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection

@section('script')

    <script>
        $(document).ready(function() {
            $('#companyPostalCode').on('input', function() {
                let cep = $(this).val().replace(/\D/g, '');
                
                cep = cep.replace(/(\d{5})(\d{3})/, '$1-$2');

                $(this).val(cep);

                if (cep.length === 9 && cep.indexOf('-') !== -1) {
                    $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, function(data) {
                        if (!("erro" in data)) {
                            $('#companyAddress').val(data.logradouro);
                            $('#companyCity').val(data.localidade);
                            $('#companyState').val(data.uf);
                        }
                    });
                }
            });

            $('form').submit(function(event) {
                event.preventDefault();

                const formData = new FormData($(this)[0]);
                const logoFile = $('#companyLogo').prop('files')[0];

                if (logoFile) {
                    formData.append('logo', logoFile);
                }

                $.ajax({
                    url: '/api/companies',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        window.location.href = '/dashboard';
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 413) {
                            $('#errorMsg').html(
                                `Erro ao cadastrar empresa: Imagem excedeu o limite de tamanho permitido.`
                                ).show();
                        } else {
                            $('#errorMsg').html(`Erro ao cadastrar empresa`).show();
                        }
                    }
                });
            });
        });
    </script>


@endsection
