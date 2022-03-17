<?php

namespace Bot\Module\Moderation;

use Bot\Module\Base;
use ZM\Annotation\CQ\CQCommand;

class BanMembers extends Base
{
    /**
     * 封禁用户
     *
     * @CQCommand("ban")
     *
     * @return string
     */
    public function cmdBan(): string
    {
        $target = $this->askForUser('您想封禁谁？');
        $bot = must_ctx()->getRobot();
        // 提出并禁止加群请求，与封禁效果一致
        $bot->setGroupKick(must_ctx()->getGroupId(), $target, true);
        return "已封禁 $target";
    }

    /**
     * 解封用户
     *
     * @CQCommand("unban")
     *
     * @return string
     */
    public function cmdUnban(): string
    {
        $target = $this->askForUser('您想解封谁？');
        $bot = must_ctx()->getRobot();
        // TODO: 实现解封
        // 目前 OBV11 的 API 不支持解封，考虑实现为封禁时提出，并储存封禁的用户ID，在再次加群时自动拒绝
        return "已解封 $target";
    }

    /**
     * 封禁用户，然后立即解除
     * 在部分平台中，此操作会清除最近的消息
     *
     * @return string
     */
    public function cmdSoftBan(): string
    {
        $target = $this->askForUser('您想软封谁？');
        must_ctx()->setMessage("ban $target");
        $this->cmdBan();
        must_ctx()->setMessage("unban $target");
        $this->cmdUnban();
        return "已软封 $target";
    }
}