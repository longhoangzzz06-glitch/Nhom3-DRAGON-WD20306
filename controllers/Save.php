            <div class="form-group">
                <form action="" method="POST">
                <label for="ncc_id">Chọn nhà cung cấp để thêm:</label>
                    <select id="ncc_id">
                        <option value="">--Chọn nhà cung cấp--</option>
                        <?php foreach ($allNcc as $ncc): ?>
                            <option value="<?= $ncc['id'] ?>"><?= $ncc['ten'] ?> (<?= $ncc['dvCungCap'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                    <div style="display: flex">
                    <button type="button" onclick="addNccToTour(<?= $tour['id'] ?>)" class="btn-submit" style="margin: 5px 0;">
                        Thêm NCC vào Tour
                    </button>
                    </div>
                </form>
            </div>

            <h4>Nhà cung cấp hiện tại của tour:</h4>
            <ul>
            <?php foreach ($selectedNcc as $ncc): ?>
                <li style="display: flex; justify-content: space-between; align-items: center; max-width: 1400px; margin-bottom: 5px; border-bottom: 1px solid #ccc; padding-bottom: 5px;">
                    <?= $ncc['ten'] ?> (<?= $ncc['dvCungCap'] ?>)
                    <a href="index.php?&act=xoaNccKhoiTour&tour_id=<?= $tour['id'] ?>&ncc_id=<?= $ncc['id'] ?>"
                    onclick="return confirm('Bạn có chắc muốn xóa NCC này khỏi tour?');">
                    <i class="fa fa-trash" style="color: red; margin-right: 30px;"></i>
                    </a>                        
                </li>
            <?php endforeach; ?>
            </ul>

                echo "<pre>";
    echo "LỖI XẢY RA:\n";
    print_r($e->getMessage());
    echo "\n\nSTACK TRACE:\n";
    print_r($e->getTraceAsString());
    echo "</pre>";
    exit();