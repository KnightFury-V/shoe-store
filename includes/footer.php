</main>
    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Shoe Store. All rights reserved.</p>
        </div>
    </footer>
    <?php if (isset($additionalScripts)) {
        foreach ($additionalScripts as $script) {
            echo '<script src="' . SITE_URL . '/assets/js/' . $script . '"></script>';
        }
    } ?>
</body>
</html>
