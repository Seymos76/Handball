<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 01/11/18
 * Time: 18:47
 */

namespace App\Service\Blog;


class Pagination
{
    public function getTotalPages(array $totalElements, int $perPage)
    {
        return ceil(count($totalElements)/$perPage);
    }

    public function getLimit(int $page, int $perPage)
    {
        return ceil($page * $perPage);
    }

    public function getOffset(int $limit, int $perPage)
    {
        return ceil($limit - $perPage);
    }
}