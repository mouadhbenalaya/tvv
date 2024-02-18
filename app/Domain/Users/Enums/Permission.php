<?php

namespace App\Domain\Users\Enums;

enum Permission: string
{
    case CREATE_ROLE = 'create_role';
    case DELETE_ROLE = 'delete_role';
    case UPDATE_ROLE = 'update_role';
    case ASSIGN_ROLE = 'assign_role';
    case REVOKE_ROLE = 'revoke_role';
    case VIEW_ROLE = 'view_role';
    case VIEW_ALL_ROLES = 'view_all_roles';
    case VIEW_ALL_PERMISSIONS = 'view_all_permissions';
    case VIEW_ALL_USERS = 'view_all_users';
    case VIEW_USER = 'view_user';
    case CREATE_USER = 'create_user';
    case UPDATE_USER = 'update_user';
    case DELETE_USER = 'delete_user';
    case VIEW_ALL_DEPARTMENTS = 'view_all_departments';
    case VIEW_DEPARTMENT = 'view_department';
    case UPDATE_DEPARTMENT = 'update_department';
    case DELETE_DEPARTMENT = 'delete_department';
    case CREATE_DEPARTMENT = 'create_department';
    case ASSIGN_PROFILE = 'assign_profile_to_department';
    case REMOVE_PROFILE = 'remove_profile_from_department';
}
