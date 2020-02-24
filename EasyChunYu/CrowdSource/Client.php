<?php
/**
 * 普通众包/众包升级服务
 * https://www.chunyuyisheng.com/cooperation/open_api/interface/server/#402
 */

namespace EasyChunYu\CrowdSource;


use EasyChunYu\Kernel\Support\BaseClient;

class Client extends BaseClient
{
    // 创建众包问题接口
    public function create($userId, $content, $clinicNo = '') {
        return $this->request('/cooperation/server/free_problem/create', [
            'user_id' => $userId,
            'content' => $content,
            'clinic_no' => $clinicNo
        ]);
    }

    // 创建众包升级问题接口
    public function upgrade($userId, $content, $orderId, $payType, $clinicNo = '') {
        return $this->request('/cooperation/server/problem/create_paid_problem/', [
            'user_id' => $userId,
            'content' => $content,
            'partner_order_id' => $orderId,
            'pay_type' => $payType,
            'clinic_no' => $clinicNo
        ]);
    }


}
