<div class="main">
    <div class="main-content dashboard">
        <form action="./index.php?act=listthongke" method="post">
            <h1>Thống kê sản phẩm theo danh mục</h1>
            <table class=" table">
                <tr class="table-primary">
                    <th></th>
                    <th>Mã LOẠI</th>
                    <th>TÊN LOẠI</th>
                    <th>SỐ LƯỢNG SẢN PHẨM</th>
                    <th>GIÁ CAO NHẤT</th>
                    <th>GIÁ THẤP NHẤT</th>
                    <th>GIÁ TRUNG BÌNH</th>
                </tr>
                <?php foreach ($listthongke as $tk) {
                    extract($tk);
                    echo '<tr class="table-primary">
                                <td><input type="checkbox"></td>
                                <td>'.$id.'</td>
                                <td>'.$tenloai.'</td>
                                <td>'.$countsp.'</td>
                                <td>'.$maxprice.'</td>
                                <td>'.$minprice.'</td>
                                <td>'.$avgprice.'</td>
                         </tr>';
                    } ?>
                
            </table>
            <a class="" href="index.php?act=bieudo1"><input type="button" class="btn btn-info" value="Xem biểu đồ"></a>
            <br>
            <br>
            <br>
           
        </form>
    </div>
</div>