<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait FilterSortTrait
{
    //
    /**
     * Apply filters and sorting to a query builder instance.
     *
     * @param Builder $query
     * @param Request $request
     * @return Builder
     */
    public function scopeFilterSort(Builder $query, Request $request): Builder
    {
        // Apply filters
        $filters = $request->input('filter', []);
        foreach ($filters as $field => $value) {
            $this->applyFilters($query, $field, $value);
        }

        // Apply sorting
        $sorts = $request->input('sort', '');
        if (!empty($sorts)) {
            $sortFields = explode(',', $sorts);
            foreach ($sortFields as $sortField) {
                $sortDirection = Str::startsWith($sortField, '-') ? 'desc' : 'asc';
                $sortField     = ltrim($sortField, '-');

                $query->orderBy($sortField, $sortDirection);
            }
        }

        return $query;
    }

    /**
     * Recursively apply filters to the query based on field names and values.
     *
     * @param Builder $query
     * @param string $field
     * @param mixed $value
     * @return void
     */
    protected function applyFilters(Builder $query, string $field, $value): void
    {
        // Check if the field contains a dot, indicating a nested relation
        if (strpos($field, '.')) {
            $parts     = explode('.', $field);
            $attribute = array_pop($parts); // The actual attribute to filter on
            $relation  = implode('.', $parts); // The nested relationship path

            $query->whereHas($relation, function ($query) use ($attribute, $field, $value, $relation) {
                if (substr_count($field, '.') > 1) {
                    $this->applyCondition($query, $attribute, $value);
                } else {
                    $table = $query->getModel()->getTable();
                    if ($table === $relation) {
                        $this->applyCondition($query, $field, $value);
                    } else {
                        $this->applyCondition($query, $attribute, $value);
                    }
                }
            });
        } else {
            $this->applyCondition($query, $field, $value);
        }
    }

    /**
     * Apply a condition to the query.
     *
     * @param Builder $query
     * @param string $field
     * @param mixed $value
     * @return void
     */
    protected function applyCondition(Builder $query, string $field, $value): void
    {
        if (is_array($value)) {
            $whereIn    = [];
            $whereNotIn = [];

            // Adjust for JSON:API conventions, may include logical operators as keys
            foreach ($value as $operator => $val) {
                switch ($operator) {
                    case 'not':
                        foreach (explode(',', $val) as $v) {
                            $whereNotIn[] = $v;
                        }
                        break;
                    case 'like':
                        $query->where($field, 'ILIKE', "%$val%");
                        break;
                    case 'not_like':
                        $query->where($field, 'NOT ILIKE', "%$val%");
                        break;
                    case 'lt': // less than
                        $query->where($field, '<', $val);
                        break;
                    case 'gt': // greater than
                        $query->where($field, '>', $val);
                        break;
                    case 'lte': // less than or equal to
                        $query->where($field, '<=', $val);
                        break;
                    case 'gte': // greater than or equal to
                        $query->where($field, '>=', $val);
                        break;
                    case 'null':
                        $query->whereNull($field);
                        break;
                    case 'not_null':
                        $query->whereNotNull($field);
                        break;
                    default:
                        foreach (explode(',', $val) as $v) {
                            $whereIn[] = $v;
                        }
                        break;
                }
            }

            if (!empty($whereIn)) {
                $query->whereIn($field, $whereIn);
            }

            if (!empty($whereNotIn)) {
                $query->whereNotIn($field, $whereNotIn);
            }
        } else {
            $query->where($field, '=', $value);
        }
    }
}
