<?php
return [
    [
        "route" => "",
        "route_args" => [],
        "title" => "Général",
        "icon" => "fa fa-cog",
        "role" => \App\Enum\RoleEnum::ROLE_SUPER_ADMIN,
    ],
    [
        "route" => "",
        "route_args" => [],
        "title" => "Facturation",
        "icon" => "fa fa-calculator",
        "role" => \App\Enum\RoleEnum::ROLE_COMMERCIAL_COMPANY,
        "subMenu" => [
            [
                "route" => "commercial_company_app_billing_index",
                "route_args" => [],
                "title" => "Devis",
                "icon" => "fa fa-gear",
                "role" => \App\Enum\RoleEnum::ROLE_COMMERCIAL_COMPANY,
            ],
            [
                "route" => "",
                "route_args" => [],
                "title" => "Factures",
                "icon" => "fa fa-gear",
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
                "route" => "",
                "route_args" => [],
                "title" => "Clients",
                "icon" => "fa fa-gear",
                "role" => \App\Enum\RoleEnum::ROLE_COMMERCIAL_COMPANY,
            ],
            [
                "route" => "",
                "route_args" => [],
                "title" => "Fournisseurs",
                "icon" => "fa fa-gear",
                "role" => \App\Enum\RoleEnum::ROLE_COMMERCIAL_COMPANY,
            ]
        ]
    ],
    [
        "route" => "",
        "route_args" => [],
        "title" => "Produits",
        "icon" => "fa fa-cog",
        "role" => \App\Enum\RoleEnum::ROLE_COMMERCIAL_COMPANY,
        "subMenu" => [
            [
                "route" => "commercial_company_app_product_index",
                "route_args" => [],
                "title" => "Produits",
                "icon" => "fa fa-gear",
                "role" => \App\Enum\RoleEnum::ROLE_COMMERCIAL_COMPANY,
            ],
            [
                "route" => "",
                "route_args" => [],
                "title" => "Catégories",
                "icon" => "fa fa-gear",
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
    ]
];
