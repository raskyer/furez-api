<?php
    $bundles_controller = array();
    $bundles_views = array();
    foreach($dom->bundles->bundle as $bundle) {
        if(isset($bundle->attributes()['controller'])) {
            $bundles_controller[] = (string) $bundle->attributes()['controller'];
        }
        if(isset($bundle->views)) {
            foreach($bundle->views as $view) {
                $view = (array) $view[0];
                $bundles_views[] = $view['view'];
            }
        }
    }

    $_SESSION['bundles_controller'] = $bundles_controller;
    $_SESSION['bundles_views'] = $bundles_views;
