<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;
use App\Models\Stock;

class UniqueStockLocation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    // public function validate(string $attribute, mixed $value, Closure $fail): void
    // {
    //     //
    // }
    // public function passes($attribute, $value)
    public function validate(string $attribute, mixed $value)
    {
        // Fetch existing stock records with the same combination of values
        $existingStock = Stock::where('asset_type', 'supply')
            ->where('asset_id', $value['asset_id'])
            ->where('stocks_parent_facility', $value['stocks_parent_facility'])
            ->where('location->stocks_aisle', $value['st_loc']['stocks_aisle'])
            ->where('location->stocks_row', $value['st_loc']['stocks_row'])
            ->where('location->stocks_bin', $value['st_loc']['stocks_bin'])
            ->exists();

        // If no matching records are found, the combination is considered unique
        return !$existingStock;
    }

    public function message()
    {
        return 'A record with the same facility, aisle, row, and bin already exists.';
    }
}
