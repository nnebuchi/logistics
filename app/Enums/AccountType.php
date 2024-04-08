<?php

namespace App\Enums;

enum AccountType: string {
    case _PERSONAL = "personal";
    case _BUSINESS = "business";
    case _3PL = "3pl";
}