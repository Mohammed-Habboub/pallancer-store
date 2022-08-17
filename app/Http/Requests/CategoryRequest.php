<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;
use Symfony\Component\Translation\Test\ProviderTestCase;

// To Create Request => php artisan make:request CategoryRequest
class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize() // Is the user allowed do request true => yes | false => No
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() // Rules 
    {
        $id = $this->route('id');
        return [                                                                   
                'name'           => 'required',
                'alpha',
                'max:255',
                'min:3',                   //PK للاستثناء
                // Method:1 'unique:categories,name,$id',
                // Method 2
                //Rule::unique('categories', 'name' )->ignore($id)
                // Method 3
                (new Unique('categories', 'name'))->ignore($id),
                                 
                'description'    => [
                    'nullable',
                    'min:5', 
    
                // Custom rule in php //
                // Method 1
                /* function($attribute, $value, $fail) {
                    if ( stripos($value, 'laravel') !== false ) {
                        $fail('Youe can not "laravel" !');
                    } 
                }*/
    
                // Method 2
                //new WordsFilter(['php', 'laravel']),
    
                // Method 3 
                // Validate Extend => App Service => boot => Ex: filter
                'filter:laravel',
                
            ],
                'parent_id'      => [
                    'nullable',
                    'exists:categories,id',
                ],
                'image'          => [
                    'nullable',
                    'image',
                    'max:1048576',
                    'dimensions:min_width=200,min_height=200'
                ],
                'status' => 'required|in:active,inactive',
            
        ];
    }
    // customs messages
    public function messages() 
    {
        return [
            'name.required' => 'Required!!',
        ];
    }
}
