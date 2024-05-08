<?php

namespace Core;

interface RouterInterface
{
    public function call(): ?Renderable;
}