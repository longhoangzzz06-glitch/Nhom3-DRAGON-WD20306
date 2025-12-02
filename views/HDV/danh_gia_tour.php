<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đánh giá & Phản hồi Tour</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="./views/chung/css/danhsach.css" />
  <style>
    .rating-section {
      background: white;
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      margin-bottom: 20px;
    }
    .rating-section h3 {
      margin: 0 0 20px 0;
      font-size: 18px;
      color: #333;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .rating-item {
      margin-bottom: 20px;
      padding-bottom: 20px;
      border-bottom: 1px solid #e0e0e0;
    }
    .rating-item:last-child {
      border-bottom: none;
      margin-bottom: 0;
      padding-bottom: 0;
    }
    .rating-label {
      display: block;
      font-weight: 600;
      color: #333;
      margin-bottom: 10px;
    }
    .star-rating {
      display: flex;
      gap: 10px;
      font-size: 32px;
    }
    .star {
      cursor: pointer;
      color: #ddd;
      transition: all 0.2s;
    }
    .star:hover,
    .star.active {
      color: #ffc107;
    }
    .rating-value {
      display: inline-block;
      margin-left: 15px;
      font-size: 18px;
      font-weight: 600;
      color: #007bff;
    }
    .service-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 20px;
      margin-top: 20px;
    }
    .service-card {
      background: #f8f9fa;
      padding: 20px;
      border-radius: 8px;
      border: 2px solid #e0e0e0;
    }
    .service-card h4 {
      margin: 0 0 15px 0;
      font-size: 16px;
      color: #333;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .service-detail {
      margin: 10px 0;
    }
    .service-detail label {
      display: block;
      font-size: 13px;
      color: #666;
      margin-bottom: 5px;
    }
    .service-detail input,
    .service-detail select {
      width: 100%;
      padding: 8px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 14px;
    }
    .comment-box {
      width: 100%;
      min-height: 120px;
      padding: 12px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 14px;
      resize: vertical;
    }
    .highlight-section {
      background: #d4edda;
      border: 2px solid #28a745;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 20px;
    }
    .highlight-section h3 {
      margin: 0 0 15px 0;
      color: #155724;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .issue-section {
      background: #f8d7da;
      border: 2px solid #dc3545;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 20px;
    }
    .issue-section h3 {
      margin: 0 0 15px 0;
      color: #721c24;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .tag-input {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-top: 10px;
    }
    .tag {
      background: #007bff;
      color: white;
      padding: 5px 12px;
      border-radius: 15px;
      font-size: 13px;
      display: flex;
      align-items: center;
      gap: 5px;
    }
    .tag .remove {
      cursor: pointer;
      font-weight: bold;
    }
    .photo-upload {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-top: 10px;
    }
    .photo-preview {
      width: 100px;
      height: 100px;
      border-radius: 8px;
      object-fit: cover;
      border: 2px solid #ddd;
    }
    .upload-btn {
      width: 100px;
      height: 100px;
      border: 2px dashed #007bff;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      color: #007bff;
      font-size: 32px;
      transition: all 0.3s;
    }
    .upload-btn:hover {
      background: #e7f3ff;
    }
    .form-actions {
      display: flex;
      gap: 15px;
      margin-top: 30px;
      justify-content: flex-end;
    }
    .btn-submit {
      padding: 12px 30px;
      background: #28a745;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
      font-weight: 600;
    }
    .btn-submit:hover {
      background: #218838;
    }
    .btn-save-draft {
      padding: 12px 30px;
      background: #6c757d;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
      font-weight: 600;
    }
    .btn-save-draft:hover {
      background: #5a6268;
    }
    .previous-reviews {
      background: white;
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      margin-top: 30px;
    }
    .review-item {
      padding: 20px;
      border: 1px solid #e0e0e0;
      border-radius: 8px;
      margin-bottom: 15px;
    }
    .review-header {
      display: flex;
      justify-content: space-between;
      margin-bottom: 15px;
      padding-bottom: 10px;
      border-bottom: 2px solid #f0f0f0;
    }
    .review-date {
      color: #666;
      font-size: 14px;
    }
    .overall-rating {
      background: #007bff;
      color: white;
      padding: 8px 15px;
      border-radius: 20px;
      font-weight: 600;
    }
  </style>
</head>
<body>
<div class="content-wrapper">
  <div class="content-container">
    <div class="header">
      <div>
        <h1>Đánh giá & Phản hồi Tour</h1>
      </div>
    </div>

    <!-- Search section -->
    <div class="search-section">
      <button class="btn-reset" onclick="window.location.href='?act=hdv-chi-tiet-tour&id=<?= $_GET['id'] ?? 2 ?>'">
        <i class="fas fa-arrow-left"></i> Quay lại
      </button>
      <button class="btn-advanced-search" onclick="viewPreviousReviews()">
        <i class="fas fa-history"></i> Xem phản hồi trước đây
      </button>
    </div>

    <?php
    // Data from controller: $tour
    // No mock data - all data fetched from database
    ?>

    <!-- Tour Info -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
      <h2 style="margin: 0 0 5px 0; font-size: 20px;"><?= htmlspecialchars($tour['ten']) ?></h2>
      <p style="margin: 0; opacity: 0.9; font-size: 14px;"><i class="fas fa-calendar"></i> <?= date('d/m/Y', strtotime($tour['tgBatDau'])) ?> - <?= date('d/m/Y', strtotime($tour['tgKetThuc'])) ?></p>
    </div>

    <div class="main-wrapper">
      <form id="reviewForm" onsubmit="submitReview(event)">
        <!-- Overall Rating -->
        <div class="rating-section">
          <h3><i class="fas fa-star"></i> Đánh giá tổng quan</h3>
          
          <div class="rating-item">
            <label class="rating-label">Chất lượng tour tổng thể:</label>
            <div class="star-rating" data-rating="overall">
              <span class="star" data-value="1">★</span>
              <span class="star" data-value="2">★</span>
              <span class="star" data-value="3">★</span>
              <span class="star" data-value="4">★</span>
              <span class="star" data-value="5">★</span>
            </div>
            <span class="rating-value" id="overall-value">0/5</span>
          </div>

          <div class="rating-item">
            <label class="rating-label">Mức độ hài lòng của khách hàng:</label>
            <div class="star-rating" data-rating="customer-satisfaction">
              <span class="star" data-value="1">★</span>
              <span class="star" data-value="2">★</span>
              <span class="star" data-value="3">★</span>
              <span class="star" data-value="4">★</span>
              <span class="star" data-value="5">★</span>
            </div>
            <span class="rating-value" id="customer-satisfaction-value">0/5</span>
          </div>

          <div class="rating-item">
            <label class="rating-label">Tình trạng an toàn:</label>
            <div class="star-rating" data-rating="safety">
              <span class="star" data-value="1">★</span>
              <span class="star" data-value="2">★</span>
              <span class="star" data-value="3">★</span>
              <span class="star" data-value="4">★</span>
              <span class="star" data-value="5">★</span>
            </div>
            <span class="rating-value" id="safety-value">0/5</span>
          </div>
        </div>

        <!-- Service Providers -->
        <div class="rating-section">
          <h3><i class="fas fa-building"></i> Đánh giá nhà cung cấp dịch vụ</h3>
          
          <div class="service-grid">
            <!-- Hotel -->
            <div class="service-card">
              <h4><i class="fas fa-hotel"></i> Khách sạn</h4>
              <div class="service-detail">
                <label>Tên khách sạn:</label>
                <input type="text" placeholder="VD: Grand Palace Hotel" value="Grand Palace Hotel Bangkok">
              </div>
              <div class="service-detail">
                <label>Đánh giá:</label>
                <select>
                  <option value="">-- Chọn --</option>
                  <option value="5">⭐⭐⭐⭐⭐ Rất tốt</option>
                  <option value="4" selected>⭐⭐⭐⭐ Tốt</option>
                  <option value="3">⭐⭐⭐ Trung bình</option>
                  <option value="2">⭐⭐ Kém</option>
                  <option value="1">⭐ Rất kém</option>
                </select>
              </div>
              <div class="service-detail">
                <label>Nhận xét:</label>
                <textarea class="comment-box" placeholder="Chất lượng phòng, vệ sinh, phục vụ..."></textarea>
              </div>
            </div>

            <!-- Restaurant -->
            <div class="service-card">
              <h4><i class="fas fa-utensils"></i> Nhà hàng</h4>
              <div class="service-detail">
                <label>Tên nhà hàng:</label>
                <input type="text" placeholder="VD: Thai Cuisine Restaurant">
              </div>
              <div class="service-detail">
                <label>Đánh giá:</label>
                <select>
                  <option value="">-- Chọn --</option>
                  <option value="5">⭐⭐⭐⭐⭐ Rất tốt</option>
                  <option value="4">⭐⭐⭐⭐ Tốt</option>
                  <option value="3" selected>⭐⭐⭐ Trung bình</option>
                  <option value="2">⭐⭐ Kém</option>
                  <option value="1">⭐ Rất kém</option>
                </select>
              </div>
              <div class="service-detail">
                <label>Nhận xét:</label>
                <textarea class="comment-box" placeholder="Chất lượng món ăn, vệ sinh, phục vụ..."></textarea>
              </div>
            </div>

            <!-- Transportation -->
            <div class="service-card">
              <h4><i class="fas fa-bus"></i> Vận chuyển</h4>
              <div class="service-detail">
                <label>Đơn vị vận chuyển:</label>
                <input type="text" placeholder="VD: Bangkok Transport Co.">
              </div>
              <div class="service-detail">
                <label>Đánh giá:</label>
                <select>
                  <option value="">-- Chọn --</option>
                  <option value="5" selected>⭐⭐⭐⭐⭐ Rất tốt</option>
                  <option value="4">⭐⭐⭐⭐ Tốt</option>
                  <option value="3">⭐⭐⭐ Trung bình</option>
                  <option value="2">⭐⭐ Kém</option>
                  <option value="1">⭐ Rất kém</option>
                </select>
              </div>
              <div class="service-detail">
                <label>Nhận xét:</label>
                <textarea class="comment-box" placeholder="Chất lượng xe, tài xế, đúng giờ..."></textarea>
              </div>
            </div>

            <!-- Tour Guide Service -->
            <div class="service-card">
              <h4><i class="fas fa-user-tie"></i> Hướng dẫn địa phương</h4>
              <div class="service-detail">
                <label>Tên HDV địa phương:</label>
                <input type="text" placeholder="VD: Mr. Somchai">
              </div>
              <div class="service-detail">
                <label>Đánh giá:</label>
                <select>
                  <option value="">-- Chọn --</option>
                  <option value="5">⭐⭐⭐⭐⭐ Rất tốt</option>
                  <option value="4" selected>⭐⭐⭐⭐ Tốt</option>
                  <option value="3">⭐⭐⭐ Trung bình</option>
                  <option value="2">⭐⭐ Kém</option>
                  <option value="1">⭐ Rất kém</option>
                </select>
              </div>
              <div class="service-detail">
                <label>Nhận xét:</label>
                <textarea class="comment-box" placeholder="Kiến thức, thái độ, kỹ năng giao tiếp..."></textarea>
              </div>
            </div>
          </div>
        </div>

        <!-- Highlights -->
        <div class="highlight-section">
          <h3><i class="fas fa-thumbs-up"></i> Điểm nổi bật / Điều tốt</h3>
          <textarea class="comment-box" placeholder="Những điểm tốt của tour, dịch vụ xuất sắc, trải nghiệm đáng nhớ..."></textarea>
          <div class="tag-input" id="highlights-tags">
            <div class="tag">Đúng giờ <span class="remove" onclick="removeTag(this)">×</span></div>
            <div class="tag">Phục vụ tốt <span class="remove" onclick="removeTag(this)">×</span></div>
          </div>
          <input type="text" id="highlight-input" placeholder="Thêm tag (Enter để thêm)" 
                 onkeypress="addTag(event, 'highlights-tags')" 
                 style="margin-top: 10px; padding: 8px; border: 1px solid #28a745; border-radius: 4px; width: 100%;">
        </div>

        <!-- Issues -->
        <div class="issue-section">
          <h3><i class="fas fa-exclamation-triangle"></i> Vấn đề / Cần cải thiện</h3>
          <textarea class="comment-box" placeholder="Các vấn đề gặp phải, điều cần cải thiện, đề xuất..."></textarea>
          <div class="tag-input" id="issues-tags">
          </div>
          <input type="text" id="issue-input" placeholder="Thêm tag (Enter để thêm)" 
                 onkeypress="addTag(event, 'issues-tags')" 
                 style="margin-top: 10px; padding: 8px; border: 1px solid #dc3545; border-radius: 4px; width: 100%;">
        </div>

        <!-- Photos -->
        <div class="rating-section">
          <h3><i class="fas fa-camera"></i> Hình ảnh minh họa</h3>
          <p style="color: #666; font-size: 14px; margin-bottom: 15px;">
            Đính kèm hình ảnh về chất lượng dịch vụ, sự cố (nếu có), hoặc những điểm đáng chú ý
          </p>
          <div class="photo-upload">
            <label class="upload-btn" for="photo-upload">
              <i class="fas fa-plus"></i>
              <input type="file" id="photo-upload" multiple accept="image/*" style="display: none;" onchange="previewPhotos(event)">
            </label>
            <div id="photo-preview"></div>
          </div>
        </div>

        <!-- Additional Comments -->
        <div class="rating-section">
          <h3><i class="fas fa-comment-dots"></i> Nhận xét chung & Đề xuất</h3>
          <textarea class="comment-box" style="min-height: 150px;" 
                    placeholder="Đánh giá tổng thể về tour, đề xuất cải thiện cho các tour tương lai, kiến nghị với công ty..."></textarea>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
          <button type="button" class="btn-save-draft" onclick="saveDraft()">
            <i class="fas fa-save"></i> Lưu nháp
          </button>
          <button type="submit" class="btn-submit">
            <i class="fas fa-paper-plane"></i> Gửi phản hồi
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// Star rating functionality
document.querySelectorAll('.star-rating').forEach(ratingContainer => {
  const stars = ratingContainer.querySelectorAll('.star');
  const ratingType = ratingContainer.dataset.rating;
  let currentRating = 0;

  stars.forEach(star => {
    star.addEventListener('click', function() {
      currentRating = parseInt(this.dataset.value);
      updateStars();
      document.getElementById(ratingType + '-value').textContent = currentRating + '/5';
    });

    star.addEventListener('mouseenter', function() {
      const hoverValue = parseInt(this.dataset.value);
      stars.forEach((s, idx) => {
        if (idx < hoverValue) {
          s.classList.add('active');
        } else {
          s.classList.remove('active');
        }
      });
    });
  });

  ratingContainer.addEventListener('mouseleave', updateStars);

  function updateStars() {
    stars.forEach((s, idx) => {
      if (idx < currentRating) {
        s.classList.add('active');
      } else {
        s.classList.remove('active');
      }
    });
  }
});

function addTag(event, containerId) {
  if (event.key === 'Enter') {
    event.preventDefault();
    const input = event.target;
    const value = input.value.trim();
    
    if (value) {
      const container = document.getElementById(containerId);
      const tag = document.createElement('div');
      tag.className = 'tag';
      tag.innerHTML = `${value} <span class="remove" onclick="removeTag(this)">×</span>`;
      container.appendChild(tag);
      input.value = '';
    }
  }
}

function removeTag(element) {
  element.parentElement.remove();
}

function previewPhotos(event) {
  const files = event.target.files;
  const preview = document.getElementById('photo-preview');
  
  Array.from(files).forEach(file => {
    const reader = new FileReader();
    reader.onload = function(e) {
      const img = document.createElement('img');
      img.src = e.target.result;
      img.className = 'photo-preview';
      preview.appendChild(img);
    }
    reader.readAsDataURL(file);
  });
}

function submitReview(event) {
  event.preventDefault();
  
  // Validate ratings
  let hasRating = false;
  const ratings = {};
  ['overall', 'customer-satisfaction', 'safety'].forEach(type => {
    const value = document.getElementById(type + '-value').textContent;
    const numValue = parseInt(value);
    if (numValue > 0) {
      hasRating = true;
      ratings[type] = numValue;
    }
  });
  
  if (!hasRating) {
    alert('Vui lòng đánh giá ít nhất một tiêu chí!');
    return;
  }
  
  if (!confirm('Bạn có chắc muốn gửi phản hồi này?')) {
    return;
  }
  
  // Collect service provider reviews
  const serviceProviders = [];
  document.querySelectorAll('.service-card').forEach((card, index) => {
    const types = ['hotel', 'restaurant', 'transport', 'local_guide'];
    const nameInput = card.querySelector('input[type="text"]');
    const ratingSelect = card.querySelector('select');
    const commentTextarea = card.querySelector('textarea');
    
    if (nameInput && nameInput.value.trim()) {
      serviceProviders.push({
        loaiNCC: types[index],
        tenNCC: nameInput.value.trim(),
        diem: parseInt(ratingSelect.value) || 0,
        nhanXet: commentTextarea.value.trim()
      });
    }
  });
  
  // Collect highlights and issues
  const highlightTags = Array.from(document.querySelectorAll('#highlights-tags .tag'))
    .map(tag => tag.textContent.replace('×', '').trim());
  const issueTags = Array.from(document.querySelectorAll('#issues-tags .tag'))
    .map(tag => tag.textContent.replace('×', '').trim());
  
  // Get all textareas
  const textareas = document.querySelectorAll('textarea');
  
  // Prepare data
  const reviewData = {
    tour_id: <?= $tour_id ?>,
    hdv_id: <?= $_SESSION['hdv_id'] ?? 5 ?>, // TODO: Get from session
    diem: ratings['overall'] || 0,
    danhGia_anToan: ratings['safety'] || 0,
    danhGia_haiLong: ratings['customer-satisfaction'] || 0,
    binhLuan: textareas[textareas.length - 1].value.trim(), // Additional comments
    diemNoiBat: textareas[0].value.trim() + (highlightTags.length ? '\nTags: ' + highlightTags.join(', ') : ''),
    vanDe: textareas[1].value.trim() + (issueTags.length ? '\nTags: ' + issueTags.join(', ') : ''),
    loai: 'hdv',
    trangThai: 'submitted',
    serviceProviders: serviceProviders
  };
  
  // Send to API
  fetch('?act=api-save-review', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify(reviewData)
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert('Đã gửi phản hồi thành công!\nCảm ơn bạn đã đóng góp ý kiến để cải thiện chất lượng dịch vụ.');
      window.location.href = '?act=hdv-chi-tiet-tour&id=<?= $tour_id ?>';
    } else {
      alert('Lỗi: ' + (data.message || 'Không thể lưu đánh giá'));
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Có lỗi xảy ra khi gửi phản hồi!');
  });
}

function viewPreviousReviews() {
  alert('Xem các phản hồi trước đây');
  // TODO: Show modal with previous reviews
}

function saveDraft() {
  // Similar to submitReview but with trangThai = 'draft'
  const ratings = {};
  ['overall', 'customer-satisfaction', 'safety'].forEach(type => {
    const value = document.getElementById(type + '-value').textContent;
    const numValue = parseInt(value);
    if (numValue > 0) {
      ratings[type] = numValue;
    }
  });
  
  const serviceProviders = [];
  document.querySelectorAll('.service-card').forEach((card, index) => {
    const types = ['hotel', 'restaurant', 'transport', 'local_guide'];
    const nameInput = card.querySelector('input[type="text"]');
    const ratingSelect = card.querySelector('select');
    const commentTextarea = card.querySelector('textarea');
    
    if (nameInput && nameInput.value.trim()) {
      serviceProviders.push({
        loaiNCC: types[index],
        tenNCC: nameInput.value.trim(),
        diem: parseInt(ratingSelect.value) || 0,
        nhanXet: commentTextarea.value.trim()
      });
    }
  });
  
  const highlightTags = Array.from(document.querySelectorAll('#highlights-tags .tag'))
    .map(tag => tag.textContent.replace('×', '').trim());
  const issueTags = Array.from(document.querySelectorAll('#issues-tags .tag'))
    .map(tag => tag.textContent.replace('×', '').trim());
  
  const textareas = document.querySelectorAll('textarea');
  
  const reviewData = {
    tour_id: <?= $tour_id ?>,
    hdv_id: <?= $_SESSION['hdv_id'] ?? 5 ?>,
    diem: ratings['overall'] || 0,
    danhGia_anToan: ratings['safety'] || 0,
    danhGia_haiLong: ratings['customer-satisfaction'] || 0,
    binhLuan: textareas[textareas.length - 1].value.trim(),
    diemNoiBat: textareas[0].value.trim() + (highlightTags.length ? '\nTags: ' + highlightTags.join(', ') : ''),
    vanDe: textareas[1].value.trim() + (issueTags.length ? '\nTags: ' + issueTags.join(', ') : ''),
    loai: 'hdv',
    trangThai: 'draft',
    serviceProviders: serviceProviders
  };
  
  fetch('?act=api-save-review', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify(reviewData)
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert('Đã lưu nháp thành công!');
    } else {
      alert('Lỗi: ' + (data.message || 'Không thể lưu nháp'));
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Có lỗi xảy ra khi lưu nháp!');
  });
}
</script>

</body>
</html>
