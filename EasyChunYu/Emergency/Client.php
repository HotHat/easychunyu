<?php

/**
 * 图文急诊服务
 * https://www.chunyuyisheng.com/cooperation/open_api/interface/server/#404
 * 服务流程
 * 1. 先获取图文急诊信息
 * 2. 根据获取到的科室和价格信息创建图文急诊（注意服务时间）
 */

namespace EasyChunYu\Emergency;


use EasyChunYu\Kernel\Support\BaseClient;

class Client extends BaseClient
{

    // 创建急诊问题接口
    public function create($userId, $content, $orderId, $clinicNo) {
        return $this->request('/cooperation/server/problem/create_paid_problem/', [
            'user_id' => $userId,
            'content' => $content,
            'partner_order_id' => $orderId,
            'clinic_no' => $clinicNo
        ]);
    }

    // 获取图文急诊信息接口
    public function info($userId, $content) {
        return $this->request('/cooperation/server/problem/create_paid_problem/', [
            'user_id' => $userId,
            'content' => $content
        ]);
    }


}
