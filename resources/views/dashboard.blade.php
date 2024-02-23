@extends('layouts.app')

@section('title', 'Admin panel')

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
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; margin-bottom: 1rem;">
            <h2>Registered companies</h2>

            <a class="btn btn-primary" href="{{ route('createCompany') }}">New company</a>
        </div>

        <div id="companiesList" class="row"></div>
    </section>

@endsection

@section('script')

    <script>
        const storagePathUrl = "{{ asset('storage') }}"
        const defaultImageUrl =
            "https://images.pexels.com/photos/273244/pexels-photo-273244.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"

        function loadCompanies() {

            const userId = "{{ Auth::user()->id }}";

            $.ajax({
                url: `/api/companies/my-companies/${userId}`,
                type: 'GET',
                success: function(response) {
                    $('#companiesList').empty();

                    if (response.length < 1) {

                        const infoMsg = `
                            <div class="alert alert-info">
                                <strong>You have no companies registered.</strong>
                            </div>
                        `;

                        $('#companiesList').append(infoMsg);

                        $('#searchByCep').prop('disabled', true);

                        $('#disclaimer').append(`<p>Try clicking the "New Company" button below</p>`).show();
                    }

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
                    const errorMessage = (xhr.responseJSON && xhr.responseJSON.error) ? xhr.responseJSON.error :
                        "An error occurred while processing your request.";

                    const errorElement = `
                        <div class="alert alert-danger">
                            <strong>Error:</strong> ${errorMessage}
                        </div>
                    `;

                    $('#companiesList').append(errorElement);
                }
            });
        }

        $(document).ready(function() {
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
