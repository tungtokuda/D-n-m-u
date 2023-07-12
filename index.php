<?php
session_start();
ob_start();
include "./global.php";
include "./model/pdo.php";
include "./model/danhmuc.php";
include "./model/sanpham.php";
include "./model/taikhoan.php";
include "./model/color.php";
include "./model/size.php";

if (!isset($_SESSION['mycart'])) $_SESSION['mycart'] = [];

// LOAD TẤT CẢ SẢN PHẨM MỚI
$spnew = loadall_sanpham_home();

// LOAD TẤT CẢ DANH MỤC
$dsdm = loadall_danhmuc();
include "./view/header.php";

// LOAD DANH SÁCH TOP SẢN PHẨM
$dstop10 = loadall_sanpham_top();
if (isset($_GET['act'])) {
    $act = $_GET['act'];
    switch ($act) {
            // Trang sản phẩm
        case 'product':
            if (isset($_POST['kyw']) && ($_POST['kyw'] != "")) {
                $kyw = $_POST['kyw'];
            } else {
                $kyw = "";
            }
            if (isset($_GET['iddm']) && ($_GET['iddm'] > 0)) {
                $iddm = $_GET['iddm'];
            } else {
                $iddm = 0;
            }
            $dssp = loadall_sanpham($kyw, $iddm);
            $tendm = load_tendm($iddm);
            include "./view/sanpham/product.php";
            break;
            // SẢN PHẨM CHI TIẾT
        case 'sanphamct':
            if (isset($_GET['idsp']) && ($_GET['idsp']) > 0) {
                $id = $_GET['idsp'];
                $onesp = loadone_sanpham($id);
                extract($onesp);
                $sp_cungloai = loadone_sanpham_cungloai($id, $iddm);
            }
            $listsize = loadall_size();
            $listcolor = loadall_color();
            include "./view/sanpham/sanphamct.php";
            break;
            // Trang giới thiệu
        case 'gioithieu':
            include "./view/about.php";
            break;
            // Trang liên hệ
        case 'lienhe':
            include "./view/contact.php";
            break;
            // Tài khoản
        case 'login':
            if (isset($_POST['login'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $checkuser = checkuser($username, $password);
                if (is_array($checkuser)) {
                    $_SESSION['username'] = $checkuser;
                    header('location:index.php');
                    echo '<script>alert("Đăng nhập thành công")</script>';
                } else {
                    echo '<script>alert("Tài khoản hoặc mật khẩu không tồn tại")</script>';
                }
            }
            include "./view/taikhoan/login.php";
            break;
            // My acount
        case 'myaccount':
            if (isset($_POST['update']) && ($_POST['update'])) {
                $id = $_POST['id'];
                $full_name = $_POST['full_name'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                $address = $_POST['address'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $image_user = $_FILES['image_user']['name'];
                $target_dir = "../uploads/";
                $target_file = $target_dir . basename($_FILES["image_user"]["name"]);

                if (move_uploaded_file($_FILES["image_user"]["tmp_name"], $target_file)) {
                    // echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
                } else {
                    // echo "Sorry, there was an error uploading your file.";
                }

                // CẬP NHẬT DỮ LIỆU
                update_taikhoan_home($id, $full_name, $username, $password, $email, $address, $phone, $image_user);
                $_SESSION['username'] = checkuser($username, $password);
                header('location: index.php?act=myaccount');
                $thongbao = "Bạn đã cập nhật thông tin thành công";
            }
            include "view/taikhoan/myaccount.php";
            break;
            // DASHBOARD
        case 'dashboard':
            include "view/taikhoan/dashboard.php";
            break;
            // Logout
        case 'logout':
            session_unset();
            header('location:index.php');
            break;
            // Quên mât khẩu
        case 'quenmk':
            if (isset($_POST['btnsubmit']) && ($_POST['btnsubmit'] > 0)) {
                $email  = $_POST['email'];
                $checkemail = checkemail($email);
                if (is_array($checkemail)) {
                    $thongbao = "Mật khẩu của bạn là:" . $checkemail['password'];
                } else {
                    echo '<script>alert("Email không khớp với email đã đăng ký!")</script>';
                }
            }
            include "./view/taikhoan/quenmk.php";
            break;
            // TRANG ĐĂNG KÝ
        case 'dangky':
            if (isset($_POST['dangky'])) {
                $full_name = $_POST['full_name'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                $email = $_POST['email'];
                insert_taikhoan($full_name, $username, $password, $email);
                echo '<script>alert("Bạn đã đăng ký thành công")</script>';
            }
            include "./view/taikhoan/register.php";
            break;
        case 'setting':
            include "./view/taikhoan/setting.php";
            break;
    }
} else {
    include "./view/content.php";
}
include "./view/footer.php";

ob_end_flush();
