<?php

namespace App\Enum;

enum RoleEnum
{
    case ROLE_SUPER_ADMIN;
    case ROLE_ADMIN_COMPANY;
    case ROLE_ACCOUNTANT_COMPANY;
    case ROLE_COMMERCIAL_COMPANY;
    case ROLE_USER;
}
