@extends('layouts.app')

@section('title', 'Search by CEP')

@section('content')

    <x-banner />

    <section class="container">
        <div id="searchResults" class="row"></div>

        <div id="noCompanies"></div>
    </section>

@endsection

@section('script')

    <script>
        const storagePathUrl = "{{ asset('storage') }}"
        const defaultImageUrl =
            "https://images.pexels.com/photos/273244/pexels-photo-273244.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"

        $(document).ready(function() {
            const cep = new URLSearchParams(window.location.search).get(
                'cep');

            if (cep) {
                $.ajax({
                    url: `/api/companies/search/${cep}`,
                    type: 'GET',
                    success: function(response) {
                        $('#searchResults').empty();

                        if (response.length < 1) {
                            const infoMsg = `
                                <div class="alert alert-info">
                                    <h3>No companies found.</h3>
                                    <p>Check if the CEP entered is valid.</p>
                                </div>
                            `;

                            $('#noCompanies').append(infoMsg);
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
                                        <h4>Address: <b>${company.address}</b></h4>
                                        <h4>City: <b>${company.city}</b></h4>
                                        <h4>State: <b>${company.state}</b></h4>
                                        <h4>Number: <b>${company.number}</b></h4>
                                        <h4>Complement: <b>${company.complement ?? "Not informed"}</b></h4>
                                    </div>
                                </div>
                            </div>
                        `;
                            $('#searchResults').append(companyCard);
                        });
                    },
                    error: function(xhr, status, error) {
                        const errorMessage = (xhr.responseJSON && xhr.responseJSON.error) ? xhr
                            .responseJSON.error : "An error occurred while processing your request.";

                        const errorElement = `
                            <div class="alert alert-danger">
                                <strong>Error:</strong> ${errorMessage}
                            </div>
                        `;

                        $('#noCompanies').append(errorElement);
                    }
                });
            }
        });
    </script>

@endsection
