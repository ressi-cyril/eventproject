<?= helper('form') ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Update Event Occurrence</title>
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
        .img-preview {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1>Update Event Occurrence</h1>

        <!-- Gallery Link -->
        <a href="<?= base_url('admin/galleries/occurrences/' . esc($occurrence['id'])) ?>" class="btn btn-info mb-3">
            View Gallery for This Occurrence
        </a>

        <!-- Display validation errors -->
        <?php if (validation_errors()): ?>
            <div class="alert alert-danger"><?= validation_list_errors() ?></div>
        <?php endif; ?>

        <?= form_open_multipart("/admin/event-occurrences/edit/{$occurrence['id']}", ['class' => 'form']) ?>
        <?= form_hidden('_method', 'PATCH') ?>

        <!-- Occurrence Information Section -->
        <div class="mb-4">
            <h3 class="section-title">Occurrence Information</h3>

            <!-- Event (Read-only) -->
            <div class="form-group">
                <?= form_label('Event ID', 'event_id', ['class' => 'required-field']); ?>
                
                <!-- Show event_id as read-only but still submit via hidden input -->
                <input
                    type="text"
                    class="form-control"
                    value="<?= esc($occurrence['event_id']) ?>"
                    disabled
                />
                <input
                    type="hidden"
                    name="event_id"
                    value="<?= esc($occurrence['event_id']) ?>"
                />
            </div>

            <div class="form-group">
                <?= form_label('Occurrence Date', 'occurrence_date', ['class' => 'required-field']); ?>
                <?= form_input([
                    'name'     => 'occurrence_date',
                    'id'       => 'occurrence_date',
                    'class'    => 'form-control',
                    'value'    => set_value('occurrence_date', $occurrence['occurrence_date']),
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
                    'value'    => set_value('location', $occurrence['location']),
                    'required' => 'required'
                ]); ?>
                <?= validation_show_error('location'); ?>
            </div>

            <!-- Current Image Preview -->
            <div class="form-group">
                <?= form_label('Current Image', 'current_image'); ?>
                <?php if (!empty($occurrence['image'])): ?>
                    <div class="img-preview">
                        <img src="<?= base_url('uploads/event_occurrences/' . esc($occurrence['image'])) ?>" alt="Occurrence Image" width="100">
                    </div>
                <?php else: ?>
                    <p>No image available</p>
                <?php endif; ?>
            </div>

            <!-- New Image Upload Field -->
            <div class="form-group">
                <?= form_label('Upload New Image', 'image'); ?>
                <?= form_upload([
                    'name'  => 'image',
                    'id'    => 'image',
                    'class' => 'form-control'
                ]); ?>
                <?= validation_show_error('image'); ?>
            </div>
        </div>

        <div class="form-group">
            <?= form_submit('submit', 'Update Occurrence', ['class' => 'btn btn-success']) ?>
        </div>

        <?= form_close(); ?>
    </div>
</body>
</html>
