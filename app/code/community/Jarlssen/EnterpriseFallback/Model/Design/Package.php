<?php

class Jarlssen_EnterpriseFallback_Model_Design_Package extends Mage_Core_Model_Design_Package
{
    public function getFilename($file, array $params)
    {
        if ($this->getArea() == 'adminhtml') {
            return parent::getFilename($file, $params);
        } else {
            Varien_Profiler::start(__METHOD__);
            $this->updateParamDefaults($params);
            $result = $this->_fallback($file, $params, array(
                array(),
                array('_theme' => $this->getFallbackTheme()),
                array('_theme' => self::DEFAULT_THEME),
                array('_theme' => 'default', '_package' => 'enterprise'),
            ));
            Varien_Profiler::stop(__METHOD__);
            return $result;
        }
    }

    public function getSkinUrl($file = null, array $params = array())
    {
        if ($this->getArea() == 'adminhtml') {
            return parent::getSkinUrl($file, $params);
        } else {
            Varien_Profiler::start(__METHOD__);
            if (empty($params['_type'])) {
                $params['_type'] = 'skin';
            }
            if (empty($params['_default'])) {
                $params['_default'] = false;
            }
            $this->updateParamDefaults($params);
            if (!empty($file)) {
                $this->_fallback($file, $params, array(
                    array(),
                    array('_theme' => $this->getFallbackTheme()),
                    array('_theme' => self::DEFAULT_THEME),
                    array('_theme' => 'default', '_package' => 'enterprise'),
                ));
            }
            $result = $this->getSkinBaseUrl($params) . (empty($file) ? '' : $file);
            Varien_Profiler::stop(__METHOD__);
            return $result;
        }
    }
}