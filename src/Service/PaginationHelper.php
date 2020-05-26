<?php

namespace App\Service;

class PaginationHelper
{
    public int $resultsPerPage;

    public function __construct(int $resultsPerPage)
    {
        $this->resultsPerPage = $resultsPerPage;
    }

    public function calculateTotalPages(int $total, ?int $resultsPerPage = null): int
    {
        if ($resultsPerPage > 0) {
            return ceil($total / $resultsPerPage);
        }

        return ceil($total / $this->resultsPerPage);
    }

    public function calculateOffset(int $page, ?int $resultsPerPage = null): int
    {
        if ($resultsPerPage > 0) {
            return ($page * $resultsPerPage) - $resultsPerPage;
        }

        return ($page * $this->resultsPerPage) - $this->resultsPerPage;
    }
}
