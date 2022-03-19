<?php

namespace Bot\Module\Moderation;

use Bot\Module\Essential\Base;
use ZM\Annotation\CQ\CQCommand;

class BanMembers extends Base
{
    /**
     * 封禁用户
     *
     * @CQCommand("ban", alias={"封禁"})
     *
     * @return string
     */
    public function cmdBan(): string
    {
        $target = $this->interact->askForUser($this->trans('ban_who'));
        // 提出并禁止加群请求，与封禁效果一致
        $this->bot->setGroupKick(must_ctx()->getGroupId(), $target->id, true);
        return $this->trans('banned', $target->toMention());
    }

    /**
     * 解封用户
     *
     * @CQCommand("unban", alias={"解封", "解禁", "解除封禁"})
     *
     * @return string
     */
    public function cmdUnban(): string
    {
        $target = $this->interact->askForUser($this->trans('unban_who'));
        // TODO: 实现解封
        // 目前 OBV11 的 API 不支持解封，考虑实现为封禁时提出，并储存封禁的用户ID，在再次加群时自动拒绝
        return $this->trans('unbanned', $target->toMention());
    }

    /**
     * 封禁用户，然后立即解除
     * 在部分平台中，此操作会清除最近的消息
     *
     * @return string
     */
    public function cmdSoftBan(): string
    {
        $target = $this->interact->askForUser('您想软封谁？');
        $this->getContext()->setMessage('ban' . $target->toMention());
        $this->cmdBan();
        $this->getContext()->setMessage('unban' . $target->toMention());
        $this->cmdUnban();
        return '已软封' . $target->toMention();
    }
}