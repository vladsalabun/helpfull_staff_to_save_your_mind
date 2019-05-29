<?php

    // Передаю данные в админку:
    function enqueue_my_scripts($hook) {
        echo "<script>var webSiteURL = '".get_site_url()."';</script>";
    }
    
    add_action('admin_enqueue_scripts', 'enqueue_my_scripts');