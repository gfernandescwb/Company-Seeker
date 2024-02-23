<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Company\CreateCompanyRequest;
use App\Http\Requests\API\Company\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {        
            $companies = Company::query()->orderBy('id', 'desc')->get();

            return response()->json($companies, 200);
        } catch (\Exception $e) {
            report($e);

            return response()->json(['error' => 'Error when listing companies'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCompanyRequest $request)
    {
        try {
            $data = $request->validated();

            $cep = preg_replace('/[^0-9]/', '', $data['cep']);

            $data['cep'] = $cep;

            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');

                $path = $logo->store('logos', 'public');

                $data['logo'] = $path;
            }

            $company = Company::create($data);

            return response()->json($company, 201);
        } catch (\Exception $e) {
            report($e);

            return response()->json(['error' => 'Error when creating company: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $company = Company::findOrFaild($id);

            return response()->json($company, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Company not found.'] . 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompanyRequest $request, $id)
    {
        try {
            $company = Company::findOrFail($id);

            $company->fill($request->validated());

            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');

                if ($company->logo) {
                    Storage::disk('public')->delete($company->logo);
                }

                $data['logo'] = $logo->store('logos', 'public');
            }

            $company->fill($data);

            $company->save();

            return response()->json($company, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error when updating company: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $company = Company::findOrFail($id);

            $company->delete();

            return response()->json(['message' => 'Company deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error when deleting company: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Search companies by CEP.
     *
     * @param  string  $cep
     * @return \Illuminate\Http\Response
     */
    public function searchByCep($cep)
    {
        try {
            $companies = Company::where('cep', $cep)->get();

            if (!$companies) {
                return response()->json(['error' => 'Companies not found.', 404]);
            }

            return response()->json($companies, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error when searching companies by CEP: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function myCompanies($id)
    {
        try {        
            $companies = Company::where('user_id', $id)->orderBy('id', 'desc')->get();
    
            return response()->json($companies, 200);
        } catch (\Exception $e) {
            report($e);
    
            return response()->json(['error' => 'Error when listing companies'], 500);
        }
    }
}
