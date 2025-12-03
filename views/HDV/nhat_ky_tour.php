<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nhật ký Tour</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="./views/chung/css/danhsach.css" />
  <style>
    .diary-entry {
      background: white;
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      margin-bottom: 20px;
      border-left: 4px solid #28a745;
    }
    .diary-entry.incident {
      border-left-color: #dc3545;
    }
    .diary-entry-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 15px;
      padding-bottom: 15px;
      border-bottom: 2px solid #f0f0f0;
    }
    .diary-date {
      font-size: 18px;
      font-weight: 600;
      color: #333;
    }
    .diary-time {
      color: #666;
      font-size: 14px;
      margin-top: 5px;
    }
    .diary-actions {
      display: flex;
      gap: 10px;
    }
    .btn-edit, .btn-delete {
      padding: 6px 12px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 13px;
    }
    .btn-edit {
      background: #007bff;
      color: white;
    }
    .btn-edit:hover {
      background: #0056b3;
    }
    .btn-delete {
      background: #dc3545;
      color: white;
    }
    .btn-delete:hover {
      background: #c82333;
    }
    .diary-content {
      margin-bottom: 15px;
    }
    .diary-content h3 {
      font-size: 16px;
      font-weight: 600;
      color: #333;
      margin: 0 0 10px 0;
    }
    .diary-content p {
      color: #666;
      line-height: 1.8;
      margin: 5px 0;
      white-space: pre-wrap;
    }
    .diary-tags {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      margin-top: 15px;
    }
    .diary-tag {
      padding: 4px 12px;
      border-radius: 12px;
      font-size: 12px;
      font-weight: 600;
    }
    .tag-event {
      background: #d1ecf1;
      color: #0c5460;
    }
    .tag-incident {
      background: #f8d7da;
      color: #721c24;
    }
    .tag-feedback {
      background: #d4edda;
      color: #155724;
    }
    .diary-images {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
      gap: 10px;
      margin-top: 15px;
    }
    .diary-image {
      width: 100%;
      height: 150px;
      object-fit: cover;
      border-radius: 8px;
      cursor: pointer;
      transition: transform 0.3s;
    }
    .diary-image:hover {
      transform: scale(1.05);
    }
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.9);
    }
    .modal.active {
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .modal-content {
      background: white;
      padding: 30px;
      border-radius: 8px;
      max-width: 600px;
      width: 90%;
      max-height: 90vh;
      overflow-y: auto;
    }
    .modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      padding-bottom: 15px;
      border-bottom: 2px solid #e0e0e0;
    }
    .modal-header h2 {
      margin: 0;
      font-size: 22px;
    }
    .close-modal {
      font-size: 30px;
      color: #999;
      cursor: pointer;
      line-height: 1;
    }
    .close-modal:hover {
      color: #333;
    }
    .form-group {
      margin-bottom: 20px;
    }
    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 600;
      color: #333;
    }
    .form-group input,
    .form-group textarea,
    .form-group select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 14px;
    }
    .form-group textarea {
      min-height: 120px;
      resize: vertical;
    }
    .form-actions {
      display: flex;
      gap: 10px;
      justify-content: flex-end;
      margin-top: 20px;
    }
    .btn-submit {
      padding: 10px 20px;
      background: #28a745;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 14px;
    }
    .btn-submit:hover {
      background: #218838;
    }
    .btn-cancel {
      padding: 10px 20px;
      background: #6c757d;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 14px;
    }
    .btn-cancel:hover {
      background: #5a6268;
    }
    .empty-state {
      text-align: center;
      padding: 60px 20px;
      background: white;
      border-radius: 8px;
      color: #999;
    }
    .empty-state i {
      font-size: 60px;
      margin-bottom: 20px;
      opacity: 0.3;
    }
  </style>
</head>
<body>
<div class="content-wrapper">
  <div class="content-container">
    <div class="header">
      <div>
        <h1>Nhật ký Tour</h1>
      </div>
    </div>

    <!-- Search section -->
    <div class="search-section">
      <button class="btn-reset" onclick="window.location.href='?act=hdv-chi-tiet-tour&id=<?= $_GET['id'] ?? 2 ?>'">
        <i class="fas fa-arrow-left"></i> Quay lại
      </button>
      <button class="btn-add-item" onclick="openAddDiaryModal()">
        <i class="fas fa-plus"></i> Thêm nhật ký mới
      </button>
    </div>

    <?php
    // Data from controller: $tour, $diaryEntries
    // No mock data - all data fetched from database
    ?>
    <script>
      const diaryEntries = <?= json_encode($diaryEntries) ?>;
    </script>

    <!-- Tour Info Card -->
    <div style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
      <h2 style="margin: 0 0 10px 0;"><i class="fas fa-book"></i> <?= htmlspecialchars($tour['ten']) ?></h2>
      <p style="margin: 0; opacity: 0.9;"><i class="fas fa-calendar"></i> <?= date('d/m/Y', strtotime($tour['tgBatDau'])) ?> - <?= date('d/m/Y', strtotime($tour['tgKetThuc'])) ?></p>
    </div>

    <!-- Diary Entries -->
    <div class="main-wrapper">
      <?php if (empty($diaryEntries)): ?>
        <div class="empty-state">
          <i class="fas fa-book-open"></i>
          <h3>Chưa có nhật ký nào</h3>
          <p>Bắt đầu ghi lại hành trình của bạn bằng cách nhấn "Thêm nhật ký mới"</p>
        </div>
      <?php else: ?>
        <?php foreach ($diaryEntries as $entry): ?>
        <div class="diary-entry <?= !empty($entry['incident']) ? 'incident' : '' ?>">
          <div class="diary-entry-header">
            <div>
              <div class="diary-date">
                <i class="fas fa-calendar-day"></i>
                <?= date('d/m/Y', strtotime($entry['date'])) ?> - <?= htmlspecialchars($entry['title']) ?>
              </div>
              <div class="diary-time">
                <i class="fas fa-clock"></i>
                Cập nhật lúc: <?= $entry['time'] ?>
              </div>
            </div>
            <div class="diary-actions">
              <button class="btn-edit" onclick="editDiary(<?= $entry['id'] ?>)">
                <i class="fas fa-edit"></i> Sửa
              </button>
              <button class="btn-delete" onclick="deleteDiary(<?= $entry['id'] ?>)">
                <i class="fas fa-trash"></i> Xóa
              </button>
            </div>
          </div>

          <div class="diary-content">
            <h3><i class="fas fa-list-ul"></i> Diễn biến:</h3>
            <p><?= nl2br(htmlspecialchars($entry['content'])) ?></p>
          </div>

          <?php if (!empty($entry['incident'])): ?>
          <div class="diary-content">
            <h3><i class="fas fa-exclamation-triangle"></i> Sự cố & Xử lý:</h3>
            <p><?= nl2br(htmlspecialchars($entry['incident'])) ?></p>
          </div>
          <?php endif; ?>

          <?php if (!empty($entry['feedback'])): ?>
          <div class="diary-content">
            <h3><i class="fas fa-comments"></i> Phản hồi khách hàng:</h3>
            <p><?= nl2br(htmlspecialchars($entry['feedback'])) ?></p>
          </div>
          <?php endif; ?>

          <div class="diary-tags">
            <?php if (!empty($entry['incident'])): ?>
            <span class="diary-tag tag-incident">
              <i class="fas fa-exclamation-circle"></i> Có sự cố
            </span>
            <?php endif; ?>
            <?php if (!empty($entry['feedback'])): ?>
            <span class="diary-tag tag-feedback">
              <i class="fas fa-comment-dots"></i> Có phản hồi
            </span>
            <?php endif; ?>
          </div>

          <?php if (!empty($entry['images'])): ?>
          <div class="diary-images">
            <?php foreach ($entry['images'] as $image): ?>
            <img src="./uploads/tour_diary/<?= htmlspecialchars($image) ?>" 
                 alt="Tour image" 
                 class="diary-image"
                 onerror="this.src='https://via.placeholder.com/150?text=No+Image'"
                 onclick="viewImage(this.src)">
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
        </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Add/Edit Diary Modal -->
<div id="diaryModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h2 id="modal-title">Thêm nhật ký mới</h2>
      <span class="close-modal" onclick="closeDiaryModal()">&times;</span>
    </div>
    <form id="diaryForm" onsubmit="saveDiary(event)">
      <input type="hidden" id="diary-id" name="id" value="">
      <input type="hidden" id="tour-id" name="tour_id" value="<?= $tour['id'] ?>">
      <input type="hidden" name="hdv_id" value="<?= $_SESSION['hdv_id'] ?? 5 ?>">
      
      <div class="form-group">
        <label for="diary-date">Ngày:</label>
        <input type="date" id="diary-date" name="date" required>
      </div>

      <div class="form-group">
        <label for="diary-type">Loại:</label>
        <select id="diary-type" name="loai" required>
          <option value="event">Sự kiện</option>
          <option value="activity">Hoạt động</option>
          <option value="incident">Sự cố</option>
          <option value="note">Ghi chú</option>
        </select>
      </div>

      <div class="form-group">
        <label for="diary-title">Tiêu đề:</label>
        <input type="text" id="diary-title" name="tieuDe" placeholder="VD: Khởi hành tour - Ngày đầu tiên" required>
      </div>

      <div class="form-group">
        <label for="diary-content">Nội dung chi tiết:</label>
        <textarea id="diary-content" name="noiDung" placeholder="Mô tả chi tiết diễn biến, sự cố hoặc ghi chú..." required></textarea>
      </div>

      <div class="form-group">
        <label for="diary-images">Hình ảnh:</label>
        <input type="file" id="diary-images" name="photos[]" multiple accept="image/*">
      </div>

      <div class="form-actions">
        <button type="button" class="btn-cancel" onclick="closeDiaryModal()">Hủy</button>
        <button type="submit" class="btn-submit">
          <i class="fas fa-save"></i> Lưu nhật ký
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function openAddDiaryModal() {
  document.getElementById('modal-title').textContent = 'Thêm nhật ký mới';
  document.getElementById('diary-id').value = '';
  document.getElementById('diaryForm').reset();
  // Set default date to today
  document.getElementById('diary-date').valueAsDate = new Date();
  document.getElementById('diaryModal').classList.add('active');
}

function closeDiaryModal() {
  document.getElementById('diaryModal').classList.remove('active');
}

function editDiary(id) {
  const entry = diaryEntries.find(e => e.id == id);
  if (!entry) return;

  document.getElementById('modal-title').textContent = 'Cập nhật nhật ký';
  document.getElementById('diary-id').value = entry.id;
  document.getElementById('diary-date').value = entry.date;
  // Map display type back to value (Event -> event)
  document.getElementById('diary-type').value = entry.type.toLowerCase();
  document.getElementById('diary-title').value = entry.title;
  document.getElementById('diary-content').value = entry.content;
  
  document.getElementById('diaryModal').classList.add('active');
}

function deleteDiary(id) {
  if (confirm('Bạn có chắc muốn xóa nhật ký này?')) {
    fetch('?act=hdv-delete-diary', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ id: id })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert('Đã xóa nhật ký');
        location.reload();
      } else {
        alert('Lỗi: ' + (data.message || 'Không thể xóa'));
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Đã xảy ra lỗi khi xóa');
    });
  }
}

function saveDiary(event) {
  event.preventDefault();
  
  const form = document.getElementById('diaryForm');
  const formData = new FormData(form);
  
  // Add tour_id explicitly if not in form (it is in form now)
  // formData.append('tour_id', <?= $tour['id'] ?>);

  fetch('?act=hdv-save-diary', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert(data.message);
      location.reload();
    } else {
      alert('Lỗi: ' + (data.message || 'Không thể lưu'));
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Đã xảy ra lỗi khi lưu');
  });
}

function viewImage(src) {
  window.open(src, '_blank');
}

// Close modal when clicking outside
window.onclick = function(event) {
  const modal = document.getElementById('diaryModal');
  if (event.target === modal) {
    closeDiaryModal();
  }
}
</script>

</body>
</html>
