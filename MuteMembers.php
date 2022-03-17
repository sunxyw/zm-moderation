<?php

namespace Bot\Module\Moderation;

use Bot\Module\Essential\Base;
use ZM\Annotation\CQ\CQCommand;

class MuteMembers extends Base
{
    /**
     * 禁言用户
     *
     * @CQCommand("mute", alias={"禁言"})
     *
     * @return string
     */
    public function cmdMute(): string
    {
        $target = $this->interact->askForUser('您想禁言谁？');
        $this->bot->setGroupBan(must_ctx()->getGroupId(), $target);
        return "已禁言 $target";
    }

    /**
     * 解除禁言
     *
     * @CQCommand("unmute")
     *
     * @return string
     */
    public function cmdUnmute(): string
    {
        $target = $this->interact->askForUser('您想解除禁言谁？');
        $this->bot->setGroupBan(must_ctx()->getGroupId(), $target, 0);
        return "已解除禁言 $target";
    }

    /**
     * 开启全体禁言
     *
     * @CQCommand("muteall")
     *
     * @return string
     */
    public function cmdMuteAll(): string
    {
        $this->bot->setGroupWholeBan(must_ctx()->getGroupId(), true);
        return '已开启全体禁言';
    }

    /**
     * 关闭全体禁言
     *
     * @CQCommand("unmuteall")
     *
     * @return string
     */
    public function cmdUnmuteAll(): string
    {
        $this->bot->setGroupWholeBan(must_ctx()->getGroupId(), false);
        return '已关闭全体禁言';
    }
}