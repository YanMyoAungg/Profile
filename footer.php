<footer class="bg-light text-center mt-5">
    <div class="container p-4">
        <div class="row">
            <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
                <div class="text-center text-lg-start">
                    <h5 class="text-uppercase">FoodFusion</h5>
                    <p>
                        Bringing culinary enthusiasts together.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                <div class="d-inline-block text-start">
                    <h5 class="text-uppercase">Links</h5>
                    <ul class="list-unstyled mb-0">
                        <li><a href="about.php" class="text-dark">About Us</a></li>
                        <li><a href="contact.php" class="text-dark">Contact</a></li>
                        <li><a href="privacy_cookie_policy.php" class="text-dark">Privacy & Cookie Policy </a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                <div class="d-inline-block text-start">
                    <h5 class="text-uppercase">Follow Us</h5>
                    <ul class="list-unstyled mb-0">
                        <li><a href="#" class="text-dark">Facebook</a></li>
                        <li><a href="#" class="text-dark">Instagram</a></li>
                        <li><a href="#" class="text-dark">Twitter</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center p-3 bg-dark text-white">
        © <?php echo date("Y"); ?> FoodFusion
    </div>
</footer>

<script src="js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (!localStorage.getItem("cookieConsent")) {
            let consent = document.createElement("div");
            consent.innerHTML = `
                    <div class="fixed-bottom bg-dark text-white p-3 text-center" id="cookieConsentBanner">
                        <p class="d-inline">We use cookies to improve your experience.</p>
                        <button class="btn btn-light btn-sm ms-2" id="acceptCookies">Accept</button>
                    </div>
                `;
            document.body.appendChild(consent);

            document.getElementById("acceptCookies").addEventListener("click", function () {
                localStorage.setItem("cookieConsent", "true");
                document.getElementById("cookieConsentBanner").remove();
            });
        }
    });
</script>
</body>

</html>