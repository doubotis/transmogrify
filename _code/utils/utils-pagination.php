<?php

function make_pagination($startIndex, $countInPage, $totalCount)
{
    if (!isset($_GET["page"]))
        $curPage = 1;
    else
    {
        $curPage = $_GET["page"];
    }

    
    $queryString = $_SERVER['QUERY_STRING'];
    $queryString = str_replace("&page=" . $curPage, "", $queryString);
    $queryString = str_replace("page=" . $curPage, "", $queryString);
    
    if ($queryString == "")
        $queryString .= "page=";
    else
        $queryString .= "&page=";
    
    $content = "";
    
    $numOfPages = ceil($totalCount / $countInPage);
    
    if ($numOfPages <= 0)
    {
        return "";
    }
    //if ($numOfPages > 5) $numOfPages = 5;
    
    // Calculate min and max pages.
    $minPage = $curPage - 2;
    if ($minPage < 1)
        $minPage = 1;
    
    $firstPageShown;
    $lastPageShown;
    $previousPage;
    $nextPage;
    if ($numOfPages < 5)
    {
        $firstPageShown = 1;
        $lastPageShown = $numOfPages + 1;
        $previousPage = $firstPageShown;
        $nextPage = $numOfPages;
    }
    else
    {
        $firstPageShown = $minPage;
        $lastPageShown = $minPage + 5;
        if ($lastPageShown > $numOfPages)
        {
            $lastPageShown = $numOfPages;
            $firstPageShown = $numOfPages - 5;
        }
        $previousPage = 1;
        $nextPage = $numOfPages - 1;
    }
    
    $content .= "<li><a href=\"?" . $queryString . $previousPage ."\">&laquo;</a></li>";
    for ($i = $firstPageShown; $i < $lastPageShown; $i++)
    {
        $subClass = "";
        if ($i == $curPage)
            $subClass = "active";
        
        $content .= "<li class=\"" . $subClass . "\"><a href=\"?" . $queryString . $i . "\">" . $i . " <span class=\"sr-only\">(current)</span></a></li>";
    }
    $content .= "<li><a href=\"?" . $queryString . $nextPage ."\">&raquo;</a></li>";
    
    return $content;
}

?>