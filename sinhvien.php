<?php
session_start();
if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}

// Hiển thị thông tin người dùng
echo "<p>Xin chào, <strong>{$_SESSION['MaSV']}</strong> | <a href='logout.php'>Đăng xuất</a></p>";

include 'connect.php';

$sql = "SELECT sv.MaSV, sv.HoTen, sv.GioiTinh, sv.NgaySinh, sv.Hinh, sv.MaNganh, nh.TenNganh
        FROM SinhVien sv
        LEFT JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Trang Sinh Viên</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        img { width: 100px; height: auto; }
    </style>
</head>
<body>
    <h2>TRANG SINH VIÊN</h2>
    <a href="add_sinhvien.php">Add Student</a>

    <table>
        <tr>
            <th>MaSV</th>
            <th>Họ Tên</th>
            <th>Giới Tính</th>
            <th>Ngày Sinh</th>
            <th>Hình</th>
            <th>Ngành</th>
            <th>Hành động</th>
        </tr>

        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row["MaSV"] ?></td>
                    <td><?= $row["HoTen"] ?></td>
                    <td><?= $row["GioiTinh"] ?></td>
                    <td><?= date('d/m/Y', strtotime($row["NgaySinh"])) ?></td>
                    <td><img src="<?= $row["Hinh"] ?>" alt="Hình sinh viên"></td>
                    <td><?= $row["MaNganh"] ?></td>
                    <td>
                        <a href="edit.php?MaSV=<?= $row["MaSV"] ?>">Edit</a> |
                        <a href="detail.php?MaSV=<?= $row["MaSV"] ?>">Details</a> |
                        <a href="delete.php?MaSV=<?= $row["MaSV"] ?>" onclick="return confirm('Xóa sinh viên này?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="7">Không có dữ liệu.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>