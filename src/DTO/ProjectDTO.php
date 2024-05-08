<?php

namespace App\DTO;

class ProjectDTO extends AbstractDTO
{
    public int $id;
    public string $name;
    public string $body;
    public string $urlPath = 'url_path';
    public string $createdAt = 'created_on';
    public string $updatedAt  = 'updated_on';

    public function transformCreatedAt($value) {
        return date('Y-m-d H:i:s', $value);
    }
    public function transformUpdatedAt($value) {
        return date('Y-m-d H:i:s', $value);
    }

}