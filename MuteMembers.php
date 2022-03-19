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
        $target = $this->interact->askForUser($this->trans('mute_who'));
        $this->bot->setGroupBan($this->getContext()->getGroupId(), $target->id);
        return $this->trans('muted', $target->toMention());
    }

    /**
     * 解除禁言
     *
     * @CQCommand("unmute", alias={"解除禁言", "取消禁言"})
     *
     * @return string
     */
    public function cmdUnmute(): string
    {
        $target = $this->interact->askForUser($this->trans('unmute_who'));
        $this->bot->setGroupBan($this->getContext()->getGroupId(), $target->id, 0);
        return $this->trans('unmuted', $target->toMention());
    }

    /**
     * 开启全体禁言
     *
     * @CQCommand("muteall", alias={"全体禁言"})
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
     * @CQCommand("unmuteall", alias={"关闭全体禁言", "解除全体禁言"})
     *
     * @return string
     */
    public function cmdUnmuteAll(): string
    {
        $this->bot->setGroupWholeBan(must_ctx()->getGroupId(), false);
        return '已关闭全体禁言';
    }
}