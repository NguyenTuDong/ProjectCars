<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'slug' => 'xem-dashboard',
                'ten' => 'Xem Dashboard',
            ],
            [
                'slug' => 'quan-ly-danh-muc',
                'ten' => 'Quản lý danh mục',
            ],
            [
                'slug' => 'quan-ly-chuc-vu',
                'ten' => 'Quản lý chức vụ',
            ],
            [
                'slug' => 'phan-quyen',
                'ten' => 'Phân quyền',
            ],
            [
                'slug' => 'xem-nhan-vien',
                'ten' => 'Xem nhân viên',
            ],
            [
                'slug' => 'them-nhan-vien',
                'ten' => 'Thêm nhân viên',
            ],
            [
                'slug' => 'xoa-nhan-vien',
                'ten' => 'Xóa nhân viên',
            ],
            [
                'slug' => 'sua-nhan-vien',
                'ten' => 'Sửa nhân viên',
            ],
            [
                'slug' => 'xem-tin',
                'ten' => 'Xem tin',
            ],
            [
                'slug' => 'duyet-tin',
                'ten' => 'Duyệt tin',
            ],
            [
                'slug' => 'xoa-tin',
                'ten' => 'Xóa tin',
            ],
            [
                'slug' => 'xem-khach-hang',
                'ten' => 'Xem khách hàng',
            ],
            [
                'slug' => 'xem-lien-he',
                'ten' => 'Xem liên hệ',
            ],
            [
                'slug' => 'thong-ke',
                'ten' => 'Thống kê',
            ],
            [
                'slug' => 'bao-cao',
                'ten' => 'Báo cáo',
            ],
        ];

        DB::table('permissions')->insert($permissions);
    }
}
