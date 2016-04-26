<div class="wrap">
    <h2>Franchise Manager</h2>
    <form method="post" action="options.php"> 
        <?php @settings_fields('franchise-manager-group'); ?><!-- creates hidden form content -->
        <?php @do_settings_fields('franchise-manager-group'); ?>

        <?php do_settings_sections('franchise-manager'); ?><!--displays all form content-->

        <?php @submit_button(); ?>
    </form>
</div>