<?php
class HdvAuthController
{
    private $model;

    public function __construct()
    {
        $this->model = new HdvAuthModel();
    }

    // Giao diện đăng ký
    public function registerForm()
    {
        require_once "./views/hdv/auth/register.php";
    }

    // Xử lý đăng ký
    public function register()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Check email tồn tại
        $exist = $this->model->findByEmail($email);

        if ($exist) {
            die("Email đã tồn tại!");
        }

        $hdv_id = $this->model->register($name, $email, $password);

        header("Location: index.php?act=hdv_login");
        exit();
    }

    // Giao diện đăng nhập
    public function loginForm()
    {
        require_once "./views/hdv/auth/login.php";
    }

    // Xử lý đăng nhập
    public function login()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $hdv = $this->model->findByEmail($email);

        if (!$hdv) {
            die("Sai email hoặc mật khẩu!");
        }

        if (!password_verify($password, $hdv['password'])) {
            die("Sai mật khẩu!");
        }

        // ⭐ LƯU HDV ID VÀO SESSION
        $_SESSION['hdv_id'] = $hdv['id'];
        $_SESSION['hdv_name'] = $hdv['name'];

        header("Location: index.php?act=quan-ly-hdv");
        exit();
    }

    // Đăng xuất
    public function logout()
    {
        session_destroy();
        header("Location: index.php?act=hdv_login");
    }
}
