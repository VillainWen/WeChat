<?php


namespace Villain\WeChat\Contract;


interface EventHandlerInterface {
    public function handle($payload = null);
}