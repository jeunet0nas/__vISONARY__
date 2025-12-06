<div class="sidebar border-end col-md-3 col-lg-2 p-0" style="background-color: #f8f9fa; border-color: #e5e7eb !important; min-height: calc(100vh - 60px);" id="admin-side-bar">
    <div class="offcanvas-md offcanvas-end" style="background-color: #f8f9fa;" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header" style="border-bottom: 1px solid #e5e7eb;">
            <h5 class="offcanvas-title fw-bold" id="sidebarMenuLabel" style="color: #1a1a1a;">
                <i class="fas fa-glasses me-2"></i>Visonary Admin
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-md-flex flex-column p-0 overflow-y-auto">
            <div class="py-4 px-3 text-center" style="border-bottom: 1px solid #e5e7eb;">
                <h6 class="text-muted mb-0" style="font-size: 0.75rem; letter-spacing: 0.05em; text-transform: uppercase;">Menu</h6>
            </div>
            <ul class="nav flex-column px-2 py-3">
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center gap-3 px-3 py-2 rounded"
                       style="color: #6b7280; font-size: 0.875rem; transition: all 0.2s;"
                       onmouseover="this.style.backgroundColor='#e5e7eb'; this.style.color='#1a1a1a';"
                       onmouseout="this.style.backgroundColor='transparent'; this.style.color='#6b7280';"
                       href="{{route('admin.index')}}">
                        <i class="fas fa-chart-line" style="width: 20px; text-align: center;"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center gap-3 px-3 py-2 rounded"
                       style="color: #6b7280; font-size: 0.875rem; transition: all 0.2s;"
                       onmouseover="this.style.backgroundColor='#e5e7eb'; this.style.color='#1a1a1a';"
                       onmouseout="this.style.backgroundColor='transparent'; this.style.color='#6b7280';"
                       href="{{ route('admin.collections.index') }}">
                        <i class="fas fa-layer-group" style="width: 20px; text-align: center;"></i>
                        <span>Bộ sưu tập</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center gap-3 px-3 py-2 rounded"
                       style="color: #6b7280; font-size: 0.875rem; transition: all 0.2s;"
                       onmouseover="this.style.backgroundColor='#e5e7eb'; this.style.color='#1a1a1a';"
                       onmouseout="this.style.backgroundColor='transparent'; this.style.color='#6b7280';"
                       href="{{ route('admin.products.index') }}">
                        <i class="fas fa-glasses" style="width: 20px; text-align: center;"></i>
                        <span>Sản phẩm</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center gap-3 px-3 py-2 rounded"
                       style="color: #6b7280; font-size: 0.875rem; transition: all 0.2s;"
                       onmouseover="this.style.backgroundColor='#e5e7eb'; this.style.color='#1a1a1a';"
                       onmouseout="this.style.backgroundColor='transparent'; this.style.color='#6b7280';"
                       href="{{ route('admin.coupons.index') }}">
                        <i class="fas fa-tags" style="width: 20px; text-align: center;"></i>
                        <span>Mã khuyến mãi</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center gap-3 px-3 py-2 rounded"
                       style="color: #6b7280; font-size: 0.875rem; transition: all 0.2s;"
                       onmouseover="this.style.backgroundColor='#e5e7eb'; this.style.color='#1a1a1a';"
                       onmouseout="this.style.backgroundColor='transparent'; this.style.color='#6b7280';"
                       href="{{ route('admin.orders.index') }}">
                        <i class="fas fa-shopping-bag" style="width: 20px; text-align: center;"></i>
                        <span>Đơn hàng</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center gap-3 px-3 py-2 rounded"
                       style="color: #6b7280; font-size: 0.875rem; transition: all 0.2s;"
                       onmouseover="this.style.backgroundColor='#e5e7eb'; this.style.color='#1a1a1a';"
                       onmouseout="this.style.backgroundColor='transparent'; this.style.color='#6b7280';"
                       href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users" style="width: 20px; text-align: center;"></i>
                        <span>Người dùng</span>
                    </a>
                </li>
            </ul>
            <div class="mt-auto" style="border-top: 1px solid #e5e7eb;">
                <ul class="nav flex-column px-2 py-3">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-3 px-3 py-2 rounded"
                           style="color: #dc2626; font-size: 0.875rem; transition: all 0.2s;"
                           onmouseover="this.style.backgroundColor='#fee2e2'; this.style.color='#991b1b';"
                           onmouseout="this.style.backgroundColor='transparent'; this.style.color='#dc2626';"
                           href="#"
                           onclick="event.preventDefault(); document.getElementById('AdminLogoutForm').submit();">
                            <i class="fas fa-sign-out-alt" style="width: 20px; text-align: center;"></i>
                            <span>Đăng xuất</span>
                        </a>

                        <form id="AdminLogoutForm" action="{{route('admin.logout')}}" method="post" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
