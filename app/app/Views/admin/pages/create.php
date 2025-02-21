<?= helper('form') ?>
<?php
use App\Enum\PageTypeEnum;

// Define options using the enum values
$pageTypeOptions = [
    PageTypeEnum::TYPE_MAIN->value        => 'Main Page',
    PageTypeEnum::TYPE_OCCURRENCE->value  => 'Occurrence Page',
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Create Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        .required-field::after {
            content: " *";
            color: red;
        }
        .section-title {
            border-bottom: 2px solid #ddd;
            margin-bottom: 15px;
            padding-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1>Create Page</h1>
        <?php if (validation_errors()): ?>
            <div class="alert alert-danger">
                <?= validation_list_errors() ?>
            </div>
        <?php endif; ?>
        <?= form_open('/admin/pages/create', ['class' => 'form']) ?>
            <div class="mb-4">
                <h3 class="section-title">Page Information</h3>
                <div class="form-group">
                    <?= form_label('Title', 'title', ['class' => 'required-field']); ?>
                    <?= form_input([
                        'name' => 'title',
                        'id'   => 'title',
                        'class'=> 'form-control',
                        'value'=> set_value('title'),
                        'required' => 'required'
                    ]); ?>
                    <?= validation_show_error('title'); ?>
                </div>
                <div class="form-group">
                    <?= form_label('Subtitle', 'subtitle', ['class' => 'required-field']); ?>
                    <?= form_input([
                        'name' => 'subtitle',
                        'id'   => 'subtitle',
                        'class'=> 'form-control',
                        'value'=> set_value('subtitle')
                    ]); ?>
                    <?= validation_show_error('subtitle'); ?>
                </div>
                <div class="form-group">
                    <?= form_label('Page Type', 'page_type', ['class' => 'required-field']); ?>
                    <?= form_dropdown('page_type', $pageTypeOptions, set_value('page_type'), ['id' => 'page_type', 'class' => 'form-control', 'required' => 'required']); ?>
                    <?= validation_show_error('page_type'); ?>
                </div>
            </div>
            <div class="form-group">
                <?= form_submit('submit', 'Create Page', ['class' => 'btn btn-success']) ?>
            </div>
        <?= form_close(); ?>
    </div>
</body>
</html>
