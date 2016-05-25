<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

class CustomClientScript extends CClientScript {

    protected $dependencies = array();
    protected $priority = array();

    public function renderHead(&$output) {

        if (!empty($this->priority)) {

            asort($this->priority);

            $currentCssFiles = $this->cssFiles;
            $this->cssFiles = array_diff_key($this->cssFiles, $this->priority);

            foreach ($this->priority as $script => $prio) {
                $this->cssFiles[$script] = $currentCssFiles[$script];
            }
        }


        parent::renderHead($output);
    }

    public function registerCssFile($url, $order = null, $media = '') {
        $this->setOrder($url, $order);

        return parent::registerCssFile($url, $media);
    }

    public function registerCss($id, $css, $order = null, $media = '') {
        $this->setOrder($id, $order);

        return parent::registerCss($id, $css, $media);
    }

    private function setOrder($identifier, $order) {
        if (!is_null($order)) {
            if (is_array($order)) {
                $this->dependencies[$identifier] = $order;
            } elseif (is_numeric($order)) {
                $this->priority[$identifier] = $order;
            }
        }
    }
}