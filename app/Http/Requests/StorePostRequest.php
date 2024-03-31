<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //Kategori
            'kategori_kode' => 'required',
            'kategori_nama' => 'required',

            //user
            'username' => 'required',
            'nama' => 'required',
            'password' => 'required',
            'level_id' => 'required',

            //level
            'level_kode' => 'required',
            'level_nama' => 'required',
        ];
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        // The incoming request is valid...

        // Retrive the validated input data...
        $validated = $request->validated();

        // Retrive a portion of the validated input data...
        $validated = $request->safe()->only(['kategori_kode', 'kategori_nama']);
        $validated = $request->safe()->except(['kategori_kode', 'kategori_nama']);

        // Store the post...

        return redirect('/kategori');
    }
}