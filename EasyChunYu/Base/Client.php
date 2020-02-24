<?php


namespace EasyChunYu\Base;


use EasyChunYu\Kernel\Support\BaseClient;

class Client extends BaseClient
{
    /**
     * 账号同步/注册接口
     * 账号不存在 春雨会为该用户创建一个新账号,并登陆
     * 账号已存在 春雨为当前用户执行登录操作，不必每次请求，新用户只要同步过一次即可
     * @param $userId
     * @param $password
     * @param string $lng
     * @param string $lat
     * @return array
     */
    public function login($userId, $password, $lng = '', $lat = '') {
        return $this->request('/cooperation/server/login', [
            'user_id' => $userId,
            'password' => $password,
            'lon' => $lng,
            'lat' => $lat
        ]);
    }

    // sign值验证
    public function verify($userId, $atime, $sign) {
        $s = substr(md5($this->app['config']['partner_key'].$atime.$userId), 8, 16);
        return $s === $sign;
    }

    // 医生回复数据验证
    public function verifyReply($data) {
        if (empty($data['atime']) || empty($data['sign']) || empty($data['problem_id'])) {
            return false;
        }
        // 验证

        if ($this->app['base']->verify($data['problem_id'], $data['atime'], $data['sign'])) {
            return true;
        }

        return false;
    }

}
