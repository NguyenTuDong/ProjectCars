<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;


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
                'created_at' => '2019-04-06 13:51:52',
                'updated_at' => '2019-04-06 13:51:52',
            ],
            [
                'slug' => 'quan-ly-danh-muc',
                'ten' => 'Quản lý danh mục',
                'created_at' => '2019-04-06 13:51:52',
                'updated_at' => '2019-04-06 13:51:52',
            ],
            [
                'slug' => 'quan-ly-chuc-vu',
                'ten' => 'Quản lý chức vụ',
                'created_at' => '2019-04-06 13:51:52',
                'updated_at' => '2019-04-06 13:51:52',
            ],
            [
                'slug' => 'phan-quyen',
                'ten' => 'Phân quyền',
                'created_at' => '2019-04-06 13:51:52',
                'updated_at' => '2019-04-06 13:51:52',
            ],
            [
                'slug' => 'xem-nhan-vien',
                'ten' => 'Xem nhân viên',
                'created_at' => '2019-04-06 13:51:52',
                'updated_at' => '2019-04-06 13:51:52',
            ],
            [
                'slug' => 'them-nhan-vien',
                'ten' => 'Thêm nhân viên',
                'created_at' => '2019-04-06 13:51:52',
                'updated_at' => '2019-04-06 13:51:52',
            ],
            [
                'slug' => 'xoa-nhan-vien',
                'ten' => 'Xóa nhân viên',
                'created_at' => '2019-04-06 13:51:52',
                'updated_at' => '2019-04-06 13:51:52',
            ],
            [
                'slug' => 'sua-nhan-vien',
                'ten' => 'Sửa nhân viên',
                'created_at' => '2019-04-06 13:51:52',
                'updated_at' => '2019-04-06 13:51:52',
            ],
            [
                'slug' => 'xem-tin',
                'ten' => 'Xem tin',
                'created_at' => '2019-04-06 13:51:52',
                'updated_at' => '2019-04-06 13:51:52',
            ],
            [
                'slug' => 'duyet-tin',
                'ten' => 'Duyệt tin',
                'created_at' => '2019-04-06 13:51:52',
                'updated_at' => '2019-04-06 13:51:52',
            ],
            [
                'slug' => 'xoa-tin',
                'ten' => 'Xóa tin',
                'created_at' => '2019-04-06 13:51:52',
                'updated_at' => '2019-04-06 13:51:52',
            ],
            [
                'slug' => 'xem-khach-hang',
                'ten' => 'Xem khách hàng',
                'created_at' => '2019-04-06 13:51:52',
                'updated_at' => '2019-04-06 13:51:52',
            ],
            [
                'slug' => 'xem-lien-he',
                'ten' => 'Xem liên hệ',
                'created_at' => '2019-04-06 13:51:52',
                'updated_at' => '2019-04-06 13:51:52',
            ],
            [
                'slug' => 'thong-ke',
                'ten' => 'Thống kê',
                'created_at' => '2019-04-06 13:51:52',
                'updated_at' => '2019-04-06 13:51:52',
            ],
            [
                'slug' => 'bao-cao',
                'ten' => 'Báo cáo',
                'created_at' => '2019-04-06 13:51:52',
                'updated_at' => '2019-04-06 13:51:52',
            ],
        ];

        DB::table('permissions')->insert($permissions);
    }
}
