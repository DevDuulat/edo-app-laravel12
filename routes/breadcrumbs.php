<?php

use App\Models\Category;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Folder;
use App\Models\Document;
use App\Models\DocumentTemplate;
use App\Models\Workflow;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Панель', route('dashboard'));
});

// Admin > Categories
Breadcrumbs::for('admin.categories.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Категории', route('admin.categories.index'));
});

// Admin > Categories > Create
Breadcrumbs::for('admin.categories.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.categories.index');
    $trail->push('Создать категорию', route('admin.categories.create'));
});

// Admin > Categories > Edit
Breadcrumbs::for('admin.categories.edit', function (BreadcrumbTrail $trail, Category $category) {
    $trail->parent('admin.categories.index');
    $trail->push('Редактировать: ' . $category->name, route('admin.categories.edit', $category));
});

// Список шаблонов документов
Breadcrumbs::for('admin.document-templates.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Шаблоны документов', route('admin.document-templates.index'));
});

// Создание нового шаблона
Breadcrumbs::for('admin.document-templates.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.document-templates.index');
    $trail->push('Создать шаблон', route('admin.document-templates.create'));
});

// Редактирование существующего шаблона
Breadcrumbs::for('admin.document-templates.edit', function (BreadcrumbTrail $trail, ?Category $category = null) {
    $trail->parent('admin.document-templates.index');
    if ($category) {
        $trail->push('Редактировать: ' . $category->name, route('admin.document-templates.edit', $category));
    }
});

// Просмотр существующего шаблона
Breadcrumbs::for('admin.document-templates.show', function (BreadcrumbTrail $trail, ?Category $category = null) {
    $trail->parent('admin.document-templates.index');
    if ($category) {
        $trail->push('Просмотр: ' . $category->name, route('admin.document-templates.show', $category));
    }
});



// Список шаблонов документов
Breadcrumbs::for('admin.documents.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Документы', route('admin.documents.index'));
});

// Создание нового шаблона
Breadcrumbs::for('admin.documents.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.documents.index');
    $trail->push('Создать документ', route('admin.documents.create'));
});

// Редактирование существующего шаблона
Breadcrumbs::for('admin.documents.edit', function (BreadcrumbTrail $trail, ?Category $category = null) {
    $trail->parent('admin.documents.index');
    if ($category) {
        $trail->push('Редактировать: ' . $category->name, route('admin.documents.edit', $category));
    }
});

// Просмотр существующего шаблона
Breadcrumbs::for('admin.documents.show', function (BreadcrumbTrail $trail, ?Category $category = null) {
    $trail->parent('admin.documents.index');
    if ($category) {
        $trail->push('Просмотр: ' . $category->name, route('admin.documents.show', $category));
    }
});


// Admin > Departments
Breadcrumbs::for('admin.departments.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Департаменты', route('admin.departments.index'));
});

Breadcrumbs::for('admin.departments.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.departments.index');
    $trail->push('Создать департамент', route('admin.departments.create'));
});

Breadcrumbs::for('admin.departments.edit', function (BreadcrumbTrail $trail, Department $department) {
    $trail->parent('admin.departments.index');
    $trail->push('Редактировать: ' . $department->name, route('admin.departments.edit', $department));
});

// Admin > Employees
Breadcrumbs::for('admin.employees.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Сотрудники', route('admin.employees.index'));
});

Breadcrumbs::for('admin.employees.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.employees.index');
    $trail->push('Добавить сотрудника', route('admin.employees.create'));
});

Breadcrumbs::for('admin.employees.edit', function (BreadcrumbTrail $trail, Employee $employee) {
    $trail->parent('admin.employees.index');
    $trail->push('Редактировать: ' . $employee->name, route('admin.employees.edit', $employee));
});

// Admin > Folders
Breadcrumbs::for('admin.folders.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Папки', route('admin.folders.index'));
});

Breadcrumbs::for('admin.folders.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.folders.index');
    $trail->push('Создать папку', route('admin.folders.create'));
});

Breadcrumbs::for('admin.folders.edit', function (BreadcrumbTrail $trail, Folder $folder) {
    $trail->parent('admin.folders.index');
    $trail->push('Редактировать: ' . $folder->name, route('admin.folders.edit', $folder));
});

// Admin > Workflows
Breadcrumbs::for('admin.workflows.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Рабочие процессы', route('admin.workflows.index'));
});

Breadcrumbs::for('admin.workflows.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.workflows.index');
    $trail->push('Создать процесс', route('admin.workflows.create'));
});

Breadcrumbs::for('admin.workflows.edit', function (BreadcrumbTrail $trail, Workflow $workflow) {
    $trail->parent('admin.workflows.index');
    $trail->push('Редактировать: ' . $workflow->name, route('admin.workflows.edit', $workflow));
});

// Outgoing workflows
Breadcrumbs::for('admin.outgoing.workflows', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Исходящие процессы', route('admin.outgoing.workflows'));
});

// Incoming workflows
Breadcrumbs::for('admin.incoming.workflows', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Входящие процессы', route('admin.incoming.workflows'));
});