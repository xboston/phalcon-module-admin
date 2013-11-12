<?php

namespace AutoAdmin\Helpers {

    class FieldParams
    {

        protected $_params = array();

        public function setParams($params)
        {
            $this->_params = array_merge_recursive((array) $this->_params, (array) $params);
        }

        public function getParams()
        {
            return $this->_params;
        }

        public function setParam($key, $value)
        {
            $this->_params[$key] = $value;
        }

        public function getParam($key, $default = null)
        {
            if (isset($this->_params[$key])) {
                return $this->_params[$key];
            }

            if ( ! substr_count($key, '.')) {
                return $default;
            }

            $keys   = explode('.', $key);
            $values = $this->_params;

            do {
                $key = array_shift($keys);
                if ( ! isset($values[$key])) {
                    return $default;
                }

                $values = $values[$key];

                if ( ! $keys) {
                    return $values;
                }
            } while ($keys);

            return $default;
        }

    }
}
