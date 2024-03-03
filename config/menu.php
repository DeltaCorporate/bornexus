<?php
return [
    [
        "route" => "admin_company_app_home",
        "route_args" => [],
        "title" => "Général",
        "icon" => "fa fa-house",
        "role" => \App\Enum\RoleEnum::ROLE_ADMIN_COMPANY,
    ],
    [
        "route" => "super_admin_app_company_index",
        "route_args" => [],
        "title" => "Companies",
        "icon" => "fa-solid fa-tag",
        "role" => \App\Enum\RoleEnum::ROLE_SUPER_ADMIN,
    ],
    [
        "route" => "",
        "route_args" => [],
        "title" => "Facturation",
        "icon" => "fa fa-file-invoice-dollar",
        "role" => \App\Enum\RoleEnum::ROLE_COMMERCIAL_COMPANY,
        "subMenu" => [
            [
                "route" => "commercial_company_app_billing_index",
                "route_args" => [],
                "title" => "Devis",
                "icon" => "fa fa-file-invoice",
                "role" => \App\Enum\RoleEnum::ROLE_COMMERCIAL_COMPANY,
            ],
            [
                "route" => "",
                "route_args" => [],
                "title" => "Factures",
                "icon" => "fa fa-file-invoice-dollar",
                "role" => \App\Enum\RoleEnum::ROLE_COMMERCIAL_COMPANY,
            ]
        ]
    ],
    [
        "route" => "accountant_company_app_accountant",
        "route_args" => [],
        "title" => "Comptabilité",
        "icon" => "fa fa-calculator",
        "role" => \App\Enum\RoleEnum::ROLE_ACCOUNTANT_COMPANY,
    ],
    [
        "route" => "",
        "route_args" => [],
        "title" => "Gestion",
        "icon" => "fa fa-cog",
        "role" => \App\Enum\RoleEnum::ROLE_ADMIN_COMPANY,
        "subMenu" => [
            [
                "route" => "commercial_company_app_client_index",
                "route_args" => [],
                "title" => "Clients",
                "icon" => "fa-solid fa-users",
                "role" => \App\Enum\RoleEnum::ROLE_COMMERCIAL_COMPANY,
            ],
            [
                "route" => "super_admin_app_supplier_index",
                "route_args" => [],
                "title" => "Fournisseurs",
                "icon" => "fa-solid fa-truck-fast",
                "role" => \App\Enum\RoleEnum::ROLE_SUPER_ADMIN,
            ]
        ]
    ],
    [
        "route" => "",
        "route_args" => [],
        "title" => "Produits",
        "icon" => "fa-solid fa-cart-shopping",
        "role" => \App\Enum\RoleEnum::ROLE_COMMERCIAL_COMPANY,
        "subMenu" => [
            [
                "route" => "commercial_company_app_product_index",
                "route_args" => [],
                "title" => "Produits",
                "icon" => "fa-solid fa-cart-shopping",
                "role" => \App\Enum\RoleEnum::ROLE_COMMERCIAL_COMPANY,
            ],
            [
                "route" => "",
                "route_args" => [],
                "title" => "Catégories",
                "icon" => "fa-solid fa-layer-group",
                "role" => \App\Enum\RoleEnum::ROLE_COMMERCIAL_COMPANY,
            ]
        ]
    ],
    [
        "route" => "",
        "route_args" => [],
        "title" => "Paramètres",
        "icon" => "fa fa-gear",
        "role" => \App\Enum\RoleEnum::ROLE_ADMIN_COMPANY,
        "subMenu"=>[
            [
                "route" => "",
                "route_args" => [],
                "title" => "Staff",
                "icon" => "fa fa-user",
                "role" => \App\Enum\RoleEnum::ROLE_COMMERCIAL_COMPANY,
            ]
        ]
    ]
];
