function navUpdate() {
    const navLinks = document.querySelectorAll(".nav-link");
    const currentPage = window.location.pathname.split('/').pop(); // Get the current page name

    navLinks.forEach((navLink) => {
        const linkPath = navLink.getAttribute('href').split('/').pop(); // Get the link's page name
        if (linkPath === currentPage) {
            navLink.classList.add("active");
        }

        navLink.addEventListener("click", function () {
            navLinks.forEach((link) => link.classList.remove("active"));

            this.classList.add("active");
        });
    });
}

// Call it when the DOM is ready
document.addEventListener("DOMContentLoaded", navUpdate);