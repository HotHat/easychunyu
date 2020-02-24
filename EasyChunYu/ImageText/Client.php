<?php

/**
 * 定向图文服务
 * 服务流程
 * 1、申请测试 partner和partner_key，并参考基本注意事项。
 * 2、提供第三方接口用于接收医生回复通知、问题关闭通知。
 * 3、同步第三方账户信息，对于新用户发起一次即可。
 * 4、第三方查询推荐医生，获取医生列表。
 * 5、第三方创建付费问诊记录，并引导用户在第三方APP内进行付费（付费流程由第三方自己实现）。
 * 6、第三方发送付费成功通知，春雨创建付费问题后返回相关问题信息给第三方。
 * 7、第三方调用相关接口进行问题交互，方法同众包问题交互一样。
 * 8、第三方接收问题关闭通知，触发方式：第三方主动发起 或 春雨医生拒绝问题。
 * 9、测试完毕后，联系春雨人员开通正式环境账户后即可，第三方需要提供接收业务警报的邮箱地址。
 * 10、第三方开发定向问诊需用以下接口结合通用接口来完善整个流程。
 */

namespace EasyChunYu\ImageText;


use EasyChunYu\Kernel\Support\BaseClient;

class Client extends BaseClient
{

    // 找医生接口
    public function find($data) {
        return $this->request('/cooperation/server/doctor/get_clinic_doctors', $data);
    }

    // 推荐医生接口
    public function recommend($userId, $ask) {
        return $this->request('/cooperation/server/doctor/get_clinic_doctors', [
            'user_id' => $userId,
            'ask' => $ask
        ]);
    }

    // 搜索医生接口
    public function search($userId, $query, $page = 1, $province = '', $city = '') {
        return $this->request(' /cooperation/server/doctor/search_doctor', [
            'user_id' => $userId,
            'query_text' => $query,
            'page' => $page,
            'province' => $province,
            'city' => $city
        ]);

    }

    // 创建定向问题
    public function create($userId, $doctorArr, $content, $orderId, $price) {
        return $this->request('/cooperation/server/problem/create_oriented_problem', [
            'user_id' => $userId,
            'doctor_ids' => implode('#', $doctorArr),
            'content' => $content,
            'order_id' => $orderId,
            'price' => $price
        ]);
    }

    // 付费问题退款
    public function refund($userId, $problemId) {
        return $this->request('/cooperation/server/problem/refund', [
            'user_id' => $userId,
            'problem_id' => $problemId
        ]);
    }
}
