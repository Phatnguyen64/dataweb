<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SnackVibe - Thiên Đường Đồ Ăn Vặt</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        @keyframes bounce-custom {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50% { transform: translateX(-50%) translateY(-10px); }
        }
        .animate-bounce-custom { animation: bounce-custom 2s infinite; }
        /* Hiệu ứng trượt mượt mà khi cuộn trang */
        .fade-up-element {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .fade-up-element.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-[#FCF8F2] text-[#4A3E3D] overflow-x-hidden">

    <div id="toast" class="fixed bottom-8 left-1/2 -translate-x-1/2 bg-[#D4A373] text-white px-7 py-3 rounded-full font-bold text-sm z-[9999] shadow-[0_8px_32px_rgba(212,163,115,0.4)] transition-all duration-300 opacity-0 pointer-events-none">
        ✓ Đã thêm: <span id="toast-message"></span>
    </div>

    <div id="cart-drawer" class="fixed inset-0 z-[8000] hidden">
        <div id="cart-overlay" class="absolute inset-0 bg-black/50"></div>
        <div class="absolute right-0 top-0 bottom-0 w-[360px] bg-[#FCF8F2] p-6 overflow-y-auto shadow-2xl">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-extrabold text-[#4A3E3D]">🛒 Giỏ Hàng (<span id="cart-count-drawer">0</span>)</h3>
                <button id="close-cart" class="text-2xl bg-none border-none cursor-pointer text-[#4A3E3D]">&times;</button>
            </div>
            <div id="cart-items-container" class="flex flex-col gap-3"></div>
            <div id="cart-checkout-btn" class="mt-6 p-4 bg-[#4A3E3D] rounded-2xl text-center cursor-pointer text-[#FCF8F2] font-extrabold text-base hidden hover:bg-[#5C4D4C] transition duration-200">
                Đặt Hàng Ngay 🎉
            </div>
        </div>
    </div>

    <div id="auth-modal" class="fixed inset-0 z-[9000] flex items-center justify-center hidden">
        <div id="auth-overlay" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
        <div class="relative bg-[#FCF8F2] w-full max-w-md mx-4 p-8 rounded-[32px] shadow-2xl z-10 border border-[#EED9C4]">
            <button id="close-auth" class="absolute top-5 right-5 text-2xl text-[#4A3E3D] hover:opacity-70">&times;</button>
            
            <div id="login-form-container">
                <h3 class="text-2xl font-black text-[#4A3E3D] mb-2">Chào mừng trở lại! 👋</h3>
                <p class="text-sm text-gray-500 mb-6">Đăng nhập để nhận nhiều ưu đãi đặc biệt từ SnackVibe.</p>
                <form class="flex flex-col gap-4" onsubmit="event.preventDefault();">
                    <div>
                        <label class="text-xs font-bold text-[#4A3E3D] block mb-1.5">Email / Số điện thoại</label>
                        <input type="text" placeholder="example@gmail.com" class="w-full px-[18px] py-[14px] bg-white border-2 border-[#EED9C4] rounded-2xl text-sm outline-none transition duration-200 focus:border-[#D4A373]">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-[#4A3E3D] block mb-1.5">Mật khẩu</label>
                        <input type="password" placeholder="••••••••" class="w-full px-[18px] py-[14px] bg-white border-2 border-[#EED9C4] rounded-2xl text-sm outline-none transition duration-200 focus:border-[#D4A373]">
                    </div>
                    <div class="text-right">
                        <a href="#" class="text-xs font-semibold text-[#D4A373] hover:underline">Quên mật khẩu?</a>
                    </div>
                    <button type="submit" class="bg-[#D4A373] text-white border-none p-4 rounded-2xl text-base font-black cursor-pointer transition duration-200 shadow-md hover:bg-[#C39262]">
                        Đăng Nhập 🚀
                    </button>
                </form>
                <p class="text-sm text-center text-gray-500 mt-6">
                    Chưa có tài khoản? <a href="#" id="switch-to-register" class="text-[#D4A373] font-bold hover:underline">Đăng ký ngay</a>
                </p>
            </div>

            <div id="register-form-container" class="hidden">
                <h3 class="text-2xl font-black text-[#4A3E3D] mb-2">Tạo tài khoản mới ✨</h3>
                <p class="text-sm text-gray-500 mb-6">Trở thành thành viên của SnackVibe chỉ trong vài giây.</p>
                <form class="flex flex-col gap-4" onsubmit="event.preventDefault();">
                    <div>
                        <label class="text-xs font-bold text-[#4A3E3D] block mb-1.5">Họ và tên</label>
                        <input type="text" placeholder="Nguyễn Văn A" class="w-full px-[18px] py-[14px] bg-white border-2 border-[#EED9C4] rounded-2xl text-sm outline-none transition duration-200 focus:border-[#D4A373]">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-[#4A3E3D] block mb-1.5">Số điện thoại</label>
                        <input type="tel" placeholder="0901 234 567" class="w-full px-[18px] py-[14px] bg-white border-2 border-[#EED9C4] rounded-2xl text-sm outline-none transition duration-200 focus:border-[#D4A373]">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-[#4A3E3D] block mb-1.5">Mật khẩu</label>
                        <input type="password" placeholder="••••••••" class="w-full px-[18px] py-[14px] bg-white border-2 border-[#EED9C4] rounded-2xl text-sm outline-none transition duration-200 focus:border-[#D4A373]">
                    </div>
                    <button type="submit" class="bg-[#4A3E3D] text-white border-none p-4 rounded-2xl text-base font-black cursor-pointer transition duration-200 shadow-md hover:bg-[#5C4D4C]">
                        Đăng Ký Tài Khoản 🎉
                    </button>
                </form>
                <p class="text-sm text-center text-gray-500 mt-6">
                    Đã có tài khoản? <a href="#" id="switch-to-login" class="text-[#D4A373] font-bold hover:underline">Đăng nhập</a>
                </p>
            </div>
        </div>
    </div>

    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 px-6 transition-all duration-400">
        <div class="max-w-6xl mx-auto h-20 flex items-center justify-between">
            <div id="nav-logo" class="font-black text-2xl text-white tracking-tight transition-colors duration-200">
                <span class="text-[#D4A373]">SNACK</span>VIBE
            </div>
            <div class="flex gap-6 items-center">
                <div class="hidden md:flex gap-8" id="nav-links-container"></div>
                
                <div class="hidden sm:flex gap-3 items-center">
                    <button id="nav-login-btn" class="text-white font-bold text-sm px-4 py-2 hover:text-[#D4A373] transition duration-200 nav-auth-text">Đăng Nhập</button>
                    <button id="nav-register-btn" class="bg-[#D4A373] text-white font-bold text-sm px-5 py-2 rounded-full shadow-md hover:bg-[#C39262] transition duration-200">Đăng Ký</button>
                </div>

                <button id="open-cart" class="relative bg-[#D4A373] border-none text-white w-11 h-11 rounded-full cursor-pointer text-lg flex items-center justify-center shadow-[0_4px_20px_rgba(212,163,115,0.4)]">
                    🛒
                    <span id="cart-badge" class="absolute -top-1 -right-1 bg-red-500 text-white w-5 h-5 rounded-full text-[11px] font-extrabold flex items-center justify-center hidden">0</span>
                </button>
            </div>
        </div>
    </nav>

    <section class="relative h-screen min-h-[600px] overflow-hidden flex items-center justify-center">
        <img src="https://images.unsplash.com/photo-1544025162-d76694265947?w=1600&auto=format&fit=crop&q=80" alt="hero" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-br from-black/80 via-black/50 to-[#D4A373]/40"></div>
        <div class="relative z-10 text-center px-6 max-w-3xl">
            <div class="inline-block bg-[#D4A373]/20 border border-[#D4A373]/50 text-[#FAEDCD] px-5 py-1.5 rounded-full text-xs font-bold mb-6 backdrop-blur-sm">
                🔥 Đặc Biệt Hôm Nay — Giảm 20% Tất Cả Combo
            </div>
            <h1 class="text-4xl sm:text-6xl md:text-8xl font-black text-white leading-none mb-5 tracking-tighter">
                Thiên Đường<br><span class="text-[#D4A373]">Đồ Ăn Vặt</span>
            </h1>
            <p class="text-base sm:text-xl md:text-2xl text-white/85 mb-10 leading-relaxed">
                Thưởng thức những món ăn vặt ngon mắt, đậm vị — Hình ảnh sắc nét kích thích vị giác 🧡
            </p>
            <div class="flex gap-4 justify-center flex-wrap">
                <button id="hero-login-btn" class="bg-[#D4A373] text-white border-none px-10 py-4 rounded-full text-base font-extrabold cursor-pointer shadow-[0_8px_30px_rgba(212,163,115,0.5)] transition duration-200 hover:bg-[#C39262]">
                    Đăng Nhập Ngay 🚀
                </button>
                <button id="hero-menu-btn" class="bg-white/20 text-white border border-white/50 px-10 py-4 rounded-full text-base font-extrabold cursor-pointer transition duration-200 hover:bg-white/30 backdrop-blur-sm">
                    Xem Thực Đơn 🛒
                </button>
            </div>
        </div>
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 text-white/60 animate-bounce-custom text-2xl">↓</div>
    </section>

    <section id="menu" class="px-6 py-24 bg-[#FAF1E6]">
        <div class="max-w-6xl mx-auto">
            <div class="fade-up-element text-center mb-12">
                <span class="text-[#D4A373] font-bold text-sm tracking-widest uppercase">Thực Đơn Siêu Khủng</span>
                <h2 class="text-3xl sm:text-5xl font-black text-[#4A3E3D] mt-2 tracking-tighter">Menu 30 Món <span class="text-[#D4A373]">Tươi Tắn</span></h2>
                <p class="text-gray-500 mt-3 text-base max-w-lg mx-auto">Hình ảnh chất lượng cao hiển thị mượt mà ổn định, nhìn là thèm!</p>
            </div>
            <div id="menu-items-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8"></div>
        </div>
    </section>

    <footer class="bg-[#1C1615] text-white/70 text-sm border-t border-[#4A3E3D]/30 pt-16 pb-8 px-6">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
            <div class="flex flex-col gap-4">
                <div class="font-black text-2xl text-white tracking-tight">
                    <span class="text-[#D4A373]">SNACK</span>VIBE
                </div>
                <p class="text-white/60 leading-relaxed">
                    Thiên đường đồ ăn vặt cho giới trẻ Việt Nam. Chill thôi, cuộc sống ngon hơn với SnackVibe 🧡
                </p>
                <div class="flex gap-3 mt-2">
                    <a href="#" class="w-9 h-9 rounded-full bg-white/5 flex items-center justify-center hover:bg-[#D4A373] hover:text-white transition duration-300">👍</a>
                    <a href="#" class="w-9 h-9 rounded-full bg-white/5 flex items-center justify-center hover:bg-[#D4A373] hover:text-white transition duration-300">📸</a>
                    <a href="#" class="w-9 h-9 rounded-full bg-white/5 flex items-center justify-center hover:bg-[#D4A373] hover:text-white transition duration-300">🎵</a>
                </div>
            </div>
            
            <div>
                <h4 class="text-white font-bold text-base mb-4 relative after:content-[''] after:block after:w-8 after:h-0.5 after:bg-[#D4A373] after:mt-2">Khám Phá</h4>
                <ul class="flex flex-col gap-2.5">
                    <li><a href="#" class="hover:text-[#D4A373] transition duration-200">Trang Chủ</a></li>
                    <li><a href="#menu" class="hover:text-[#D4A373] transition duration-200">Thực Đơn Món Ăn</a></li>
                    <li><a href="#" class="hover:text-[#D4A373] transition duration-200">Ưu Đãi Đặc Biệt</a></li>
                    <li><a href="#" class="hover:text-[#D4A373] transition duration-200">Tuyển Dụng</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-bold text-base mb-4 relative after:content-[''] after:block after:w-8 after:h-0.5 after:bg-[#D4A373] after:mt-2">Chính Sách</h4>
                <ul class="flex flex-col gap-2.5">
                    <li><a href="#" class="hover:text-[#D4A373] transition duration-200">Chính Sách Giao Hàng</a></li>
                    <li><a href="#" class="hover:text-[#D4A373] transition duration-200">Chính Sách Đổi Trả</a></li>
                    <li><a href="#" class="hover:text-[#D4A373] transition duration-200">Bảo Mật Thông Tin</a></li>
                    <li><a href="#" class="hover:text-[#D4A373] transition duration-200">Điều Khoản Dịch Vụ</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-bold text-base mb-4 relative after:content-[''] after:block after:w-8 after:h-0.5 after:bg-[#D4A373] after:mt-2">Liên Hệ</h4>
                <ul class="flex flex-col gap-3">
                    <li class="flex items-start gap-2">
                        <span class="text-[#D4A373]">📍</span>
                        <span>123 Đường Ăn Vặt, Quận 1, TP. Hồ Chí Minh</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-[#D4A373]">📞</span>
                        <a href="tel:19001234" class="hover:text-[#D4A373] transition duration-200">1900 1234</a>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-[#D4A373]">✉️</span>
                        <a href="mailto:contact@snackvibe.com" class="hover:text-[#D4A373] transition duration-200">contact@snackvibe.com</a>
                    </li>
                    <li class="flex items-center gap-2 pt-2 border-t border-[#4A3E3D]/30 text-xs text-white/50">
                        <span>⏰ Giờ mở cửa: 08:00 - 22:30 (Mỗi ngày)</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="max-w-6xl mx-auto pt-8 border-t border-[#4A3E3D]/30 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-white/40">
            <p>&copy; 2026 SnackVibe. All rights reserved.</p>
            <p>Designed with 🧡 for Snack Lovers</p>
        </div>
    </footer>

    <script>
        const NAV_LINKS = ["Trang Chủ", "Menu", "Giới Thiệu", "Liên Hệ"];

        // =========================================================================
        // DATA: ĐÃ THAY TOÀN BỘ LINK ẢNH SANG THƯ VIỆN ẢNH CDN CHẤT LƯỢNG CAO (UNSPLASH/PEXELS)
        // =========================================================================
        const MENU_ITEMS = [
          { id: 1, name: "Tokbokki Sốt Cay Phô Mai Kéo Sợi", category: "Món Hàn", price: 45000, image: "https://images.unsplash.com/photo-1498654896293-37aaea113fd9?w=600&auto=format&fit=crop&q=60", rating: 4.9, reviewCount: 142, desc: "Bánh gạo dẻo quánh quyện sốt ớt chuẩn vị Hàn, phủ ngập lớp phô mai béo ngậy." },
          { id: 2, name: "Mì Trộn Tương Đen Jajangmyeon", category: "Mì Trộn", price: 49000, image: "https://images.unsplash.com/photo-1585032226651-759b368d7246?w=600&auto=format&fit=crop&q=60", rating: 4.7, reviewCount: 98, desc: "Sợi mì dai ngon quyện cùng nước sốt tương đen đậm đà và thịt băm." },
          { id: 3, name: "Tokbokki Lẩu Ly Siêu To Khổng Lồ", category: "Món Hàn", price: 55000, image: "https://images.unsplash.com/photo-1563379091339-03b21ab4a4f8?w=600&auto=format&fit=crop&q=60", rating: 4.8, reviewCount: 115, desc: "Sự kết hợp hoàn hảo giữa bánh gạo, chả cá Hàn Quốc, xúc xích và trứng luộc." },
          { id: 4, name: "Mì Trộn Sốt Cay Sứ Tứ Xuyên", category: "Mì Trộn", price: 42000, image: "https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?w=600&auto=format&fit=crop&q=60", rating: 4.6, reviewCount: 84, desc: "Mì trộn cay nồng kích thích vị giác, ăn kèm thịt xá xíu và rau cải giòn." },
          { id: 5, name: "Rabokki - Mì Gói Trộn Bánh Gạo", category: "Món Hàn", price: 50000, image: "https://images.unsplash.com/photo-1612966608997-30d52928e94a?w=600&auto=format&fit=crop&q=60", rating: 4.9, reviewCount: 160, desc: "Sự giao thoa tuyệt vời giữa mì ăn liền ramen dẻo dai và bánh gạo cay nồng." },
          { id: 6, name: "Mì Ý Sốt Bò Băm Cận Cảnh", category: "Mì Trộn", price: 55000, image: "https://images.unsplash.com/photo-1551183053-bf91a1d81141?w=600&auto=format&fit=crop&q=60", rating: 4.7, reviewCount: 102, desc: "Sợi mì Ý mềm dai rưới đẫm sốt cà chua bò băm đậm đà phảng phất hương thảo mộc." },
          { id: 7, name: "Gà Cuộn Sốt Gia Vị Bóng Đậm", category: "Gà Rán", price: 59000, image: "https://images.unsplash.com/photo-1606755962773-d324e0a13086?w=600&auto=format&fit=crop&q=60", rating: 4.9, reviewCount: 210, desc: "Gà chiên giòn rụm bên ngoài, mọng nước bên trong, áo lớp sốt đỏ rực bóng bẩy." },
          { id: 8, name: "Kimbap Chiên Xù Sốt Mayo Tươi", category: "Ăn Vặt", price: 35000, image: "https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?w=600&auto=format&fit=crop&q=60", rating: 4.8, reviewCount: 130, desc: "Cơm cuộn rong biển lăn bột chiên xù vàng ruộm, chấm kèm tương ớt mayo." },
          { id: 9, name: "Khoai Tây Lắc Phô Mai Sợi", category: "Ăn Vặt", price: 28000, image: "https://images.unsplash.com/photo-1576107232684-1279f390859f?w=600&auto=format&fit=crop&q=60", rating: 4.7, reviewCount: 175, desc: "Khoai tây cắt múi chiên giòn vàng ươm, phủ đẫm bột phô mai mặn ngọt." },
          { id: 10, name: "Gà Rán Tẩm Sốt Tỏi Mật Ong", category: "Gà Rán", price: 62000, image: "https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?w=600&auto=format&fit=crop&q=60", rating: 4.9, reviewCount: 198, desc: "Cánh và đùi gà rán vàng giòn kết hợp sốt tỏi mật ong ngọt dịu, thơm nức mũi." },
          { id: 11, name: "Nem Chua Rán Phố Cổ Giòn Rụm", category: "Ăn Vặt", price: 30000, image: "https://images.unsplash.com/photo-1541532713592-79a0317b6b77?w=600&auto=format&fit=crop&q=60", rating: 4.6, reviewCount: 92, desc: "Nem chua được tẩm lớp bột chiên xù giòn tan, món ăn vặt quốc dân không thể bỏ lỡ." },
          { id: 12, name: "Phô Mai Que Kéo Sợi Ngập Ngụa", category: "Ăn Vặt", price: 32000, image: "https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=600&auto=format&fit=crop&q=60", rating: 4.8, reviewCount: 140, desc: "Lớp vỏ ngoài giòn rụm che giấu khối phô mai mozzarella kéo dài cả mét." },
          { id: 13, name: "Gà Chiên Popcorn Lắc Sốt Cay", category: "Gà Rán", price: 45000, image: "https://images.unsplash.com/photo-1569058242253-92a9c755a0ec?w=600&auto=format&fit=crop&q=60", rating: 4.7, reviewCount: 105, desc: "Viên gà không xương cắt nhỏ vừa miệng, chiên giòn đều rưới sốt cay ngọt." },
          { id: 14, name: "Mực Vòng Chiên Xù Giòn Sần Sật", category: "Ăn Vặt", price: 48000, image: "https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?w=600&auto=format&fit=crop&q=60", rating: 4.5, reviewCount: 76, desc: "Mực tươi thái vòng, lăn bột chiên xù vàng ươm chấm kèm sốt tương cà ngọt dịu." },
          { id: 15, name: "Bánh Tráng Trộn Trứng Muối Khô Bò", category: "Ăn Vặt", price: 25000, image: "https://images.unsplash.com/photo-1621972750749-0fbb1abb7736?w=600&auto=format&fit=crop&q=60", rating: 4.9, reviewCount: 320, desc: "Bánh tráng sợi dai thấm tắc, khô bò xé xợi, xoài xanh băm và sốt trứng muối ngậy." },
          { id: 16, name: "Bánh Tráng Cuộn Sốt Bơ Me", category: "Ăn Vặt", price: 25000, image: "https://images.unsplash.com/photo-1608897013039-887f21d8c804?w=600&auto=format&fit=crop&q=60", rating: 4.8, reviewCount: 185, desc: "Bánh tráng cuộn tôm khô, hành phi đẫm sốt bơ béo ngậy và nước cốt me chua ngọt." },
          { id: 17, name: "Bánh Tráng Nướng Đà Lạt Topping", category: "Ăn Vặt", price: 25000, image: "https://images.unsplash.com/photo-1513104890138-7c749659a591?w=600&auto=format&fit=crop&q=60", rating: 4.7, reviewCount: 210, desc: "Pizza Việt Nam nướng trên than hồng, thơm phức mùi trứng, xúc xích và hành phi." },
          { id: 18, name: "Cá Viên Chiên Nước Mắm Tỏi Ớt", category: "Ăn Vặt", price: 35000, image: "https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=600&auto=format&fit=crop&q=60", rating: 4.9, reviewCount: 295, desc: "Mẹt xiên bẩn nâng cấp chiên phồng đảo đều trong sốt nước mắm tỏi ớt kẹo kẹo." },
          { id: 19, name: "Chân Gà Rút Xương Sả Tắc Cay", category: "Ăn Vặt", price: 50000, image: "https://images.unsplash.com/photo-1615557960916-5f4791feb692?w=600&auto=format&fit=crop&q=60", rating: 4.8, reviewCount: 167, desc: "Chân gà giòn sần sật ngấm đẫm nước cốt sả tắc chua cay, thơm nồng." },
          { id: 20, name: "Cơm Cháy Chà Bông Siêu Ruốc", category: "Ăn Vặt", price: 30000, image: "https://images.unsplash.com/photo-1600271886742-f049cd451bba?w=600&auto=format&fit=crop&q=60", rating: 4.6, reviewCount: 110, desc: "Cơm cháy chiên phồng giòn rụm phủ một lớp nước mắm ớt và chà bông dày đặc." },
          { id: 21, name: "Trà Đào Cam Sả Nhiệt Đới", category: "Đồ Uống", price: 30000, image: "https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?w=600&auto=format&fit=crop&q=60", rating: 4.8, reviewCount: 215, desc: "Vị trà thanh mát kết hợp lát cam vàng tươi, hương sả nồng nàn và đào giòn." },
          { id: 22, name: "Trà Sữa Matcha Đường Đen", category: "Đồ Uống", price: 35000, image: "https://images.unsplash.com/photo-1536256263959-770b48d82b0a?w=600&auto=format&fit=crop&q=60", rating: 4.8, reviewCount: 189, desc: "Cốt trà xanh Nhật Bản đậm vị chát nhẹ hòa quyện sữa tươi béo và trân châu dẻo." },
          { id: 23, name: "Sữa Tươi Trân Châu Đường Đen", category: "Đồ Uống", price: 38000, image: "https://images.unsplash.com/photo-1541658016709-82535e94bc69?w=600&auto=format&fit=crop&q=60", rating: 4.9, reviewCount: 245, desc: "Sữa tươi thanh trùng kết hợp những vân đường đen bao quanh ly cực đẹp mắt." },
          { id: 24, name: "Trà Dâu Tây Đá Xay Thanh Mát", category: "Đồ Uống", price: 35000, image: "https://images.unsplash.com/photo-1497534446932-c925b458314e?w=600&auto=format&fit=crop&q=60", rating: 4.7, reviewCount: 134, desc: "Dâu tây tươi mọng nước xay nhuyễn cùng đá mang lại màu đỏ hồng rực rỡ ngọt ngào." },
          { id: 25, name: "Trà Trái Cây Nhiệt Đới Topping", category: "Đồ Uống", price: 39000, image: "https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?w=600&auto=format&fit=crop&q=60", rating: 4.8, reviewCount: 156, desc: "Trà lài thơm ngát kết hợp cùng chanh dây, dưa hấu, xoài chín xắt hạt lựu sinh động." },
          { id: 26, name: "Milky Matcha Latte Phân Tầng", category: "Đồ Uống", price: 35000, image: "https://images.unsplash.com/photo-1578314675249-a6910f80cc4e?w=600&auto=format&fit=crop&q=60", rating: 4.7, reviewCount: 112, desc: "Ly nước nghệ thuật phân 2 tầng rõ rệt giữa sữa tươi trắng mịn và matcha xanh ngọc." },
          { id: 27, name: "Nước Ép Lựu Đỏ Nguyên Chất", category: "Đồ Uống", price: 40000, image: "https://images.unsplash.com/photo-1622483767028-3f66f32aef97?w=600&auto=format&fit=crop&q=60", rating: 4.8, reviewCount: 88, desc: "Màu đỏ mọng tự nhiên 100% từ những hạt lựu tươi, giàu vitamin và làm sáng da." },
          { id: 28, name: "Bánh Crepe Sầu Riêng Ngàn Lớp", category: "Ăn Vặt", price: 45000, image: "https://images.unsplash.com/photo-1551024601-bec78aea704b?w=600&auto=format&fit=crop&q=60", rating: 4.9, reviewCount: 176, desc: "Lớp vỏ bánh mỏng mịn cuộn chặt lớp kem tươi và cơm sầu riêng nguyên chất thơm nức." },
          { id: 29, name: "Bánh Tiramisu Truyền Thống Ý", category: "Ăn Vặt", price: 42000, image: "https://images.unsplash.com/photo-1571877227200-a0d98ea607e9?w=600&auto=format&fit=crop&q=60", rating: 4.8, reviewCount: 124, desc: "Bánh ngọt trứ danh đượm hương cà phê, cacao hòa quyện phô mai Mascarpone mềm mượt." },
          { id: 30, name: "Pudding Trứng Sốt Caramel", category: "Ăn Vặt", price: 22000, image: "https://images.unsplash.com/photo-1528975604071-b4dc52a2d18c?w=600&auto=format&fit=crop&q=60", rating: 4.9, reviewCount: 203, desc: "Bánh pudding màu vàng óng, mềm tan ngay đầu lưỡi hòa quyện cùng sốt caramel đắng ngọt." }
        ];

        let cart = [];

        // Tạo cấu trúc thẻ Ngôi sao đánh giá bằng mã SVG tinh gọn
        function generateStarRatingHtml(rating) {
          let html = `<div class="flex gap-0.5">`;
          for (let i = 1; i <= 5; i++) {
            html += `<svg width="14" height="14" viewBox="0 0 24 24" fill="${i <= Math.floor(rating) ? '#D4A373' : '#e5e7eb'}"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>`;
          }
          html += `</div>`;
          return html;
        }

        // KHỞI TẠO WEBSITE KHI TRANG TẢI XONG
        document.addEventListener("DOMContentLoaded", () => {
          renderNavbarLinks();
          renderMenuItems();
          setupEventListeners();
          setupIntersectionObserver();
          setupAuthEvents();
        });

        function renderNavbarLinks() {
          const container = document.getElementById("nav-links-container");
          container.innerHTML = NAV_LINKS.map(link => `
            <a href="#" class="text-white/90 text-sm font-semibold transition-colors duration-200 hover:text-[#D4A373] nav-item-link">${link}</a>
          `).join('');
        }

        function renderMenuItems() {
          const container = document.getElementById("menu-items-container");
          container.innerHTML = MENU_ITEMS.map((item, idx) => `
            <div class="fade-up-element bg-white rounded-3xl overflow-hidden shadow-md cursor-pointer transition-all duration-300 hover:-translate-y-2 hover:shadow-xl group" style="transition-delay: ${idx * 0.02}s">
              <div class="relative h-[220px] overflow-hidden bg-gray-100">
                <img src="${item.image}" alt="${item.name}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" loading="lazy">
                <div class="absolute top-3 right-3 bg-black/60 text-white px-3 py-1 rounded-full text-[11px] font-semibold backdrop-blur-sm">${item.category}</div>
              </div>
              <div class="p-5 flex flex-col justify-between h-[180px]">
                <div>
                    <h3 class="font-extrabold text-base mb-1 text-[#4A3E3D] line-clamp-1">${item.name}</h3>
                    <p class="text-xs text-gray-400 line-clamp-2 mb-2">${item.desc}</p>
                    <div class="flex items-center gap-2 mb-3">
                      ${generateStarRatingHtml(item.rating)}
                      <span class="text-xs text-gray-400">(${item.reviewCount})</span>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-auto">
                  <span class="text-[#D4A373] font-black text-lg">${item.price.toLocaleString('vi-VN')}₫</span>
                  <button onclick="addToCart(${item.id})" class="bg-[#D4A373] text-white border-none px-4 py-2 rounded-full text-xs font-bold cursor-pointer transition duration-200 hover:bg-[#C39262]">+ Thêm</button>
                </div>
              </div>
            </div>
          `).join('');
        }

        function setupIntersectionObserver() {
          const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
              if (entry.isIntersecting) entry.target.classList.add("visible");
            });
          }, { threshold: 0.05 });
          document.querySelectorAll(".fade-up-element").forEach(el => observer.observe(el));
        }

        function setupEventListeners() {
          window.addEventListener("scroll", () => {
            const navbar = document.getElementById("navbar");
            const logo = document.getElementById("nav-logo");
            const navLinks = document.querySelectorAll(".nav-item-link");
            const navAuthTexts = document.querySelectorAll(".nav-auth-text");

            if (window.scrollY > 60) {
              navbar.classList.add("bg-[#FCF8F2]/97", "backdrop-blur-md", "shadow-[0_2px_30px_rgba(0,0,0,0.08)]");
              logo.classList.replace("text-white", "text-[#4A3E3D]");
              navLinks.forEach(link => link.classList.replace("text-white/90", "text-[#4A3E3D]"));
              navAuthTexts.forEach(text => text.classList.replace("text-white", "text-[#4A3E3D]"));
            } else {
              navbar.classList.remove("bg-[#FCF8F2]/97", "backdrop-blur-md", "shadow-[0_2px_30px_rgba(0,0,0,0.08)]");
              logo.classList.replace("text-[#4A3E3D]", "text-white");
              navLinks.forEach(link => link.classList.replace("text-[#4A3E3D]", "text-white/90"));
              navAuthTexts.forEach(text => text.classList.replace("text-[#4A3E3D]", "text-white"));
            }
          });

          document.getElementById("open-cart").addEventListener("click", () => toggleCartDrawer(true));
          document.getElementById("close-cart").addEventListener("click", () => toggleCartDrawer(false));
          document.getElementById("cart-overlay").addEventListener("click", () => toggleCartDrawer(false));
        }

        // LOGIC CHUYỂN ĐỔI FORM ĐĂNG NHẬP / ĐĂNG KÝ
        function setupAuthEvents() {
          const authModal = document.getElementById("auth-modal");
          const loginContainer = document.getElementById("login-form-container");
          const registerContainer = document.getElementById("register-form-container");

          const openLoginModal = () => {
              authModal.classList.remove("hidden");
              loginContainer.classList.remove("hidden");
              registerContainer.classList.add("hidden");
          };

          const openRegisterModal = () => {
              authModal.classList.remove("hidden");
              loginContainer.classList.add("hidden");
              registerContainer.classList.remove("hidden");
          };

          document.getElementById("nav-login-btn").addEventListener("click", openLoginModal);
          if (document.getElementById("hero-login-btn")) {
              document.getElementById("hero-login-btn").addEventListener("click", openLoginModal);
          }

          document.getElementById("nav-register-btn").addEventListener("click", openRegisterModal);
          document.getElementById("close-auth").addEventListener("click", () => authModal.classList.add("hidden"));
          document.getElementById("auth-overlay").addEventListener("click", () => authModal.classList.add("hidden"));

          document.getElementById("switch-to-register").addEventListener("click", (e) => {
              e.preventDefault();
              loginContainer.classList.add("hidden");
              registerContainer.classList.remove("hidden");
          });

          document.getElementById("switch-to-login").addEventListener("click", (e) => {
              e.preventDefault();
              registerContainer.classList.add("hidden");
              loginContainer.classList.remove("hidden");
          });
          
          if (document.getElementById("hero-menu-btn")) {
              document.getElementById("hero-menu-btn").addEventListener("click", () => {
                  document.getElementById("menu").scrollIntoView({ behavior: 'smooth' });
              });
          }
        }

        function toggleCartDrawer(open) {
          const drawer = document.getElementById("cart-drawer");
          if (open) drawer.classList.remove("hidden");
          else drawer.classList.add("hidden");
        }

        function addToCart(itemId) {
          const item = MENU_ITEMS.find(i => i.id === itemId);
          if (!item) return;

          const existing = cart.find(i => i.id === itemId);
          if (existing) {
            existing.qty += 1;
          } else {
            cart.push({ ...item, qty: 1 });
          }

          updateCartUi();
          triggerToast(item.name);
        }

        function changeQty(itemId, amount) {
          const item = cart.find(i => i.id === itemId);
          if (!item) return;

          item.qty += amount;
          if (item.qty <= 0) {
            cart = cart.filter(i => i.id !== itemId);
          }
          updateCartUi();
        }

        function updateCartUi() {
          const totalItems = cart.reduce((acc, curr) => acc + curr.qty, 0);
          const badge = document.getElementById("cart-badge");
          const drawerCount = document.getElementById("cart-count-drawer");
          drawerCount.innerText = totalItems;

          if (totalItems > 0) {
            badge.classList.remove("hidden");
            badge.innerText = totalItems;
            document.getElementById("cart-checkout-btn").classList.remove("hidden");
          } else {
            badge.classList.add("hidden");
            document.getElementById("cart-checkout-btn").classList.add("hidden");
          }

          const container = document.getElementById("cart-items-container");
          if (cart.length === 0) {
            container.innerHTML = `<p class="text-gray-400 text-center mt-20">Giỏ hàng trống 😊</p>`;
            return;
          }

          container.innerHTML = cart.map(item => `
            <div class="flex gap-3 p-3 bg-white rounded-2xl items-center border border-[#EED9C4]">
              <img src="${item.image}" alt="${item.name}" class="w-14 h-14 rounded-xl object-cover">
              <div class="flex-1">
                <div class="font-bold text-sm text-[#4A3E3D] line-clamp-1">${item.name}</div>
                <div class="text-[#D4A373] font-bold text-xs mt-0.5">${item.price.toLocaleString('vi-VN')}₫</div>
              </div>
              <div class="flex items-center gap-2">
                <button onclick="changeQty(${item.id}, -1)" class="w-7 h-7 rounded-full border-2 border-[#D4A373] bg-transparent text-[#D4A373] font-bold cursor-pointer text-sm flex items-center justify-center">-</button>
                <span class="font-bold min-w-4 text-center text-sm">${item.qty}</span>
                <button onclick="changeQty(${item.id}, 1)" class="w-7 h-7 rounded-full border-none bg-[#D4A373] text-white font-bold cursor-pointer text-sm flex items-center justify-center">+</button>
              </div>
            </div>
          `).join('');
        }

        function triggerToast(itemName) {
          const toast = document.getElementById("toast");
          document.getElementById("toast-message").innerText = itemName;
          toast.classList.remove("opacity-0", "pointer-events-none");
          toast.classList.add("opacity-100");

          setTimeout(() => {
            toast.classList.remove("opacity-100");
            toast.classList.add("opacity-0", "pointer-events-none");
          }, 2500);
        }
    </script>
</body>
</html>