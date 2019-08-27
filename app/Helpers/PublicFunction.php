<?php

namespace App\Helpers;

/**
 * 封装一些公共方法
 * Trait PublicFunction
 * @package App\Helpers
 */
trait PublicFunction
{

    public function userPasswordEncode($password, $password_salt, $id)
    {

        $password = md5($password);

        $password_salt = md5($password_salt);

        if (empty($password) || empty($password_salt) || empty($id)) return false;

        $length = substr($id, -1);
        $length = intval($length) + 7;

        $encode_string = '';

        $encode_string .= substr($password_salt, 0, $length);

        $encode_string .= substr($password, 0, $length);

        $encode_string .= substr($password, $length, (32 - $length));

        $encode_string .= substr($password_salt, $length, (32 - $length));

        return md5($encode_string);

    }

    public function dealOptions($list, $key, $value)
    {

        $options = [];

        if ($list) {

            foreach ($list as $k => $v) {

                $options[$k] = array('value' => $v[$key], 'label' => $v[$value]);

                if (isset($v['children']) && $v['children']) {

                    foreach ($v['children'] as $vk => $vv) {

                        $options[$k]['children'][$vk] = array('value' => $vv[$key], 'label' => $vv[$value]);

                        if (isset($vv['children']) && $vv['children']) {

                            foreach ($vv['children'] as $vvk => $vvv) {

                                $options[$k]['children'][$vk]['children'][$vvk] = array('value' => $vvv[$key], 'label' => $vvv[$value]);

                            }

                        }

                    }

                }

            }

        }

        return ['options'=>$options];

    }

}
