<?php

namespace App\Rules;

use App\Exceptions\ImportValidationException;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class ValidLocationCSV implements Rule
{
    protected $message = 'Invalid CSV data.';

    /**
     * This runs and validate file lines without import them
     * and test the file is fully importable
     * @param $file
     */
    public function dryRun($file)
    {
        $names = [0 => 'Location Name', 1 => 'Phone Number', 2 => 'Address', 3 => 'City', 4 => 'State', 5 => 'ZIP'];
        $skipFirstLine = !!stristr(file($file)[0], 'location name');
        $errorMessages = new MessageBag;
        foreach (file($file) as $no => $line) {
            $line = rtrim($line);
            if ($skipFirstLine || $line === '') {
                $skipFirstLine = false;
                continue;
            }
            $fields = explode(',', $line);
            $validator = Validator::make($fields, [
                0 => 'required|max:255',
                1 => 'max:255',
                2 => 'required|string|max:255',
                3 => 'required|string|max:255',
                4 => 'required|string|max:255',
                5 => 'required|string|max:255',
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
            if (count(explode(',', file($file)[0])) !== 6) {
                $this->message = 'The file must contain 6 columns.';
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
