<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\ExperienceLevel;

class StoreJobApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50',
            'email' => 'required|email',
            'job_id' => 'required',
            'user_id' => 'required',
            'phone' => 'required|max:14',
            'last_position' => 'required|string|max:50',
            'experience_years' => 'required|integer|min:0|max:50',
            'experience_level' => 'required|in:' . implode(',', ExperienceLevel::values()),
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'cover_letter' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'job_id.required' => 'The job ID is required.',
            'job_id.required' => 'The user ID is required.',
            'name.required' => 'The name is required.',
            'email.required' => 'The email is required.',
            'email.email' => 'The email format is invalid.',
            'phone.required' => 'The phone number is required.',
            'phone.max' => 'The phone number must be valid (e.g. (111) 234-5678).',
            'last_position.required' => 'Please provide your last position.',
            'experience_years.required' => 'Years of experience is required.',
            'experience_years.integer' => 'Years of experience must be a number.',
            'experience_level.in' => 'The experience level must be one of: '. implode(',', ExperienceLevel::values()),
            'resume.required' => 'The resume is required.',
            'resume.mimes' => 'The resume must be a PDF or Word document.',
            'resume.max' => 'The resume must not exceed 2MB.',
            'cover_letter.mimes' => 'The cover letter must be a PDF or Word document.',
            'cover_letter.max' => 'The cover letter must not exceed 2MB.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Bad request',
            'errors' => $validator->errors()
        ], 400));
    }
}
