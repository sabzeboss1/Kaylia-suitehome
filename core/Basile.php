<?php

/**
 * Basile - Micro framework PHP pour Kaylia Suite Home
 */
class Basile {
    
    private static $instance = null;
    private $config = [];
    private $data = [];
    
    private function __construct() {
        $this->config = [
            'site_name' => 'Kaylia Suite Home',
            'site_tagline' => "L'Art du Confort et du Luxe à Yaoundé",
            'base_url' => $this->getBaseUrl(),
            'assets_url' => $this->getBaseUrl() . '/assets'
        ];
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function getBaseUrl() {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $script = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
        return $protocol . '://' . $host . $script;
    }
    
    public function config($key, $value = null) {
        if ($value === null) {
            return isset($this->config[$key]) ? $this->config[$key] : null;
        }
        $this->config[$key] = $value;
        return $this;
    }
    
    public function set($key, $value) {
        $this->data[$key] = $value;
        return $this;
    }
    
    public function get($key, $default = null) {
        return isset($this->data[$key]) ? $this->data[$key] : $default;
    }
    
    public function render($view, $data = []) {
        extract(array_merge($this->data, $data));
        $viewFile = __DIR__ . '/../views/' . $view . '.php';
        
        if (!file_exists($viewFile)) {
            throw new Exception("View not found: {$view}");
        }
        
        include $viewFile;
    }
    
    public function partial($partial, $data = []) {
        extract(array_merge($this->data, $data));
        $partialFile = __DIR__ . '/../views/partials/' . $partial . '.php';
        
        if (!file_exists($partialFile)) {
            throw new Exception("Partial not found: {$partial}");
        }
        
        include $partialFile;
    }
    
    public function url($path = '') {
        return $this->config('base_url') . '/' . ltrim($path, '/');
    }
    
    public function asset($path) {
        return $this->config('assets_url') . '/' . ltrim($path, '/');
    }
}
