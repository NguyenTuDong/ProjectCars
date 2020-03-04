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
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'slug' => 'quan-ly-danh-muc',
                'ten' => 'Quản lý danh mục',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'slug' => 'quan-ly-chuc-vu',
                'ten' => 'Quản lý chức vụ',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'slug' => 'phan-quyen',
                'ten' => 'Phân quyền',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'slug' => 'xem-nhan-vien',
                'ten' => 'Xem nhân viên',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'slug' => 'them-nhan-vien',
                'ten' => 'Thêm nhân viên',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'slug' => 'xoa-nhan-vien',
                'ten' => 'Xóa nhân viên',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'slug' => 'sua-nhan-vien',
                'ten' => 'Sửa nhân viên',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'slug' => 'xem-tin',
                'ten' => 'Xem tin',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'slug' => 'duyet-tin',
                'ten' => 'Duyệt tin',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'slug' => 'xoa-tin',
                'ten' => 'Xóa tin',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'slug' => 'xem-khach-hang',
                'ten' => 'Xem khách hàng',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'slug' => 'xem-lien-he',
                'ten' => 'Xem liên hệ',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'slug' => 'thong-ke',
                'ten' => 'Thống kê',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'slug' => 'bao-cao',
                'ten' => 'Báo cáo',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ];

        DB::table('permissions')->insert($permissions);
    }
}
