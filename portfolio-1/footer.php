<footer>
    <div class="container">
        <div class="row">
      <?php if(is_active_sidebar('widgetized-footer')): ?>

        <?php dynamic_sidebar('widgetized-footer'); ?>

       <?php else: ?>

            <div class="col-12">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
                    dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
                    dolor in.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure .</p>
            </div>
    <?php endif; ?>
        </div><!-- /row -->
    </div><!-- /container -->

</footer>

<?php wp_footer();

if (isset($_SESSION['contact-result']) && !is_page('contact')):
unset($_SESSION['contact-result']);
endif;
?>

</body>
</html>