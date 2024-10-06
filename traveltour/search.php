<?php
session_start();
include('includes/db.php');

// Kiểm tra xem có từ khóa tìm kiếm không
if (isset($_GET['query'])) {
    $searchQuery = $_GET['query'];

    // Hàm để tô đậm từ khóa trong kết quả
    function highlightKeyword($text, $keyword)
    {
        return preg_replace("/\p{L}*?" . preg_quote($keyword) . "\p{L}*/ui", "<strong>$0</strong>", $text);
    }

    // Khởi tạo mảng để lưu kết quả tìm kiếm
    $results = [];

    // Tìm kiếm trong bảng 'tour'
    $tourStmt = $conn->prepare("SELECT TOURID, TOURNAME FROM tour WHERE TOURNAME LIKE ? ");
    $searchTerm = "%$searchQuery%";
    $tourStmt->bind_param('ss', $searchTerm, $searchTerm);
    $tourStmt->execute();
    $tourStmt->store_result();
    $tourStmt->bind_result($tourId, $tourName, $tourDescription);
    while ($tourStmt->fetch()) {
        $results[] = [
            'type' => 'Tour',
            'name' => highlightKeyword($tourName, $searchQuery),
            'description' => highlightKeyword($tourDescription, $searchQuery),
            'link' => "tour_detail.php?id=" . $tourId // Giả sử bạn có trang chi tiết cho tour
        ];
    }
    $tourStmt->close();

    // Tìm kiếm trong bảng 'tourtype'
    $tourTypeStmt = $conn->prepare("SELECT TOURTYPEID, TOURTYPENAME FROM TOURTYPE WHERE TOURTYPENAME LIKE ?");
    $tourTypeStmt->bind_param('ss', $searchTerm, $searchTerm);
    $tourTypeStmt->execute();
    $tourTypeStmt->store_result();
    $tourTypeStmt->bind_result($tourTypeId, $tourTypeName, $tourTypeDescription);
    while ($tourTypeStmt->fetch()) {
        $results[] = [
            'type' => 'TourType',
            'name' => highlightKeyword($tourTypeName, $searchQuery),
            'description' => highlightKeyword($tourTypeDescription, $searchQuery),
            'link' => "tourtype_detail.php?id=" . $tourTypeId // Giả sử bạn có trang chi tiết cho loại tour
        ];
    }
    $tourTypeStmt->close();

    // Tìm kiếm trong bảng 'destination'
    $destinationStmt = $conn->prepare("SELECT DESTINATIONID, DENAME FROM destination WHERE DENAME LIKE ? ");
    $destinationStmt->bind_param('ss', $searchTerm, $searchTerm);
    $destinationStmt->execute();
    $destinationStmt->store_result();
    $destinationStmt->bind_result($destinationId, $destinationName, $destinationDescription);
    while ($destinationStmt->fetch()) {
        $results[] = [
            'type' => 'Destination',
            'name' => highlightKeyword($destinationName, $searchQuery),
            'description' => highlightKeyword($destinationDescription, $searchQuery),
            'link' => "destination_detail.php?id=" . $destinationId // Giả sử bạn có trang chi tiết cho điểm đến
        ];
    }
    $destinationStmt->close();

    // Đóng kết nối
    $conn->close();
}
?>
<!-- Hiển thị kết quả tìm kiếm -->
<div class="container">
    <h2>Kết quả tìm kiếm cho: <?= htmlspecialchars($searchQuery) ?></h2>
    <?php if (!empty($results)): ?>
        <ul>
            <?php foreach ($results as $result): ?>
                <li>
                    <a href="<?= $result['link'] ?>">
                        <strong><?= $result['name'] ?></strong> ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Không tìm thấy kết quả nào.</p>
    <?php endif; ?>
</div>