<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateChannelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'repository' => ['required', 'regex:/^[\w.-]+[\/][\w.-]+$/'],
            'destination' => ['required', 'regex:/^(#|@)[\w.-]+$/']
        ];
    }

    public function messages()
    {
        return [
            'repository.required' => 'Please enter a repository name e.g. baxterthehacker/public-repo',
            'repository.regex' => 'Please enter a repository name e.g. baxterthehacker/public-repo',
            'destination.required' => 'Please enter a slack destination: #channel or @user',
            'destination.regex' => 'To add a slack channel as destination use #channel_name or @user_name for users'
        ];
    }
}
