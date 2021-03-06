<?php
// +----------------------------------------------------------------------
// | [RhaPHP System] Copyright (c) 2017 http://www.rhaphp.com/
// +----------------------------------------------------------------------
// | [RhaPHP] 并不是自由软件,你可免费使用,未经许可不能去掉RhaPHP相关版权
// +----------------------------------------------------------------------
// | Author: Geeson <qimengkeji@vip.qq.com>
// +----------------------------------------------------------------------


namespace app\common\model;


use think\Model;

class Payment extends Model
{
    /**
     * 下单
     * @param string $member_id 会员ID
     * @param string $mid 公众号 ID
     * @param string $money 金额
     * @param string $title 标题信息
     * @param string $callback 回调地址 addonUrl函数生成地址
     * @param string $pay_type 1微信支付、2支付宝
     * @param string $remark 详细|备注
     * @param string $attach 附加信息
     * @return bool|int|string
     */
    public function addPayment($member_id = '', $mid = '', $money = '', $title = '', $callback = '', $pay_type = '1', $remark = '', $attach = '')
    {
        $member = getMember($member_id);
        $data['member_id'] = $member_id;
        $data['openid'] = $member['openid'];
        $data['mpid'] = $mid;
        $data['money'] = $money;
        $data['title'] = $title;
        $data['pay_type'] = $pay_type;
        $data['remark'] = $remark;
        $data['attach'] = $attach;
        $data['callback'] = $callback;
        $data['create_time'] = time();
        $data['order_number'] = time() . rand_string(22, 1);
        $id = $this->insertGetId($data);
        if ($id)
            return $id;
        else
            return false;
    }

    public function getPaymentByFind($where = [])
    {
        return $this->where($where)->find();
    }

    public function refund($where = [])
    {
        return $this->save(['refund' => 1], $where);
    }


}