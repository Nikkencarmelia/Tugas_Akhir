<!-- Components/staff_purchasing.blade.php -->
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Staff Purchasing</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

        <style>
            :root {
                --sidebar-bg: #065f46;
                --sidebar-hover: #047857;
                --sidebar-active: #064e3b;
                --border-light: #e2e8f0;
                --bg-light: #f8f9fa;
                --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            body {
                background-color: var(--bg-light);
                font-family: 'Nunito', sans-serif;
                line-height: 1.6;
            }

            h1, h2, h3, h4, h5, h6, .nav-link, .btn {
                font-family: 'Montserrat', sans-serif;
            }

            /* Desktop Sidebar */
            .sidebar-desktop {
                height: 100vh;
                width: 250px;
                position: fixed;
                left: 0;
                top: 0;
                background: linear-gradient(180deg, var(--sidebar-bg) 0%, #047857 100%);
                color: white;
                padding-top: 25px;
                display: flex;
                flex-direction: column;
                box-shadow: 2px 0 20px rgba(0,0,0,0.1);
                z-index: 1030;
                transition: var(--transition);
            }

            .sidebar-desktop h4 {
                font-weight: 600;
                text-align: center;
                margin-bottom: 35px;
                color: white;
                font-size: 1.25rem;
            }

            .sidebar-desktop .nav-link {
                display: flex;
                align-items: center;
                gap: 10px;
                color: white;
                padding: 12px 20px;
                font-size: 15px;
                font-weight: 500;
                margin-right: 10px;
                border-radius: 0 12px 12px 0;
                transition: var(--transition);
            }

            .sidebar-desktop .nav-link:hover {
                background-color: rgba(255,255,255,0.1);
                padding-left: 25px;
                transform: translateX(5px);
                color: white;
            }

            .sidebar-desktop .nav-link.active {
                background-color: var(--sidebar-active);
                padding-left: 25px;
                box-shadow: inset 3px 0 0 white;
            }

            /* Main Content Container */
            .main-content {
                padding: 1.5rem;
                min-height: 100vh;
                transition: var(--transition);
            }

            /* Mobile Sidebar */
            .sidebar-mobile {
                --bs-offcanvas-width: 280px;
                --bs-offcanvas-bg: var(--sidebar-bg);
            }
            .sidebar-mobile .nav-link {
                display: flex;
                align-items: center;
                gap: 10px;
                color: white;
                padding: 12px 20px;
                font-size: 15px;
                font-weight: 500;
            }
            .sidebar-mobile .nav-link.active {
                background-color: var(--sidebar-active);
                box-shadow: inset 3px 0 0 white;
            }

            /* Mobile Header */
            .mobile-header {
                background: white;
                box-shadow: 0 2px 10px rgba(0,0,0,0.08);
                padding: 0.75rem 1rem;
                z-index: 1040;
                border-bottom: 1px solid var(--border-light);
                position: sticky;
                top: 0;
            }

            /* Responsive Logic */
            @media (min-width: 992px) {
                .main-content {
                    margin-left: 250px; /* Push content to right on desktop */
                }
                .mobile-header {
                    display: none !important;
                }
                .sidebar-mobile {
                    display: none !important;
                }
            }

            @media (max-width: 991.98px) {
                .sidebar-desktop {
                    display: none !important;
                }
            }
        </style>
    </head>

    <body>
        <!-- Mobile Header (Visible only on mobile) -->
        <div class="mobile-header d-lg-none">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/purchasing/dashboard">Staff Purchasing</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas">
                    <i class="bi bi-list"></i>
                    </button>
                </div>
            </nav>
        </div>

        <!-- Mobile Sidebar (Offcanvas) -->
        <div class="sidebar-mobile offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Staff Purchasing</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
            </div>

            <div class="offcanvas-body">
                @include('components.staff_purchasing_nav')
            </div>
        </div>

        <!-- Desktop Sidebar (Fixed) -->
        <div class="sidebar-desktop d-none d-lg-block">
            <h4>Staff Purchasing</h4>
            @include('components.staff_purchasing_nav')
        </div>

        <!-- Main Content (Single Source of Truth) -->
        <div class="main-content">
            @yield('content')
        </div>

        <!-- Toast Notifications -->
        <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1060;">
            <div id="statusToast" class="toast align-items-center border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body fw-semibold">
                        <!-- Message will be injected here -->
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>

        <!-- Universal Confirmation Modal -->
        <div class="modal fade" id="universalConfirmModal" tabindex="-1" aria-labelledby="universalConfirmModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-success text-white border-0">
                        <h5 class="modal-title fw-bold" id="universalConfirmModalLabel">
                            <i class="bi bi-question-circle-fill me-2"></i>Konfirmasi Tindakan
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 text-center">
                        <div class="mb-3">
                            <i class="bi bi-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                        </div>
                        <h5 id="confirmMessage" class="fw-bold mb-0">Apakah Anda yakin ingin melanjutkan?</h5>
                    </div>
                    <div class="modal-footer border-0 pb-4 justify-content-center gap-2">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                        <button type="button" id="confirmActionBtn" class="btn btn-success px-4" style="border-radius: 10px;">Ya, Lanjutkan</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            /**
             * Universal Confirmation Modal Handler
             * @param {string} message - Message to display
             * @param {function} onConfirm - Callback on confirmation
             */
            window.confirmAction = function(message, onConfirm) {
                const modalEl = document.getElementById('universalConfirmModal');
                const modal = new bootstrap.Modal(modalEl);
                const confirmBtn = document.getElementById('confirmActionBtn');
                const messageEl = document.getElementById('confirmMessage');

                messageEl.textContent = message;
                
                // Clear previous listeners to avoid multiple triggers
                const newConfirmBtn = confirmBtn.cloneNode(true);
                confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);

                newConfirmBtn.addEventListener('click', () => {
                    modal.hide();
                    if (typeof onConfirm === 'function') {
                        onConfirm();
                    }
                });

                modal.show();
            };

            // Auto-show Toast from Session
            document.addEventListener('DOMContentLoaded', function() {
                const successMsg = "{{ session('success') }}";
                const errorMsg = "{{ session('error') }}";
                const toastEl = document.getElementById('statusToast');
                
                if (successMsg || errorMsg) {
                    const toastBody = toastEl.querySelector('.toast-body');
                    toastBody.textContent = successMsg || errorMsg;
                    
                    if (successMsg) {
                        toastEl.classList.add('text-bg-success');
                        toastEl.classList.remove('text-bg-danger');
                    } else {
                        toastEl.classList.add('text-bg-danger');
                        toastEl.classList.remove('text-bg-success');
                    }
                    
                    const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
                    toast.show();
                }
            });
        </script>
    </body>
</html>
