<?= helper('form') ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Update Event</title>
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
        <h1>Update Event</h1>

        <!-- Gallery Link for the Event -->
        <a href="<?= base_url('admin/galleries/events/' . esc($event['id'])) ?>" class="btn btn-info mb-3">
            View Gallery for This Event
        </a>

        <!-- Display validation errors -->
        <?php if (validation_errors()): ?>
            <div class="alert alert-danger">
                <?= validation_list_errors() ?>
            </div>
        <?php endif; ?>

        <?= form_open("/admin/events/edit/{$event['id']}", ['class' => 'form']) ?>
        <?= form_hidden('_method', 'PATCH') ?>

        <!-- Section: Event Information -->
        <div class="mb-4">
            <h3 class="section-title">Event Information</h3>

            <div class="form-group">
                <?= form_label('Name', 'name', ['class' => 'required-field']); ?>
                <?= form_input([
                    'name'     => 'name',
                    'id'       => 'name',
                    'class'    => 'form-control',
                    'value'    => set_value('name', $event['name']),
                    'required' => 'required'
                ]); ?>
                <?= validation_show_error('name'); ?>
            </div>

            <div class="form-group">
                <?= form_label('Description', 'description'); ?>
                <?= form_textarea([
                    'name'  => 'description',
                    'id'    => 'description',
                    'class' => 'form-control',
                    'value' => set_value('description', $event['description'])
                ]); ?>
                <?= validation_show_error('description'); ?>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <?= form_label('Slug', 'slug', ['class' => 'required-field']); ?>
                    <?= form_input([
                        'name'  => 'slug',
                        'id'    => 'slug',
                        'class' => 'form-control',
                        'value' => set_value('slug', $event['slug'])
                    ]); ?>
                    <?= validation_show_error('slug'); ?>
                </div>

                <div class="form-group col-md-6">
                    <?= form_label('Short URL', 'shorturl', ['class' => 'required-field']); ?>
                    <?= form_input([
                        'name'  => 'shorturl',
                        'id'    => 'shorturl',
                        'class' => 'form-control',
                        'value' => set_value('shorturl', $event['shorturl'])
                    ]); ?>
                    <?= validation_show_error('shorturl'); ?>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <?= form_label('QR Code', 'qrcode'); ?>
                    <?= form_input([
                        'name'  => 'qrcode',
                        'id'    => 'qrcode',
                        'class' => 'form-control',
                        'value' => set_value('qrcode', $event['qrcode'])
                    ]); ?>
                    <?= validation_show_error('qrcode'); ?>
                </div>
                <div class="form-group col-md-6">
                    <?= form_label('Social Links', 'social_links'); ?>
                    <?= form_input([
                        'name'  => 'social_links',
                        'id'    => 'social_links',
                        'class' => 'form-control',
                        'value' => set_value('social_links', $event['social_links'])
                    ]); ?>
                    <?= validation_show_error('social_links'); ?>
                </div>
            </div>
        </div>

        <!-- Section: Organizer Information -->
        <div class="mb-4">
            <h3 class="section-title">Organizer Information</h3>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <?= form_label('Organizer First Name', 'organizer_first_name', ['class' => 'required-field']); ?>
                    <?= form_input([
                        'name'     => 'organizer_first_name',
                        'id'       => 'organizer_first_name',
                        'class'    => 'form-control',
                        'value'    => set_value('organizer_first_name', $event['organizer_first_name']),
                        'required' => 'required'
                    ]); ?>
                    <?= validation_show_error('organizer_first_name'); ?>
                </div>
                <div class="form-group col-md-6">
                    <?= form_label('Organizer Last Name', 'organizer_last_name', ['class' => 'required-field']); ?>
                    <?= form_input([
                        'name'     => 'organizer_last_name',
                        'id'       => 'organizer_last_name',
                        'class'    => 'form-control',
                        'value'    => set_value('organizer_last_name', $event['organizer_last_name']),
                        'required' => 'required'
                    ]); ?>
                    <?= validation_show_error('organizer_last_name'); ?>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <?= form_label('Organizer Phone', 'organizer_phone'); ?>
                    <?= form_input([
                        'name'  => 'organizer_phone',
                        'id'    => 'organizer_phone',
                        'class' => 'form-control',
                        'value' => set_value('organizer_phone', $event['organizer_phone'])
                    ]); ?>
                    <?= validation_show_error('organizer_phone'); ?>
                </div>
                <div class="form-group col-md-6">
                    <?= form_label('Organizer Email', 'organizer_email', ['class' => 'required-field']); ?>
                    <?= form_input([
                        'name'     => 'organizer_email',
                        'id'       => 'organizer_email',
                        'type'     => 'email',
                        'class'    => 'form-control',
                        'value'    => set_value('organizer_email', $event['organizer_email']),
                        'required' => 'required'
                    ]); ?>
                    <?= validation_show_error('organizer_email'); ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <?= form_submit('submit', 'Update Event', ['class' => 'btn btn-success']) ?>
        </div>

        <?= form_close(); ?>
    </div>
</body>
</html>
