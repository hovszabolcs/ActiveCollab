<?php

namespace App\DTO;

class TaskDTO extends AbstractDTO
{
    public int $id;
    public string $name;
    public string $urlPath = 'url_path';
    public string $createdAt = 'created_on';
    public string $updatedAt  = 'updated_on';
    public string $createdByName = 'created_by_name';
    public string $createdByEmail = 'created_by_email';
    public string $createdById = 'created_by_id';
    public string $assigneeId = 'assignee_id';
    public ?string $assigneeName = 'fake_assignee_name';
    public ?string $assigneeEmail = 'fake_assignee_email';

    public function transformCreatedAt($value) {
        return date('Y-m-d H:i:s', $value);
    }
    public function transformUpdatedAt($value) {
        return date('Y-m-d H:i:s', $value);
    }

}