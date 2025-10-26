<?php

namespace App\Http\Controllers;

use App\Models\Contacts;
use App\Http\Requests\StoreContactsRequest;
use App\Http\Requests\UpdateContactsRequest;
use Exception;
use Illuminate\Support\Facades\Response;


class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // 1. menggambil semua data dari contact
            $contacts = Contacts::all();

            // 2. mengirimkan respons Json jika berhasil
            return Response::json([
                'message' => 'List Contacts',
                'data' => $contacts
            ], 200);
        } catch (\Exception $e) {
            // 3. mengirimkan respons Json jika terjadi error
            return Response::json([
                'message' => $e->getMessage(),
                'data' => null
            ], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactsRequest $request)
    {
        try {
            // 1. Ambil data yang sudah divalidasi dengan aman
            $validatedData = $request->safe()->all();

            // 2. Buat record baru di database
            $contacts = Contacts::create($validatedData);

            // 3. Kirim respons sukses beserta data yang baru dibuat
            return response()->json([
                'message' => 'Contact berhasil dibuat',
                'data' => $contacts
            ], 201);

        } catch (\Exception $e) {
            // 4. Tangani jika terjadi error tak terduga
            return response()->json([
                'message' => 'Terjadi kesalahan pada server',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Contacts $contacts)
    {
        try {
            return Response::json([
                'message' => "Detail Contact",
                'data' => $contacts
            ], 200);
        } catch (Exception $e) {
            return Response::json([
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactsRequest $request, Contacts $contact)
    {
         try {
            // 1. Ambil data yang sudah divalidasi
            $validated = $request->safe()->all();

            // 2. Update model dengan data yang tervalidasi
            if($contact->update($validated)){
                return Response::json([
                    'message' => "Contact updated",
                    'data' => $contact
                ], 200);
            }

            // 3. Kembalikan respons dengan data yang sudah diperbarui
            return Response::json([
                'message' => "Contact not updated",
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            // 4. Tangani jika terjadi error tak terduga
            return Response::json([
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contacts $contact)
    {
        try {
            // 1. Hapus data dari database
            if($contact->delete()){
                return Response::json([
                    'message' => "Contact deleted",
                    'data' => null
                ], 200);
            }

            // 2. Kirim respons yang sesuai
            return Response::json([
                'message' => "Contact not deleted",
                'data' => null
            ], 500);
        } catch (\Exception $e) {
            // 3. Tangani jika terjadi error
            return Response::json([
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

}