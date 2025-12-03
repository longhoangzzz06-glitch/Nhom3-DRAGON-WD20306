<?php
class GuideController {

    private $guideModel;

    public function __construct() {
        $this->guideModel = new GuideModel();
    }

    // Hiển thị form thêm HDV
    public function tao() {
        require_once "./views/guide/them.php";
    }

    // Xử lý lưu HDV
    public function luu() {
        $ten  = $_POST['name'];
        $email = $_POST['email'];
        $dienThoai = $_POST['phone'];

        $matKhauTam = $this->guideModel->taoHDVVaTaiKhoan([
            'name'  => $ten,
            'email' => $email,
            'phone' => $dienThoai
        ]);

        require_once "./views/guide/matkhau_tam.php";
    }

    // Reset mật khẩu
    public function resetMatKhau() {
        $userId = $_GET['user_id'];
        $matKhauMoi = $this->guideModel->resetMatKhau($userId);

        require_once "./views/guide/matkhau_moi.php";
    }
}
