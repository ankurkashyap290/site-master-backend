<?php

namespace App\Rules;

use App\Exceptions\ImportValidationException;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class ValidClientCSV implements Rule
{
    protected $message = 'Invalid CSV data.';

    /**
     * This runs and validate file lines without import them
     * and test the file is fully importable
     * @param $file
     */
    public function dryRun($file)
    {
        $names = [
            'First Name',
            'Middle Name',
            'Last Name',
            'Room Number',
            'Responsible Party Email',
        ];
        $skipFirstLine = !!stristr(file($file)[0], 'first name');
        $errorMessages = new MessageBag;
        foreach (file($file) as $no => $line) {
            $line = rtrim($line);
            if ($skipFirstLine || $line === '') {
                $skipFirstLine = false;
                continue;
            }
            $fields = explode(',', $line);
            $validator = Validator::make($fields, [
                'required|string|max:255',
                'max:255',
                'required|string|max:255',
                'required|integer',
                'email|max:255',
            ], [], $names);
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                $errors[array_keys($errors)[0]][] = 'at line: ' . ($no + 1);
                $errorMessages->merge($errors);
            }
        }
        if ($errorMessages->count()) {
            throw ImportValidationException::withMessages($errorMessages->getMessages());
        }
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param UploadedFile $file
     * @return bool
     */
    public function passes($attribute, $file): bool
    {
        if ($attribute = 'csv') {
            if ($file->getClientOriginalExtension() !== 'csv') {
                $this->message = 'Wrong file type given, please upload a CSV file.';
                return false;
            }
            if (count(explode(',', file($file)[0])) !== 5) {
                $this->message = 'The file must contain 5 columns.';
                return false;
            }
            $this->dryRun($file);
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message;
    }
}
