document.addEventListener('DOMContentLoaded', function() {
    const moduleMap = {
        'hdv': 'nav-hdv',
        'tour': 'nav-tour',
        'customer': 'nav-customer',
        'settings': 'nav-settings'
    };

    const currentUrl = window.location.href;
    const urlParams = new URLSearchParams(window.location.search);
    const actParam = urlParams.get('act') || '';  // Lấy ?act=...
    
    let activeMenuId = null;
    
    // Kiểm tra từng keyword trong moduleMap
    for (const [keyword, menuId] of Object.entries(moduleMap)) {
        // Kiểm tra xem keyword có trong URL hoặc ?act param không
        if (currentUrl.includes(keyword) || actParam.includes(keyword)) {
            activeMenuId = menuId;
            break;
        }
    }

    // Nếu không tìm thấy module nào → highlight Dashboard
    if (!activeMenuId && !actParam) {
        activeMenuId = 'nav-dashboard';
    }

    if (activeMenuId) {
        const activeMenu = document.getElementById(activeMenuId);
        if (activeMenu) {
            // Thêm class active vào nav-link
            const navLink = activeMenu.querySelector('.nav-link');
            if (navLink) {
                navLink.classList.add('active');
            }
        }
    }

    const allNavLinks = document.querySelectorAll('.nav-link');
    allNavLinks.forEach(link => {
        if (activeMenuId) {
            const parent = link.closest('.nav-item');
            if (parent && parent.id !== activeMenuId) {
                link.classList.remove('active');
            }
        }
    });
});