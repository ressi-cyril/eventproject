<?= helper('form') ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le Bloc de Contenu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        .required-field::after { content: " *"; color: red; }
        .section-title { border-bottom: 2px solid #ddd; margin-bottom: 15px; padding-bottom: 5px; }
        .img-preview { margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1>Modifier le Bloc de Contenu</h1>
        <?php if (validation_errors()): ?>
            <div class="alert alert-danger"><?= validation_list_errors() ?></div>
        <?php endif; ?>
        <?= form_open_multipart("/admin/page-contents/edit/{$content['id']}", ['class' => 'form']) ?>
        <?= form_hidden('_method', 'PATCH') ?>
            <div class="mb-4">
                <h3 class="section-title">Informations du Bloc</h3>
                <div class="form-group">
                    <?= form_label('Texte', 'content_text', ['class' => 'required-field']); ?>
                    <?= form_textarea([
                        'name'  => 'content_text',
                        'id'    => 'content_text',
                        'class' => 'form-control',
                        'value' => set_value('content_text', $content['content_text'])
                    ]); ?>
                    <?= validation_show_error('content_text'); ?>
                </div>
                <div class="form-group">
                    <?= form_label('Image actuelle', 'current_image'); ?>
                    <?php if (!empty($content['content_image'])): ?>
                        <div class="img-preview">
                            <img src="<?= base_url('uploads/page_contents/' . esc($content['content_image'])) ?>" alt="Content Image" width="100">
                        </div>
                    <?php else: ?>
                        <p>Aucune image</p>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <?= form_label('Télécharger une nouvelle image', 'content_image'); ?>
                    <?= form_upload([
                        'name'  => 'content_image',
                        'id'    => 'content_image',
                        'class' => 'form-control'
                    ]); ?>
                    <?= validation_show_error('content_image'); ?>
                </div>
            </div>
            <div class="form-group">
                <?= form_submit('submit', 'Mettre à jour le Bloc', ['class' => 'btn btn-success']) ?>
            </div>
        <?= form_close(); ?>
    </div>
</body>
</html>
