<?= helper('form') ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Create Event Occurrence</title>
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
        <h1>Create Event Occurrence</h1>

        <!-- Display validation errors -->
        <?php if (validation_errors()): ?>
            <div class="alert alert-danger"><?= validation_list_errors() ?></div>
        <?php endif; ?>

        
        <?= form_open_multipart(
            '/admin/event-occurrences/create/' . esc($eventId), 
            ['class' => 'form']
        ) ?>

        <!-- Occurrence Information Section -->
        <div class="mb-4">
            <h3 class="section-title">Occurrence Information</h3>

            <!-- Read-only Event field -->
            <div class="form-group">
                <?= form_label('Event ID', 'event_id', ['class' => 'required-field']); ?>

                    <!-- A disabled text input for display -->
                    <input 
                        type="text" 
                        class="form-control" 
                        id="event_id_display" 
                        value="<?= esc($eventId) ?>" 
                        disabled
                    >
                    <!-- A hidden input so the event_id is submitted -->
                    <input 
                        type="hidden" 
                        name="event_id" 
                        value="<?= esc($eventId) ?>"
                    >
            </div>

            <div class="form-group">
                <?= form_label('Occurrence Date', 'occurrence_date', ['class' => 'required-field']); ?>
                <?= form_input([
                    'name'     => 'occurrence_date',
                    'id'       => 'occurrence_date',
                    'class'    => 'form-control',
                    'value'    => set_value('occurrence_date'),
                    'type'     => 'datetime-local',
                    'required' => 'required'
                ]); ?>
                <?= validation_show_error('occurrence_date'); ?>
            </div>

            <div class="form-group">
                <?= form_label('Location', 'location', ['class' => 'required-field']); ?>
                <?= form_input([
                    'name'     => 'location',
                    'id'       => 'location',
                    'class'    => 'form-control',
                    'value'    => set_value('location'),
                    'required' => 'required'
                ]); ?>
                <?= validation_show_error('location'); ?>
            </div>

            <!-- File Upload for Image -->
            <div class="form-group">
                <?= form_label('Upload Image', 'image'); ?>
                <?= form_upload([
                    'name'  => 'image',
                    'id'    => 'image',
                    'class' => 'form-control'
                ]); ?>
                <?= validation_show_error('image'); ?>
            </div>
        </div>

        <div class="form-group">
            <?= form_submit('submit', 'Create Occurrence', ['class' => 'btn btn-success']) ?>
        </div>

        <?= form_close(); ?>
    </div>
</body>
</html>
