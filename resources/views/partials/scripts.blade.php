<!-- Core JS -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

<!-- Owl Carousel -->
<script src="{{ asset('js/owl.carousel.js') }}"></script>

<!-- Custom JS -->
<script src="{{ asset('js/script.js') }}"></script>

<!-- Mobile Menu Toggle Script -->
<script>
    (function() {
        const mobileMenuToggle = document.querySelector(".mobile-menu-toggle");
        const mobileMenu = document.querySelector(".mobile-menu");
        const mobileMenuClose = document.querySelector(".mobile-menu-close");
        const mobileMenuOverlay = document.querySelector(".mobile-menu-overlay");
        const body = document.body;

        function openMenu() {
            if (mobileMenu) mobileMenu.classList.add("show");
            if (mobileMenuOverlay) mobileMenuOverlay.classList.add("show");
            if (body) body.style.overflow = "hidden";
        }

        function closeMenu() {
            if (mobileMenu) mobileMenu.classList.remove("show");
            if (mobileMenuOverlay) mobileMenuOverlay.classList.remove("show");
            if (body) body.style.overflow = "";

            if (mobileMenu) {
                const openDropdowns = mobileMenu.querySelectorAll(".dropdown-menu.show");
                openDropdowns.forEach((dropdown) => {
                    dropdown.classList.remove("show");
                });
            }
        }

        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener("click", function(e) {
                e.preventDefault();
                openMenu();
            });
        }

        if (mobileMenuClose) {
            mobileMenuClose.addEventListener("click", function(e) {
                e.preventDefault();
                closeMenu();
            });
        }

        if (mobileMenuOverlay) {
            mobileMenuOverlay.addEventListener("click", closeMenu);
        }

        window.addEventListener("resize", function() {
            if (window.innerWidth > 991) {
                closeMenu();
            }
        });

        document.addEventListener("keydown", function(e) {
            if (e.key === "Escape" && mobileMenu && mobileMenu.classList.contains("show")) {
                closeMenu();
            }
        });
    })();
</script>

@stack('scripts')
