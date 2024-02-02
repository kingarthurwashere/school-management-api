<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
class UserModelPolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        // Admin has all permissions
        return $user->isAdmin() || $user->isTeacher() || $user->isStudent();
    }

    public function add(User $user)
    {
        // Admin and student have add permission
        return $user->isAdmin() || $user->isStudent();
    }

    public function edit(User $user)
    {
        // Admin and teacher have edit permission
        return $user->isAdmin() || $user->isTeacher();
    }

    public function delete(User $user)
    {
        // Admin has delete permission
        return $user->isAdmin();
    }

    public function viewStudentPage(User $user)
    {
        // Admin, teacher, and student have view permission for student page
        return $user->isAdmin() || $user->isTeacher() || $user->isStudent();
    }

    public function addStudentPage(User $user)
    {
        // Admin and student have add permission for student page
        return $user->isAdmin() || $user->isStudent();
    }

    public function editStudentPage(User $user)
    {
        // Admin and teacher have edit permission for student page
        return $user->isAdmin() || $user->isTeacher();
    }

    public function viewTeacherPage(User $user)
    {
        // Admin and teacher have view permission for teacher page
        return $user->isAdmin() || $user->isTeacher();
    }

    public function viewClassroomPage(User $user)
    {
        // Admin and teacher have view permission for classroom page
        return $user->isAdmin() || $user->isTeacher();
    }
}

