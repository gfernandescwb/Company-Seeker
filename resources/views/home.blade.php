@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <x-banner />

    <section class="container">
        <div class="panel panel-default">
            <div class="panel-body">
                <div id="disclaimer" class="alert alert-warning" style="display: none;"></div>

                <form>
                    <div class="form-group">
                        <label for="searchByCep">Search by CEP:</label>
                        <input maxlength="8" type="text" class="form-control" placeholder="Find companies by cep"
                            id="searchByCep">
                        <div class="help-block" id="searchError"></div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2">
                            <button type="submit" class="btn btn-secondary btn-block">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="container">
        <div id="hasCompaniesMsg"></div>

        <div id="companiesList" class="row"></div>

        <div id="errorContainer" class="row"></div>
    </section>

@endsection

@section('script')

    <script>
        const storagePathUrl = "{{ asset('storage') }}"
        const defaultImageUrl =
            "https://images.pexels.com/photos/273244/pexels-photo-273244.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"

        $(document).ready(function() {

            function loadCompanies() {
                $.ajax({
                    url: '/api/companies',
                    type: 'GET',
                    success: function(response) {
                        $('#companiesList').empty();

                        if (response.length < 1) {
                            $('#hasCompaniesMsg').append(
                                `<div class="alert alert-info text-center">
                                    <h3>No companies registered yet 😐.</h3>
                                </div>`
                            );

                            $('#searchByCep').prop('disabled', true);

                            $('#disclaimer').append(`<p>There are no companies available at the moment. You must be logged in to register a new company.`).show();

                            return;
                        }

                        const hasCompaniesMsg = `
                            <h3>All companies already registered in Company Seeker!</h3>
                        `;

                        $('#hasCompaniesMsg').append(hasCompaniesMsg);

                        response.forEach(function(company) {

                            const logoUrl = company.logo ? `${storagePathUrl}/${company.logo}` :
                                defaultImageUrl;

                            const companyCard = `
                                <div class="col-md-6">
                                    <div class="panel panel-default" style="overflow: hidden;">
                                        <div style="width: 100%; height: 320px;">
                                            <img 
                                                style="width: 100%; height: 100%; object-fit: cover;"
                                                src="${logoUrl}" 
                                                alt="${company.name}" class="img-responsive"
                                            >
                                        </div>
                                        
                                        <div class="panel-body">
                                            <h4>Company: <b>${company.name.toUpperCase()}</b></h4>
                                            <h4>Postal Code (CEP): <b>${company.cep}</b></h4>
                                        </div>
                                    </div>
                            </div>
                            `;
                            $('#companiesList').append(companyCard);
                        });
                    },
                    error: function(xhr, status, error) {
                        const errorMessage = (xhr.responseJSON && xhr.responseJSON.error) ? xhr
                            .responseJSON.error : 'An error occurred while fetching companies.';
                        $('#errorContainer').html(
                            `<div class="alert alert-danger">${errorMessage}</div>`);
                    }
                });
            }

            loadCompanies();

            $('form').submit(function(event) {
                event.preventDefault();

                const cep = $('#searchByCep').val();

                $.ajax({
                    url: `/api/companies/search/${cep}`,
                    type: 'GET',
                    success: function(response) {
                        const queryParams = $.param({
                            cep: cep
                        });
                        const searchUrl = `/dashboard/search-results?${queryParams}`;

                        window.location.href = searchUrl;
                    },
                    error: function(xhr, status, error) {
                        const errorMessage = (xhr.responseJSON && xhr.responseJSON.error) ? xhr
                            .responseJSON.error :
                            "An error occurred while processing your request.";

                        const errorElement = `
                            <p class="help-block text-danger">${errorMessage}</p>
                        `;

                        $('#searchError').append(errorElement);
                    }
                });
            });
        });
    </script>

@endsection
