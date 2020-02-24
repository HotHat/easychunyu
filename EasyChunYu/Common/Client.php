<?php

/**
 * 通用接口
 * https://www.chunyuyisheng.com/cooperation/open_api/interface/server/#3
 */

namespace EasyChunYu\Common;


use EasyChunYu\Kernel\Support\BaseClient;

class Client extends BaseClient
{


    // 问题追问接口
    public function followUp($userId, $probId, $content) {
        return $this->request('/cooperation/server/problem_content/create',[
            'user_id' => $userId,
            'content' => $content,
            'problem_id' => $probId
        ]);
    }
    // 问题详情接口
    public function problemDetail($data) {
        return $this->request('/cooperation/server/problem/detail', $data);
    }

    // 医生详情接口
    public function doctorDetail($userId, $doctorId) {
        return $this->request('/cooperation/server/problem/detail', [
            'user_id' => $userId,
            'doctor_id' => $doctorId
        ]);
    }

    // 查询问题分配科室接口
    // 该接口可用于查询众包（升级）问题将会被分配的科室号；
    public function dispatchDepart($userId, $ask) {
        return $this->request('/cooperation/server/problem/detail', [
            'user_id' => $userId,
            'ask' => $ask
        ]);
    }

    /**
     * 评价问题接口
     * 服务细则
       1、问题未关闭时，交互3次以上可进行评价
       2、问题关闭后：关闭后30天内可以评价；接收评价的有效期为问题关闭后30天内，超过30天，不能再评价；测试环境的有效期为问题关闭后1小时
       3、评价次数限制：每个问题仅支持接收一次评价数据
     * @param $userId
     * @param $problemId
     * @param $assessInfo
     * @param $content
     * @return array
     */
    public function remark($userId, $problemId, $assessInfo, $content) {
        return $this->request('/cooperation/server/problem/detail', [
            'user_id' => $userId,
            'problemId' => $problemId,
            'assess_info' => $assessInfo,
            'content' => $content
        ]);
    }

    // 问题删除接口
    public function problemDelete($userId, $problemId) {
        return $this->request('/cooperation/server/problem/delete', [
            'user_id' => $userId,
            'problemId' => $problemId,
        ]);
    }

    // 问题删除接口
    public function problemClose($userId, $problemId) {
        return $this->request('/cooperation/server/problem/close', [
            'user_id' => $userId,
            'problemId' => $problemId,
        ]);
    }

    // 我的提问历史
    public function myAsk($userId, $startNum, $count) {
        return $this->request('/cooperation/server/problem/list/my', [
            'user_id' => $userId,
            'start_num' => $startNum,
            'count' => $count
        ]);
    }

}
