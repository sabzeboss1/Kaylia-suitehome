<?php

/**
 * Helper functions for Basile
 */

function basile() {
    return Basile::getInstance();
}

function url($path = '') {
    return basile()->url($path);
}

function asset($path) {
    return basile()->asset($path);
}

function config($key, $value = null) {
    return basile()->config($key, $value);
}

function view($view, $data = []) {
    basile()->render($view, $data);
}

function partial($partial, $data = []) {
    basile()->partial($partial, $data);
}

function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
