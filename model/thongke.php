<?php
function loadall_thongke()
{
    $sql = "SELECT danhmuc.id as id, danhmuc.name as tenloai, count(sanpham.id) as countsp,min(sanpham.price) as minprice, max(sanpham.price) as maxprice, avg(sanpham.price) as avgprice";
    $sql .= " FROM sanpham left join danhmuc on danhmuc.id=sanpham.iddm";
    $sql .= " GROUP BY danhmuc.id order by danhmuc.id desc";
    $listtk = pdo_query($sql);
    return $listtk;
}


function loadall_thongke_sanpham()
{
    $sql = "SELECT sanpham.id as id, sanpham.name as tenloai, count(cart.id) as countdh,min(cart.thanhtien) as mintong, max(cart.thanhtien) as maxtong, avg(cart.thanhtien) as avgtong";
    $sql .= " FROM cart left join sanpham on sanpham.id=cart.idsp";
    $sql .= " GROUP BY sanpham.id order by sanpham.id desc";
    $listtkdh = pdo_query($sql);
    return $listtkdh;
}
function loadall_statis()
{
    $sql = "SELECT c.id_cate as idcate, c.name_cate as namecate, count(p.id_pro) as pro_quantity, min(p.price) as min_price, max(p.price) as max_price, avg(p.price) as avg_price";
    $sql .= " FROM product p LEFT JOIN category c ON c.id_cate = p.idcate";
    $sql .= " GROUP BY c.id_cate ORDER BY c.id_cate DESC";
    $liststatis = pdo_query($sql);
    return $liststatis;
}


// Biểu đồ
