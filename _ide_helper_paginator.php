<?php

/**
 * IDE Helper for Laravel 10
 * 
 * This file helps IDEs understand Laravel's magic methods and dynamic return types.
 * This file is not loaded by the application - it's only for IDE autocomplete.
 * 
 * @noinspection ALL
 */

namespace Illuminate\Pagination {

    /**
     * @method $this withQueryString() Append all current query string values to pagination links.
     */
    class LengthAwarePaginator extends AbstractPaginator
    {
        //
    }

    /**
     * @method $this withQueryString() Append all current query string values to pagination links.
     */
    class Paginator extends AbstractPaginator
    {
        //
    }

    /**
     * @method $this withQueryString() Append all current query string values to pagination links.
     */
    class CursorPaginator extends AbstractCursorPaginator
    {
        //
    }
}
