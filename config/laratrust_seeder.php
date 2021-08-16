<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => false,

    'roles_structure' => [
        'shop_owner' => [
            'name' => 'Admin',
            'permission' => [
                'product' => ['view', 'create', 'edit', 'delete', 'import_file', 'export_file'],
                'warehouse' => ['view_import', 'edit_import', 'process_import', 'create_receipt', 'create_pay', 'import_file', 'export_file'],
                'cost_price' => ['manage'],
                'provider' => ['manage'],
                'customer' => ['view', 'create', 'edit', 'delete', 'import_file', 'export_file'],
                'delivery' => ['partner_manage'],
                'order' => ['view', 'create', 'edit', 'import_file', 'export_file'],
                'setting' => ['view', 'create', 'edit', 'delete']
            ]
        ]
    ],
    'roles_for_new_shop' => [
        'department_manager' => [
            'name' => 'Quản lý chi nhánh',
            'description' => '',
            'permission' => [
                'product' => ['view', 'create', 'edit', 'delete', 'import_file', 'export_file'],
                'warehouse' => ['view_import', 'edit_import', 'process_import', 'create_receipt', 'create_pay', 'import_file', 'export_file'],
                'cost_price' => [],
                'provider' => ['manage'],
                'customer' => ['view', 'create', 'edit', 'delete', 'import_file', 'export_file'],
                'delivery' => ['partner_manage'],
                'order' => ['view', 'create', 'edit', 'import_file', 'export_file'],
//                'setting' => ['shop_manage', 'employee_manage', 'general', 'price_policy', 'tax_policy']
            ]
        ],
    ],

    'permissions_map' => [
        'product' => [
            'name' => 'Sản phẩm',
            'description' => 'Có quyền: Xem sản phẩm, Tạo sản phẩm, Sửa sản phẩm, Xóa sản phẩm, Xuất file sản phẩm, Nhập file sản phẩm',
            'items' => [
                'view' => 'Xem sản phẩm',
                'create' => 'Tạo sản phẩm',
                'edit' => 'Sửa sản phẩm',
                'delete' => 'Xóa sản phẩm',
                'import_file' => 'Nhập file sản phẩm',
                'export_file' => 'Xuất file sản phẩm'
            ]
        ],
        'warehouse' => [
            'name' => 'Kho hàng',
            'description' => 'Có quyền: Xem đơn nhập, Tạo đơn nhập, Sửa đơn nhập, Duyệt đơn nhập, Hoàn trả đơn nhập, Thanh toán đơn nhập, Nhận hàng vào kho, Hủy đơn nhập, Kết thúc đơn nhập, Xuất file đơn nhập, Nhập file đơn nhập',
            'items' => [
                'view_import' => 'Xem đơn nhập',
                'create_import' => 'Tạo đơn nhập',
                'edit_import' => 'Sửa đơn nhập',
                'process_import' => 'Duyệt đơn nhập',
                'create_receipt' => 'Tạo phiếu thu',
                'create_pay' => 'Tạo phiếu chi',
                'import_file' => 'Nhập file đơn nhập',
                'export_file' => 'Xuất file đơn nhập',
            ]
        ],
        'cost_price' => [
            'name' => 'Điều chỉnh giá vốn',
            'description' => 'Có quyền: Xem phiếu điều chỉnh, Tạo phiếu điều chỉnh, Sửa phiếu điều chỉnh, Điều chỉnh giá, Xóa phiếu điều chỉnh, Hủy phiếu điều chỉnh, Nhập file phiếu điều chỉnh',
            'items' => [
                'manage' => 'Quản lý phiếu điều chỉnh giá',
            ]
        ],
        'provider' => [
            'name' => 'Nhà cung cấp',
            'description' => '',
            'items' => [
                'manage' => 'Quản lý nhà cung cấp',
            ]
        ],
        'customer' => [
            'name' => 'Khách hàng',
            'description' => '',
            'items' => [
                'view' => 'Xem khách hàng',
                'create' => 'Tạo khách hàng',
                'edit' => 'Sửa khách hàng',
                'delete' => 'Xóa khách hàng',
                'import_file' => 'Nhập file khách hàng',
                'export_file' => 'Xuất file khách hàng',
            ]
        ],
        'delivery' => [
            'name' => 'Vận chuyển',
            'description' => '',
            'items' => [
                'partner_manage' => 'Quản lý đối tác vận chuyển'
            ]
        ],
        'order' => [
            'name' => 'Đơn hàng',
            'description' => '',
            'items' => [
                'view' => 'Xem đơn',
                'create' => 'Tạo đơn',
                'edit' => 'Sửa đơn',
                'process' => 'Duyệt đơn',
                'import_file' => 'Nhập file đơn hàng',
                'export_file' => 'Xuất file đơn hàng',
            ]
        ],
        'setting' => [
            'name' => 'Cài đặt',
            'description' => 'Cấu hình hệ thống',
            'items' => [
                'view' => 'Xem cấu hình',
                'create' => 'Tạo cấu hình hệ thống',
                'edit' => 'Sửa cấu hình hệ thống',
                'delete' => 'Xóa cấu hình',
            ]
        ]
    ]
];
