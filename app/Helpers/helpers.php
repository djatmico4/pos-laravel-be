<?php

function formatCurrency($amount)
{
    return 'IDR ' . number_format($amount, 0, ',', '.');
}

function monthName($month)
{
    $dateObj   = DateTime::createFromFormat('!m', $month);
    return $dateObj->format('F');
}
